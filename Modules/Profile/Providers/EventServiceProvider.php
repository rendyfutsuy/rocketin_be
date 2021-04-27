<?php

namespace Modules\Profile\Providers;

use Modules\Profile\Events\AvatarUploaded;
use Modules\Profile\Events\ProfileUpdated;
use Modules\Profile\Listeners\RecordAvatarLog;
use Modules\Profile\Listeners\RecordGenderLog;
use Modules\Profile\Listeners\RecordBirthdayLog;
use Modules\Profile\Listeners\RecordFullNameLog;
use Modules\Profile\Listeners\RecordUsernameLog;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ProfileUpdated::class => [
            RecordBirthdayLog::class,
            RecordUsernameLog::class,
            RecordFullNameLog::class,
            RecordGenderLog::class,
        ],

        AvatarUploaded::class => [
            RecordAvatarLog::class,
        ],
    ];
}
