<?php

namespace App\Mail;

use App\Language;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $resetPassword;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $resetPassword)
    {
        $this->user = $user;
        $this->resetPassword = $resetPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $this->to($this->user)->subject(__('mail.subjects.forgot_password', ['USERNAME' => ucfirst($this->user->username)]));
        //$template = ($this->user->language_id == Language::$ENGLISH) ? 'english' : 'arabic';
        $template = 'english';
        return $this->view('mails/userForgotPassword.'.$template, ['user' => $this->user, 'resetPassword' => $this->resetPassword]);
    }
}
