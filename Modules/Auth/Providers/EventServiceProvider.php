<?php

namespace Modules\Auth\Providers;

use Modules\Auth\Events\AccountMerged;
use Modules\Auth\Events\NewPhoneRegistered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        AccountMerged::class => [
            // 
        ],

        NewPhoneRegistered::class => [
            // 
        ],
    ];
}
