<?php

namespace Modules\Wordpress\ServiceManager\Providers;

use Illuminate\Support\Facades\Config;
use Modules\Wordpress\ServiceManager\Contracts\WpAuthContract;

class BasicProvider implements WpAuthContract
{
    /** render header for Wordpress Authentication. */
    public function  getHeaders(...$params): array
    {
        if (empty($params) || empty(collect($params)->first())) {
            return [
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode(Config::get('wordpress.basic_auth_username') .':'. Config::get('wordpress.basic_auth_password')),
            ];
        }

        $token = $params['0'];

        return [
            'Accept' => 'application/json',
            'Authorization' => 'Basic ' . $token
        ];
    }
}
