<?php

namespace Modules\Wordpress\ServiceManager;

use Illuminate\Support\Facades\Config;
use Modules\Wordpress\Exceptions\ProviderException;
use Modules\Wordpress\ServiceManager\Contracts\WpAuthContract;

class Authentication
{    
    protected $providers = [
        'basic' => Providers\BasicProvider::class,
        // 'jwt' => Providers\JwtProvider::class,
    ];

    public function provider(): WpAuthContract
    {
        try {
            return app()->make($this->providers[Config::get('wordpress.provider')]);
        } catch (\Throwable $th) {
            throw new ProviderException(__('wordpress::provider.fail'));
        }
    }
}
