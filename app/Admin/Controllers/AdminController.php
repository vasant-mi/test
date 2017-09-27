<?php

namespace App\Admin\Controllers;

use App\Admin;
use App\Rarity;
use App\Range;
use App\User;
use App\Series;
use App\Character;
use App\Team;
use App\Mail\AdminForgotPasswordMail;
use App\Status;
use Dingo\Api\Event\RequestWasMatched;
use Illuminate\Http\Request;
use Crypt;

class AdminController extends \App\Admin\AdminController
{

    public function dashboard()
    {
        $totalRange = Range::whereIn('status_id', [Status::$ACTIVE])->count();
        $totalRarity = Rarity::whereIn('status_id', [Status::$ACTIVE])->count();
        $totalUsers = User::whereIn('status_id', [Status::$ACTIVE])->count();
        $totalSeries = Series::whereIn('status_id', [Status::$ACTIVE])->count();
        $totalCharacter = Character::whereIn('status_id', [Status::$ACTIVE])->count();
        $totalTeam = Team::whereIn('status_id', [Status::$ACTIVE])->count();

        return view('admin/dashboard', [
            'totalRange' => $totalRange,
            'totalRarity' => $totalRarity,
            'totalUsers' => $totalUsers,
            'totalSeries' => $totalSeries,
            'totalTeam' => $totalTeam,
            'totalCharacter' => $totalCharacter]);
    }

    public function cms()
    {
        return view('admin/cms');
    }

    public function getChangePassword()
    {
        return view('admin/changePassword');
    }

    public function login(Request $request)
    {
        $this->validateRequest('login_post');
        $credential = $request->only(['email', 'password']);
        /** @var Admin $admin */
        $admin = Admin::whereEmail($request['email'])->whereStatusId(Status::$ACTIVE)->first();
        if ($admin && \Hash::check($credential['password'], $admin->password)) {
            session([\Config::get('admin.session') => $admin]);
            return redirect('Admin');
        } else {
            return redirect('Admin/login')->with(\Config::get('admin.message'), [
                'type' => 'danger',
                'message' => __('admin/login.email_and_password_does_not_match')
            ]);
        }
    }

    public function forgotPassword()
    {

        return view('admin/forgot_password');
    }

    public function sendForgotPasswordMail(Request $request)
    {
        /** @var Admin $admin */
        $admin = Admin::whereEmail($request->get('email'))->first();
        if(!$admin){
            return back()->with(\Config::get('admin.message'), [
                'type' => 'danger',
                'message' => __('admin/login.email_does_not_exist')
            ]);
        }
        $admin->save();
        $token = Crypt::encrypt($admin->id);
        $admin->token = $token;
        \Mail::to($admin)->queue(new AdminForgotPasswordMail($admin, $admin->token));
        return redirect(url('Admin/forgot-password'))->with(\Config::get('admin.message'), [
            'type' => 'success',
            'message' => __('admin/login.reset_password_link_send_your_mail')
        ]);
    }

    public function resetPassword($id){
        /** @var Admin $admin */

        $userId = Crypt::decrypt($id);
        $admin = Admin::whereId($userId)->first();
        if (!$admin) {
            return redirect(url('Admin/forgot-password'))->with(\Config::get('admin.message'), [
                'type' => 'danger',
                'message' => __('admin/login.email_does_not_exist')
            ]);
        }
        return view('admin/reset_password', [
            'id' => $id
        ]);
    }

    public function resetPasswordSave(Request $request, $id)
    {
        /** @var Admin $admin */

        $userId = Crypt::decrypt($id);
        $admin = Admin::whereId($userId)->first();
        if (!$admin) {
            return redirect(url('Admin/forgot-password'))->with(\Config::get('admin.message'), [
                'type' => 'danger',
                'message' => __('admin/login.email_does_not_exist')
            ]);
        }
        $admin->password = \Hash::make($request->get('password'));
        $admin->save();
        return redirect(url('Admin/login'))->with(\Config::get('admin.message'), [
            'type' => 'success',
            'message' => __('admin/login.your_password_reset_successfully')
        ]);
    }

    public function changePassword(Request $request)
    {
        $admin = \Session::get(\Config::get('admin.session'));
        /** @var Admin $admin */
        $admin = Admin::find($admin->id);
        if ($request->get('old_password') != '' && $request->get('new_password') != '') {
            if (\Hash::check($request->get('old_password'), $admin->password)) {
                $admin->password = \Hash::make($request->get('new_password'));
                $admin->save();
                session([\Config::get('admin.session') => $admin]);
                return redirect('Admin/change-password')->with([
                    'status' => '200',
                    'message' => __('admin/admin.change_password_success')
                ]);
            } else {
                return redirect('Admin/change-password')->with([
                    'status' => '400',
                    'message' => __('admin/admin.old_password_doesnt_match')
                ]);
            }
        } else {
            return redirect('Admin/change-password')->with([
                'status' => '400',
                'message' => [
                    __('admin/admin.password_is_required'),
                    __('admin/admin.old_password_is_required')
                ]
            ]);
        }

    }

    public function checkPassword(Request $request)
    {
        $adminData = \Session::get(\Config::get('admin.session'));
        $adminData = Admin::find($adminData->id);
        /** @var Admin $admins */
        $admins = Admin::whereId($adminData->id)->wherePassword($request['old_password'])->count();
        if ($admins > 0) {
            return 'true';
        } else {
            return 'false';
        }
    }
}