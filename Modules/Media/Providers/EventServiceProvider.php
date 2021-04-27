<?php

namespace Modules\Media\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'media_created' => [
            // 
        ],
        'media_updated' => [
            // 
        ],
        'media_deleted' => [
            // 
        ],
    ];
}
