<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlanEndDateAndPricePerMinuteToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'plan_end_date'))
        {
            Schema::table('user', function (Blueprint $table)
            {
                $table->dateTime('plan_end_date')->nullable();
                $table->double('price_per_minute')->default(0)->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn('plan_end_date');
            $table->dropColumn('price_per_minute');
        });
    }
}
