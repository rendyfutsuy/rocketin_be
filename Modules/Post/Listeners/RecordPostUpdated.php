<?php

namespace Modules\Post\Listeners;

use Modules\Post\Events\PostUpdated;
use Modules\Auth\Models\UserActivity;
use Modules\Auth\ServiceManagers\RecordActivityManager;

class RecordPostUpdated
{
    /** @var RecordActivityManager */
    public $recordActivity;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(RecordActivityManager $recordActivity)
    {
        $this->recordActivity = $recordActivity;
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(PostUpdated $post)
    {
        $post->current->user->recordLastOnline();

        $this->recordActivity
            ->setOldData($post->previous->toArray())
            ->setNewData($post->current->toArray())
            ->withDetails()
            ->save(
                UserActivity::POST_UPDATED,
                UserActivity::POST,
                $post->current->user_id
            );
    }
}

