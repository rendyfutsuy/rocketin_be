<?php

namespace Modules\Auth\ServiceManagers;

use Modules\Auth\Models\User;
use Modules\Auth\ServiceManagers\Provider;

class Phone
{
    /** @var Provider */ 
    protected $provider;

    public function __construct(Provider $provider)
    {
        $this->provider = $provider;
    }

    public function sendOtpMessage(User $user, string $phoneNumber)
    {
        $message = trans('auth::sms_messages.otp_message', [
            'code' => $resetPhone->getActivationCode(),
        ]);

        $type = "otp";

        $phones = create_array_for_phone($resetPhone->phone);

        $this->provider->send($user, $message, $type, $phones['country_id']);
    }
}
