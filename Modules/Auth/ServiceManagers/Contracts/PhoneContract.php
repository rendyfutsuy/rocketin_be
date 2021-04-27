<?php

namespace Modules\Auth\ServiceManagers\Contracts;

use Modules\Auth\Models\User;

interface PhoneContract
{
    public function send(User $user, string $message, string $type, string $phoneNumber): void;
}