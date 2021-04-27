<?php

namespace Modules\Auth\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Config;

class UserActivationEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** @var \Modules\Auth\Models\User */
    protected $user;

    // public $subject = "Aktivasi Akun Kolom Baris";

    /**
     * Create a new message instance.
     *
     * @param  \Modules\Auth\Models\User  $user
     * @return void
     */
    public function __construct($user)
    {
        $this->subject = __('auth::email.activation.subject', [], $user->getLocale());
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
            ->view('auth::mail.activation_code')
            ->with([
                'userName' => $this->user->name,
                'activationCode' => $this->user->getActivationCode(),
                'encodedEmail' => base64url_encode($this->user->email),
                'secondUrl' => route('account.activation.from.links', [
                        'act' => base64url_encode($this->user->getActivationCode()),
                        'e' => base64url_encode($this->user->email)
                    ]),
                'lang' => $this->user->getLocale(),
            ]);
    }
}
