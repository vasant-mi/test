<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminObj = \App\Admin::findOrNew(1);
        $adminObj->id = 1;
        $adminObj->first_name = 'Smasher';
        $adminObj->last_name = 'Admin';
        $adminObj->email = 'admin@gmail.com';
        $adminObj->password = Hash::make('123456');
        $adminObj->status_id = \App\Status::$ACTIVE;
        $adminObj->save();
    }
}
