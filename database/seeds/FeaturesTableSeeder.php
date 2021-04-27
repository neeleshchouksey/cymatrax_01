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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('features')->truncate();
        DB::table("features")->insert([["feature"=>"Dashboard"],["feature"=>"free-subscription"],["feature"=>"users"],["feature"=>"admins"],["feature"=>"roles"],["feature"=>"file-delete-setting"]]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
