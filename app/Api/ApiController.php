<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Language;
use App\User;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

/**
 * Class ApiController
 * @package App\Api
 */
class ApiController extends Controller
{

    use Helpers;

    public function __construct(Request $request)
    {

    }

    /**
     * @param $api
     */
    public function validateRequest($api)
    {

        $version = app('request')->version();

        $rules = app('config')->get("api_validations.{$api}.{$version}.rules");

        if (!$rules) {
            $rules = app('config')->get("api_validations.{$api}.v1.rules");
        }
        $messages = app('config')->get("api_validations.{$api}.{$version}.messages");
        if (!$messages) {
            $messages = app('config')->get("api_validations.{$api}.v1.messages");
        }

        if ($rules && $messages) {
            $payload = app('request')->only(array_keys($rules));
            $messages = collect($messages)->map(function ($message){
                return __($message);
            })->toArray();
            $validator = app('validator')->make($payload, $rules, $messages);

            if ($validator->fails()) {
                $this->error($validator->errors()->first(), 400);
            }
        }
    }

    /**
     * @param array $codes
     * @return string
     */
    public static function generateVerificationToken(&$codes = []){
        $code = str_random(20);
        $user = User::whereVerificationToken($code)->first();
        if($user && in_array($code, $codes)){
            return ApiController::generateVerificationToken($codes[] = $code);
        } else {
            return $code;
        }
    }
}
