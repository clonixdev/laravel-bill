<?php

namespace Clonixdev\LaravelBill\PayMethodAdapters;

use Clonixdev\LaravelBill\Models\PayMethodAdapter;

class TestAdapter extends PayMethodAdapter 
{
    

    /*
        Params: 
        - invoice

        Return:
        - 
    */
    public static function checkout($invoice,$params,$payment){

        $pay_method = $invoice->payMethod;
        $config = $pay_method->getConfig();


        $payment->payload_out = "TEST-".time();
        $payment->save();

       $url_notif =  route('pay-method.external-link',['pay_method_id' => $pay_method->id, 'payment_id'=> $payment->id ]);

       // URL a la que deseas hacer la solicitud cURL
        $url_notif = route('pay-method.external-link', [
            'pay_method_id' => $pay_method->id,
            'payment_id' => $payment->id
        ]);

        // Inicializar sesión cURL
        $ch = curl_init();

        // Configurar las opciones de la solicitud
        curl_setopt($ch, CURLOPT_URL, $url_notif);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Para recibir la respuesta como una cadena
        // Puedes configurar otras opciones según sea necesario, como encabezados adicionales, etc.

        // Ejecutar la solicitud
        $response = curl_exec($ch);

        // Verificar si hubo algún error
        if ($response === false) {
            echo 'Error de cURL: ' . curl_error($ch);
        } else {
            // La respuesta de la solicitud
            echo 'Respuesta: ' . $response;
        }

        // Cerrar sesión cURL
        curl_close($ch);

        return "PASARELA DE PAGO DE PRUEBA";

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


        $payment_id = isset($request["payment_id"]) ? $request["payment_id"] : null;

        if(!$payment_id ){
            return [ 'success' => false , 'message' => 'No existe el registro de pago.'];
        }
       $payment = self::getPayment($payment_id);


       if(!$payment){
            return [ 'success' => false , 'message' => 'No existe el registro de pago.', 'payment_id' => $payment_id];
        }

        $invoice_id = $payment->invoice_id;
        $record->invoice_id = $invoice_id;

        $invoice_class = config('bill.models.invoice');
        $invoice = $invoice_class::where('id',$invoice_id)->first();
        if(!$invoice){

            return [ 'success' => false , 'message' => 'No existe la factura.', 'payment_id' => $payment_id , 'invoice_id' => $invoice_id];
        }


       return [ 'success' => true , 'payment_id' => $payment_id ,'invoice_id' => $invoice_id , 'pay_status' => $invoice_class::PAY_STATUS_PAID,'transaction' => time()  ];



    }
}