<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     * 
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paymentdetails', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email');
            $table->string('currencycode');
            $table->string('totalprice');
            $table->string('timestamp');
            $table->string('transationId');
            $table->string('patmentstatus');
            $table->double('duration', 15, 8);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('card_id')->nullable();

            
            // $table->bigInteger('cardnumber');
            // $table->bigInteger('expirymonth');
            // $table->bigInteger('expiryyear');
            // $table->bigInteger('cvvnumber');
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
        Schema::dropIfExists('paymentdetails');
    }
}
