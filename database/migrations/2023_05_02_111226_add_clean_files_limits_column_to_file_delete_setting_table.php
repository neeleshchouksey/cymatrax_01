<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCleanFilesLimitsColumnToFileDeleteSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('file_delete_setting', function (Blueprint $table) {
            $table->integer('clean_files_limits')->default(0)->after('days');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('file_delete_setting', function (Blueprint $table) {
            //
        });
    }
}
