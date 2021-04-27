<?php

namespace Modules\Auth\ServiceManagers\Providers;

use Modules\Auth\Models\User;
use Modules\Auth\ServiceManagers\Contracts\PhoneContract;

class NexmoProvider implements PhoneContract
{
    /** @var mixed */
    public $return = null;

    public function send(User $user, string $message, string $type, string $phoneNumber): void
    {
        # code...
    } 
    
    /** @return mixed */
    public function return()
    {
        return $this->return;
    }
}