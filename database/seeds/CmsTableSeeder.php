<?php

use Illuminate\Database\Seeder;

class CmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cmses = [
            [
                'id' => 1,
                'title' => 'About Us',
                'cms_desc' => "About us description goes here",
                'meta_keyword' => "about-us",
                'meta_desc' => 'about-us-description',
                'status_id' => \App\Status::$ACTIVE,

            ],
            [
                'id' => 2,
                'title' => 'Terms & Conditions',
                'cms_desc' => 'Terms & condition description goes here',
                'meta_keyword' => 'terms-and-conditions',
                'meta_desc'=> 'terms-and-condition-description',
                'status_id' => \App\Status::$ACTIVE,
            ],
            [
                'id' => 3,
                'title' => 'Privacy Policy',
                'cms_desc' => 'Privacy policy description goes here',
                'meta_keyword' => 'privacy-policy',
                'meta_desc' => 'privacy-policy-description',
                'status_id' => \App\Status::$ACTIVE,
            ]
        ];

        foreach ($cmses as $cms){
            $cmsObj = \App\Cms::findOrNew($cms['id']);
            $cmsObj->title = $cms['title'];
            $cmsObj->cms_desc = $cms['cms_desc'];
            $cmsObj->meta_keyword = $cms['meta_keyword'];
            $cmsObj->meta_desc = $cms['meta_desc'];
            $cmsObj->status_id = $cms['status_id'];
            $cmsObj->save();
        }
    }
}
