<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSubscription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_subscription', function (Blueprint $table) {
/*            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('subscription_type_id')->nullable();
            $table->tinyInteger('status')->default(1)->nullable();
            $table->date('activation_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();*/
             $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->tinyInteger('subscription')->comment('1-subscribed,0-not subscribed');
            $table->unsignedInteger('subscription_id')->nullable();
            $table->unsignedInteger('plan_id');
            $table->string('plan_name')->nullable();
            $table->unsignedInteger('no_of_clean_file');
            $table->double('price_per_minute')->nullable();
            $table->string('charges')->nullable();
            $table->dateTime('plan_start_date')->nullable();
            $table->dateTime('plan_end_date')->nullable();
            $table->tinyInteger('status')->comment('0=>cancel, 1=>active')->nullable();
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
        Schema::dropIfExists('user_subscription');
    }
}
