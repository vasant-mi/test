<?php

namespace App\Mail;

use App\Language;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Message;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $age = Carbon::parse($this->user->date_of_birth)->diffInYears(Carbon::now());
        if($age <= 13){
            $this->user->email = $this->user->parent_email;
        }

        $this->to($this->user)->subject(__('mail.subjects.verification_code', ['USERNAME' => $this->user->username]));
        //$template = ($this->user->language_id == Language::$ENGLISH) ? 'english' : 'arabic';
        $template =  'english';
        return $this->view('mails/verificationCodeEmail.'.$template, ['user' => $this->user]);
    }
}
