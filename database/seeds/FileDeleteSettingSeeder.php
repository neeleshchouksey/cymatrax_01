<?php

use Illuminate\Database\Seeder;

class FileDeleteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("file_delete_setting")->insert(["id"=>1,"days"=>15]);
    }
}
