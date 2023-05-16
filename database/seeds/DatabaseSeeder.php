<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UserTableSeeder::class);
         $this->call(FeaturesTableSeeder::class);
         $this->call(FreeSubscriptionTableSeeder::class);
         $this->call(AdminRolesTableSeeder::class);
         $this->call(AdminRoleFeaturesTableSeeder::class);
         $this->call(AdminTableSeeder::class);
    }
}
