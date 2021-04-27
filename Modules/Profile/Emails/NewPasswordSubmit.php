<?php

namespace Modules\Profile\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewPasswordSubmit extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** @var \Modules\Auth\Models\User */
    public $user;

    public $subject = "Ubah Password Kolom Baris";

    /**
     * Create a new message instance.
     *
     * @param  \Modules\Auth\Models\User  $user
     * @return void
     */
    public function __construct($user)
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
        return $this->from(Config::get('mail.default_email'))
            ->view('profile::mail.new-password')
            ->with([
                'userName' => $this->user->username,
                'lang' => $this->user->getLocale(),
            ]);
    }
}
