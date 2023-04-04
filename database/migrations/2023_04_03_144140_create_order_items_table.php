<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->uuid('order_id')->nullable();
            $table->integer('tax_type')->unsigned()->nullable();
            $table->string('description');
            $table->double('qty',14)->nullable();
            $table->string('unit')->nullable();
            $table->double('price',14)->nullable();
            $table->double('amount',14);
            $table->double('tax',14);
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}