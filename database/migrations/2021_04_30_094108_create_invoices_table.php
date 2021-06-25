<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('code')->nullable();
            $table->string('code_format')->nullable();
            $table->string('external_code')->nullable();
            $table->string('tracking_code')->nullable();

            $table->string('seller_name')->nullable();
            $table->string('seller_tax_id')->nullable();
            $table->string('seller_last_name')->nullable();
            $table->string('seller_email')->nullable();
            $table->string('seller_phone')->nullable();
            $table->string('seller_address')->nullable();
            $table->string('seller_city')->nullable();
            $table->string('seller_state')->nullable();
            $table->string('seller_country')->nullable();



            $table->string('buyer_name')->nullable();
            $table->string('buyer_tax_id')->nullable();
            $table->string('buyer_last_name')->nullable();
            $table->string('buyer_email')->nullable();
            $table->string('buyer_phone')->nullable();
            $table->string('buyer_address')->nullable();
            $table->string('buyer_city')->nullable();
            $table->string('buyer_state')->nullable();
            $table->string('buyer_country')->nullable();

            $table->integer('status')->unsigned();
            $table->integer('pay_status')->unsigned()->nullable();
            $table->integer('ship_status')->unsigned()->nullable();

            $table->double('sub_total')->nullable();
            $table->double('tax')->nullable();
            $table->double('ship')->nullable();
            $table->double('total')->nullable();
         



            $table->decimal('ship_lat', 10, 8)->nullable();
            $table->decimal('ship_lng', 11, 8)->nullable();
            $table->string('ship_address')->nullable();
            $table->string('ship_city')->nullable();
            $table->string('ship_state')->nullable();
            $table->string('ship_country')->nullable();


            $table->timestamp('invoice_date')->nullable();
            $table->timestamp('invoice_date_range')->nullable();
            $table->timestamp('expire_at')->nullable();

            $table->boolean('is_subscription')->default(0);
            $table->boolean('has_shipping')->default(0);
            $table->bigInteger('currency_id')->unsigned();
            $table->bigInteger('pay_method_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}