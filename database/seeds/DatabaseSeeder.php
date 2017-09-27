<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StatusTableSeeder::class);
        $this->call(AdminTableSeeder::class);
        $this->call(PackageTableSeeder::class);
        $this->call(CountryTableSeeder::class);
    }
}
