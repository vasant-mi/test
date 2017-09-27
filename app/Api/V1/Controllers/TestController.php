<?php
namespace App\Api\V1\Controllers;
use App\Api\ApiController;

Class TestController extends ApiController {
    public function test(){
        return $this->response->accepted();
    }
}