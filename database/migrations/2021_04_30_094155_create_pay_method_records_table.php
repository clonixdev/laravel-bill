<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayMethodRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_method_records', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pay_method_id')->unsigned()->nullable();
            $table->bigInteger('invoice_id')->unsigned()->nullable();
            $table->integer('status')->unsigned()->nullable();
            $table->text('payload')->nullable();
            $table->string('comments')->nullable();
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
        Schema::dropIfExists('pay_method_records');
    }
}