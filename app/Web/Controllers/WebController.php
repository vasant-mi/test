<?php
namespace App\Web\Controllers;


class WebController extends \App\Web\WebController{

    public function dashboard(){
        return view('web/welcome');
    }

}