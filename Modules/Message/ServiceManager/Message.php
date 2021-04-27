<?php

namespace Modules\Message\ServiceManager;

use Illuminate\Support\Facades\Config;
use Modules\Message\Exceptions\ProviderException;
use Modules\Message\ServiceManager\Providers\NexmoProvider;
use Modules\Message\ServiceManager\Contracts\ProviderContract;

class Message
{    
    protected $providers = [
        'nexmo' => NexmoProvider::class,
    ];

    public function provider(): ProviderContract
    {
        try {
            return app()->make($this->providers[Config::get('message.provider')]);
        } catch (\Throwable $th) {
            throw new ProviderException(__('message::provider.fail'));
        }
    }
}
