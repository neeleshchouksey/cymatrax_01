<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminRoleFeaturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("admin_role_features")->insert([["role_id"=>1,"feature_id"=>1],
            ["role_id"=>1,"feature_id"=>2],
            ["role_id"=>1,"feature_id"=>3],
            ["role_id"=>1,"feature_id"=>4],
            ["role_id"=>1,"feature_id"=>5]]);

    }
}