<?php

use Illuminate\Database\Seeder;

class FeaturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("features")->insert([["feature"=>"Dashboard"],["feature"=>"free-subscription"],["feature"=>"users"],["feature"=>"admins"],["feature"=>"roles"]]);

    }
}
