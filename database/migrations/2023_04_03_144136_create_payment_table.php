<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigInteger('pay_method_id')->unsigned()->nullable();
            $table->uuid('invoice_id')->nullable();
            $table->integer('status')->unsigned()->nullable();
            $table->integer('pay_status')->unsigned()->nullable();
            $table->string('comments')->nullable();
            $table->text('adapter_result')->nullable();
            $table->timestamps();

            $table->foreign('pay_method_id')->references('id')->on('pay_methods')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment');
    }
}