<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSubscriptionTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscription_type', function (Blueprint $table) {
            $table->string('text_1')->nullable()->after('no_of_clean_file');
            $table->string('text_2')->nullable()->after('text_1');
            $table->string('text_3')->nullable()->after('text_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
