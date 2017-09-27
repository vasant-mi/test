<?php

namespace App\Api\V1\Controllers;

use App\Api\ApiController;
use App\Api\V1\Transformers\CountryTransformer;
use App\Api\V1\Transformers\UserTransformer;
use App\Country;
use App\Mail\ForgotPasswordMail;
use App\Mail\VerificationCodeMail;
use App\Status;
use App\User;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;

Class UserController extends ApiController
{

    public function signup(Request $request)
    {

        $requestParams = $request->only(['username', 'password', 'parent_email', 'email', 'country_id', 'date_of_birth', 'newsletter']);

        $this->validateRequest('signup');

        $age = Carbon::parse($requestParams['date_of_birth'])->diffInYears(Carbon::now());
        
        if($age <= 13){
            $validator = \Validator::make($requestParams, ['parent_email' => 'required|email'], [
                'parent_email.required' => 'Please enter your parent\'s email address.',
                'parent_email.email' => 'Please enter valid email Address.',
            ]);
            if ($validator->fails()) {
                $this->error(__($validator->errors()->first()), 400);
            }
        }

        $user = new User();
        $user->username = $requestParams['username'];
        $user->email = $requestParams['email'];
        $user->parent_email = $requestParams['parent_email'];
        $user->date_of_birth = Carbon::parse($requestParams['date_of_birth'])->toDateTimeString();
        $user->password = \Hash::make($requestParams['password']);
        $user->country_id = $requestParams['country_id'];
        $user->status_id = Status::$UNVERIFIED;
        $user->verification_token = ApiController::generateVerificationToken();
        $user->save();


        $token = \JWTAuth::fromUser($user);

        if ($user->status_id != Status::$ACTIVE) {
            switch ($user->status_id) {
                case Status::$DELETED:
                    $this->error(__('api/login.this_account_has_been_deleted'), 400);
                    break;
                default:
                    \Mail::queue(new VerificationCodeMail($user));
                    $this->error(__('api/login.account_verification_pending'), 402);
                    break;
            }
        }

        return $this->response->item($user, new UserTransformer)->setMeta([
            'status' => '200',
            'message' => __('api/login.signup_successfully'),
            'token' => $token
        ]);
    }

    public function login(Request $request)
    {
        $this->validateRequest('login');
        $credentials = $request->only(['email', 'password']);

        /** @var User $user */
        $user = User::whereEmail($credentials['email'])->first();
        if ($user && Hash::check($credentials['password'], $user->password)) {
            if ($user->status_id != Status::$ACTIVE) {
                switch ($user->status_id) {
                    case Status::$DELETED:
                        $this->error(__('api/login.this_account_has_been_deleted'), 400);
                        break;
                    default:
                        $this->error(__('api/login.please_verify_your_account'), 402);
                        break;
                }
            }

            $user->save();
            return $this->response->item($user, new UserTransformer)->setMeta([
                'status' => '200',
                'message' => __('api/login.login_successfully'),
                'token' => \JWTAuth::fromUser($user)
            ]);
        } else {
            $this->error(__('api/login.invalid_email_or_password'), 400);
        }

    }


    public function countries(Request $request)
    {

        /** @var User $user */
        $country = Country::OrderBy('name','asc')->whereStatusId(Status::$ACTIVE)->get();
        return $this->response->collection($country, new CountryTransformer())->setMeta([
            'status' => '200',
            'message' => __('api/login.country_successfully'),

        ]);


    }


    public function resetPassword(Request $request)
    {
        $this->validateRequest('reset_password');
        $requestParams = $request->only(['reset_pass_token', 'password']);
        /** @var User $user */
        $user = User::whereResetPassToken($requestParams['reset_pass_token'])->first();

        if ($user) {
            $user->password = Hash::make($requestParams['password']);
            $user->reset_pass_token = '';
            $user->save();
            //Todo:: Send mail to user "Password change successfully."
            return $this->response->item($user, new UserTransformer)->setMeta([
                'status' => '200',
                'message' => __('api/login.password_reset_successfully'),
            ]);
        } else {
            $this->error(__('api/login.invalid_reset_password_token'), 400);
        }
    }

    public function forgotPassword(Request $request)
    {
        $this->validateRequest('forgot_password');
        $email = $request->get('email');
        $resetPassword = $this->generateResetPasswordToken();
        /** @var User $user */
        $user = User::whereEmail($email)->whereStatusId(Status::$ACTIVE)->first();
        if ($user) {
            $user->password = Hash::make($resetPassword);
            $user->save();

            \Mail::queue(new ForgotPasswordMail($user, $resetPassword));

            return [
                'data' => [],
                'meta' => [
                    'status' => '200',
                    'message' => __('api/login.forgot_password_message')
                ]
            ];
        } else {
            $this->error(__('api/login.invalid_email_or_password'), 400);
        }
    }

    public function generateResetPasswordToken()
    {
        return $resetPassToken = chr(rand(65, 90)) . rand(1000, 9999) . chr(rand(65, 90));

    }

    public function changePassword(Request $request)
    {
        $this->validateRequest('change_password');
        $requestParams = $request->only(['old_password', 'password']);
        $user = \Auth::user();
        if (Hash::check($requestParams['old_password'], $user->password)) {
            $user->password = Hash::make($requestParams['password']);
            $user->save();
            return $this->response->item($user, new UserTransformer)->setMeta([
                'status' => '200',
                'message' => __('api/login.password_changed_successfully'),
            ]);
        } else {
            $this->error(__('api/login.invalid_old_password'), 400);
        }
    }

    public function changeProfile(Request $request)
    {
        $this->validateRequest('change_profile');
        $requestParams = $request->only(['username', 'country_id', 'newsletter','date_of_birth']);

        $user = \Auth::user();
        $user->username = $requestParams['username'];
        $user->country_id = $requestParams['country_id'];
        $user->date_of_birth = Carbon::parse($requestParams['date_of_birth'])->toDateTimeString();
        $user->newsletter = $requestParams['newsletter'];
        $user->save();

        return $this->response->item($user, new UserTransformer)->setMeta([
            'status' => '200',
            'message' => __('api/login.profile_updated_successfully')
        ]);
    }
}