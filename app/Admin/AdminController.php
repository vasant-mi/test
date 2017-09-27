<?php

namespace App\Admin;

use App\Http\Controllers\Controller;
use App\Admin;
use Illuminate\Http\Request;

/**
 * Class ApiController
 * @package App\Api
 */
class AdminController extends Controller
{
    public static $request;

    function __construct(Request $request)
    {
        $requestParams = $request->only('per_page');
        AdminController::$request = $request;
        if($requestParams['per_page'] > 0){
            \Config::set('admin.per_page', $requestParams['per_page']);
        }
    }

    public function validateRequest($api)
    {
        $rules = app('config')->get("admin_validations.{$api}.rules");

        if (!$rules) {
            $rules = app('config')->get("admin_validations.{$api}.rules");
        }
        $messages = app('config')->get("admin_validations.{$api}.messages");

        if ($rules && $messages) {
            $payload = app('request')->only(array_keys($rules));
            $validator = app('validator')->make($payload, $rules, $messages);
            if ($validator->fails()) {
                $this->error($validator->errors()->first(), 400);
            }
        }
    }

    public static function generateAdminToken(&$codes = []){
        $code = str_random(20);
        $user = Admin::whereToken($code)->first();
        return $user && in_array($code, $codes) ? Admin\Controllers\AdminController::generateAdminToken($codes[] = $code) : $code;
    }

    public static function pagination($paginationObject){
        return view('admin/pagination', ['paginationObject' => $paginationObject]);
    }
}
