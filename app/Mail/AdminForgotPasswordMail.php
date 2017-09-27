<?php

namespace App\Mail;

use App\Admin;
use App\Language;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $admin;
    protected $userToken;

    public function __construct(Admin $admin, $userToken)
    {
        $this->admin = $admin;
        $this->userToken = $userToken;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
           return $this->view('mails/adminForgotPassword.mail')->with([
                'admin' => $this->admin,'userToken' => $this->userToken
            ])->subject('Forgot Your Password!');
    }
}
