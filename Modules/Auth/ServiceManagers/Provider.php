<?php

namespace Modules\Auth\ServiceManagers;

use Modules\Auth\Models\User;
use Illuminate\Support\Facades\Config;
use Modules\Auth\Exceptions\ProviderException;
use Modules\Auth\ServiceManagers\Contracts\PhoneContract;

class Provider
{
    protected $providers = [
        'nexmo' => Providers/NexmoProvider::class,
        // 'wa' => Providers/WaProvider::class
    ];
   
    /**
     * @param  string||null $provider
     */
    public function provider($provider = null): PhoneContract
    {
        $provider = $provider ?? Config::get('auth.sms_provider');
        try {
            return app()->make($this->providers[$provider]);
        } catch (\Throwable $th) {
            throw new ProviderException(__('auth::provider.fail'));
        }
    }
}
