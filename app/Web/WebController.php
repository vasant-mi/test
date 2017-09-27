<?php

namespace App\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class ApiController
 * @package App\Api
 */
class WebController extends Controller
{
    function __construct(Request $request)
    {
        $requestParams = $request->only('per_page');
        if($requestParams['per_page'] > 0){
            \Config::set('admin.per_page', $requestParams['per_page']);
        }
    }
}
