<?php

use Illuminate\Database\Seeder;

class PackageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ["id"=>1,"title"=>"1 pack","status_id"=>1],
            ["id"=>2,"title"=>"2 pack","status_id"=>1],
            ["id"=>3,"title"=>"8 pack","status_id"=>1],
            ["id"=>4,"title"=>"Playsets","status_id"=>1],
            ["id"=>5,"title"=>"Smasher Tin","status_id"=>1],
        ];

        foreach($statuses as $s) {
            $status = new \App\Found_in_package();
            $status->title = $s['title'];
            $status->status_id = \App\Status::$ACTIVE;
            $status->save();
        }
    }
}
