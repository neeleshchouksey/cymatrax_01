<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ConstantSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $value = [
            [
                "id" => 1,
                "key" => 'free_subscription_days',
                "value" => 30,
                "created_at"=>now(),
                "updated_at"=>now()
            ],
            [
                "id" => 2,
                "key" => 'clean_files_days',
                "value" => 15,
                "created_at"=>now(),
                "updated_at"=>now()
            ],
            [
                "id" => 3,
                "key" => 'clean_files_limits',
                "value" => 5,
                "created_at"=>now(),
                "updated_at"=>now()
            ],
            [
                "id" => 4,
                "key" => 'time_on_disk',
                "value" => 11,
                "created_at"=>now(),
                "updated_at"=>now()
            ],
            [
                "id" => 5,
                "key" => 'file_limit_upload',
                "value" => 5,
                "created_at"=>now(),
                "updated_at"=>now()
            ],
            [
                "id" => 6,
                "key" => 'cost_per_minute',
                "value" => 5,
                "created_at"=>now(),
                "updated_at"=>now()
            ],
        ];
        DB::table('constant_settings')->truncate();
        DB::table('constant_settings')->insert($value);
    }
}
