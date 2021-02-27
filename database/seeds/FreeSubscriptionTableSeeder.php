<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FreeSubscriptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("free_subscription")->insert(["id"=>1,"days"=>30]);
    }
}
