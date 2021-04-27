<?php

namespace Modules\Admin\Providers;

use Modules\Admin\Events\UserUpdated;
use Modules\Admin\Events\NewAdminRegistered;
use Modules\Admin\Listeners\RecordUserEnabled;
use Modules\Admin\Listeners\RecordUserDisabled;
use Modules\Admin\Listeners\RecordNewAdminCreation;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserUpdated::class => [
            RecordUserDisabled::class,
            RecordUserEnabled::class,
        ],

        NewAdminRegistered::class => [
            RecordNewAdminCreation::class,
        ],
    ];
}
