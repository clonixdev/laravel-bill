<?php

namespace Clonixdev\LaravelBill\PayMethodAdapters;

use Clonixdev\LaravelBill\Models\PayMethodAdapter;
use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;

class MercadoPagoAdapter extends PayMethodAdapter 
{
    


    public static function getTestUser($pay_method) {
        $config = $pay_method->getConfig();


        if (!isset($config->access_token)) {
            return false;
        }
        SDK::setAccessToken($config->access_token);

        $body = array(
            "json_data" => array(
                "site_id" => "MLA"
            )
        );
        $result = \MercadoPago\SDK::post('/users/test_user', $body);
        die(var_dump($result));
    }
    

    /*
        Params: 
        - invoice

        Return:
        - 
    */
    public static function checkout($invoice,$params,$payment){

        $pay_method = $invoice->payMethod;
        $config = $pay_method->getConfig();

        if (!isset($config->access_token)) {
            die("ACCESS TOKEN NOT SET");
        }


        SDK::setAccessToken($config->access_token);


        $preference = new Preference();

        $mpitems = [];

        foreach ($invoice->items as $iitem) {
            $item = new Item();
            $item->id = $iitem->id;
            $item->title = $iitem->description;
            $item->quantity = $iitem->qty;
            $item->unit_price = $iitem->price;
            $mpitems[] = $item;
        }

        $preference->items = $mpitems;

        $preference->auto_return = "all";
        /* $preference->payment_methods = array(
          "excluded_payment_types" => array(
          array("id" => "credit_card")
          ),
          "installments" => 12
          ); */


        $preference->external_reference = $payment->id;
        $preference->notification_url = route('pay-method.external-link');
        $preference->back_urls = array(
            "success" => route('invoices.show'),
            "failure" => route('invoices.show'),
            "pending" => route('invoices.show'),
        );


        $payer = new \MercadoPago\Payer();
        $payer->name = $invoice->buyer_name;
        $payer->surname = $invoice->buyer_last_name;
        $payer->email = trim($invoice->buyer_email);
        $payer->phone = array(
            "number" => trim($invoice->buyer_phone),
        );
        $preference->payer = $payer;


        $preference->save(); # Save the preference and send the HTTP Request to create

        $payment->payload_out = json_encode($preference->toArray());
        $payment->save();
        if ($config->sandbox) {
            return $preference->sandbox_init_point;
        }
        return $preference->init_point;


    }


    /*
        Params: 
        - record

        Return:
        - [ 'status' => 1 | 2 | 3 , 'transaction' => 'XXXXXXX' ]
    */
    public static function onMessage($request,$pay_method,$record){




        $merchant_order = null;
        $config = $pay_method->getConfig();
        SDK::setAccessToken($config->access_token);



        $type = $_GET["type"];
        if ($_GET["topic"])
            $type = $_GET["topic"];
        else if ($_GET["type"])
            $type = $_GET["type"];

        if (is_null($type)) {
           return [ 'success' => false , 'message' => 'Transacción inválida'];
        }

        $request_data_id = $request->data_id;
       

        switch ($type) {

            case "payment":
                $payment = \MercadoPago\Payment::find_by_id($request_data_id);

                $merchant_order = \MercadoPago\MerchantOrder::find_by_id($payment->order->id);
                break;
            /* case "plan":
              $plan = \MercadoPago\Plan::find_by_id($_POST["id"]);
              break;
              case "subscription":
              $plan = \MercadoPago\Subscription::find_by_id($_POST["id"]);
              break;
              case "invoice":
              $plan = \MercadoPago\Invoice::find_by_id($_POST["id"]);
              break; */
            case "merchant_order":
                $merchant_order = \MercadoPago\MerchantOrder::find_by_id($_GET["id"]);
                break;
        }


 
        $payment_id = $merchant_order->external_reference;

       $payment = self::getPayment($payment_id);
       

       if(!$payment){
      
        return [ 'success' => false , 'message' => 'No existe el registro de pago.', 'payment_id' => $payment_id];
    }


        if(!$record){
      
            return [ 'success' => false , 'message' => 'No existe el registro.', 'payment_id' => $payment_id];
        }

        $invoice_id = $record->invoice_id;

        $invoice_class = config('bill.invoice_model');
        $invoice = $invoice_class::where('id',$invoice_id)->first();
        if(!$invoice){
      
            return [ 'success' => false , 'message' => 'No existe la factura.', 'payment_id' => $payment_id];
        }
    

        $cancel = false;
        $paid_amount = 0;
        if($merchant_order && $merchant_order->payments && is_array($merchant_order->payments)){
            foreach ($merchant_order->payments as $payment) {
                if ($payment->status == 'approved') {
                    $paid_amount += $payment->transaction_amount;
                }
                if ($payment->status == 'rejected' || $payment->status == 'cancelled') {
                    $cancel = true;
                }
            }
        }
  
        // If the payment's transaction amount is equal (or bigger) than the merchant_order's amount you can release your items
        if ($paid_amount >= $merchant_order->total_amount) {
            return [ 'success' => true , 'payment_id' => $payment_id ,'invoice_id' => $invoice_id , 'pay_status' => $invoice_class::PAY_STATUS_PAID , 'transaction' => $merchant_order->id ];
        } else {
            if ($cancel) {
                return [ 'success' => true , 'payment_id' => $payment_id, 'invoice_id' => $invoice_id , 'pay_status' => $invoice_class::PAY_STATUS_REJECT , 'transaction' => $merchant_order->id ];
            } else {
                return [ 'success' => true , 'payment_id' => $payment_id, 'invoice_id' => $invoice_id , 'pay_status' => $invoice_class::PAY_STATUS_PENDING , 'transaction' => $merchant_order->id ];
            }
        }

    }
}