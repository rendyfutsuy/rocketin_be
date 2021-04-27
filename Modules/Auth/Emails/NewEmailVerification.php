<?php

namespace Modules\Auth\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewEmailVerification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** @var \Modules\Auth\Models\User */
    public $user;

    /** @var \Modules\Auth\Models\ResetEmail */
    public $emailReset;

    public $subject = "Ubah Email Kolom Baris";

    /**
     * Create a new message instance.
     *
     * @param  \Modules\Auth\Models\User  $user
     * @param  \Modules\Auth\Models\ResetEmail  $emailReset
     * @return void
     */
    public function __construct($user, $emailReset)
    {
        $this->user = $user;
        $this->emailReset = $emailReset;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(Config::get('mail.default_email'))
            ->view('auth::mail.reset-email')
            ->with([
                'userName' => $this->user->username,
                'lang' => $this->user->getLocale(),
                'activationCode' => $this->user->resetEmails->first()->activation_code,
                'resetFormLink' => route('api.auth.reset.email.update', [
                    'user_id' => $this->user->id,
                    'email' => base64url_encode($this->user->email),
                    'lang' => $this->user->getLocale(),
                ]),
            ]);
    }
}
