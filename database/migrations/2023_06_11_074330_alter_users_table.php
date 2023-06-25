<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->smallInteger('user')->nullable()->tiny(true)->change();
            $table->integer('is_verified')->default(0)->after('email_verified_at');
            $table->integer('google_id')->nullable()->after('is_verified');
            $table->dateTime('email_sent_at')->nullable()->after('google_id');
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
