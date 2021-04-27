<?php

namespace Modules\Post\Providers;

use Modules\Post\Listeners\LogPostRejected;
use Modules\Post\Listeners\RecordPostWaited;
use Modules\Post\Listeners\AssignMediaToPost;
use Modules\Post\Listeners\RecordPostCreated;
use Modules\Post\Listeners\RecordPostDeleted;
use Modules\Post\Listeners\RecordPostUpdated;
use Modules\Post\Listeners\RevertPostToDraft;
use Modules\Post\Listeners\RecordPostRejected;
use Modules\Post\Listeners\SendWaitListUpdate;
use Modules\Post\Listeners\RecordPostPublished;
use Modules\Post\Listeners\RecordPostPublisher;
use Modules\Post\Listeners\SendPublishNotification;
use Modules\Post\Listeners\SendRejectedNoteToUserEmail;
use Modules\Post\Listeners\RevertPostToDraftNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'post_created' => [
            RecordPostCreated::class,
            AssignMediaToPost::class,
        ],

        'post_updated' => [
            RevertPostToDraft::class,
            RecordPostUpdated::class,
            RevertPostToDraftNotification::class,
        ],

        'post_deleted' => [
            RecordPostDeleted::class,
        ],

        'post_published' => [
            RecordPostPublished::class,
            RecordPostPublisher::class,
            SendPublishNotification::class,
        ],

        'post_waited' => [
            RecordPostWaited::class,
            SendWaitListUpdate::class,
        ],

        'post_rejected' => [
            RecordPostRejected::class,
            LogPostRejected::class,
            SendRejectedNoteToUserEmail::class,
        ],
    ];
}
