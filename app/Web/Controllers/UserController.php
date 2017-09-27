<?php
namespace App\Web\Controllers;

use App\Status;
use App\User;
use Illuminate\Http\Request;

class UserController extends WebController {


    public function verifyUser($token){
        /** @var User $user*/
        $user = User::whereVerificationToken($token)->first();
        if($user){
            $user->status_id = Status::$ACTIVE;
            $user->verification_token = '';
            $user->save();
            return view('web.thankyou', [
                'title' => __('web/master.success'),
                'message' => __('web/master.your_account_verify_successfully'),
                'type' => 'success',
            ]);
        } else {
            return redirect('/');
        }
    }

}