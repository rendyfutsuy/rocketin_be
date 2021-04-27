<?php

namespace Modules\Auth\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class UserResetPassword extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** @var \Modules\Auth\Models\User */
    protected $user;

    // public $subject = "Ubah kata sandi Akun Kolom Baris";

    /**
     * Create a new message instance.
     *
     * @param  \Modules\Auth\Models\User  $user
     * @return void
     */
    public function __construct($user)
    {
        $this->subject = __('auth::email.reset_password.subject', [], $user->getLocale());
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(Config::get('mail.default_email'))
            ->view('auth::mail.reset-password-with-activation-code')
            ->with([
                'userName' => $this->user->username,
                'activationCode' => $this->user->getActivationCode(),
                'encodedEmail' => base64url_encode($this->user->email),
                'lang' => $this->user->getLocale(),
                'resetFormLink' => route('auth.reset.password.form', [
                    'user_id' => $this->user->id,
                    'email' => base64url_encode($this->user->email),
                    'lang' => $this->user->getLocale(),
                ]),
            ]);
    }
}
