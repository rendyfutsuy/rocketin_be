<?php

namespace Modules\Post\Listeners;

use Modules\Post\Events\PostDeleted;
use Modules\Auth\Models\UserActivity;
use Modules\Auth\ServiceManagers\RecordActivityManager;

class RecordPostDeleted
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
    public function handle(PostDeleted $post)
    {
        $post->post->user->recordLastOnline();

        $this->recordActivity
            ->setOldData($post->post->toArray())
            ->setNewData([])
            ->withDetails()
            ->save(
                UserActivity::POST_DELETED,
                UserActivity::POST,
                $post->post->user_id
            );
    }
}

