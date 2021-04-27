<?php

namespace Modules\Auth\Models\Traits;

trait WordpressAuth
{    
    public function getToken(): string
    {
        return base64_encode(config('wordpress.basic_auth_username') . ':' .config('wordpress.basic_auth_password'));
    }
}