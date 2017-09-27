<?php

use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ["id"=>1,"name"=>"active","description"=>"Item is active"],
            ["id"=>2,"name"=>"inactive","description"=>"Item is inactive"],
            ["id"=>3,"name"=>"deleted","description"=>"Item is deleted"],
            ["id"=>4,"name"=>"unverified","description"=>"User is unverified"],
            ["id"=>99,"name"=>"empty","description"=>"Empty entry"],
        ];

        foreach($statuses as $s) {
            $status = new \App\Status();
            $status->id = $s['id'];
            $status->name = $s['name'];
            $status->description = $s['description'];
            $status->save();
        }
    }
}
