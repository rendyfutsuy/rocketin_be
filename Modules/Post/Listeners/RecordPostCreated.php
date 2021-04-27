<?php

namespace Modules\Post\Listeners;

use Modules\Post\Events\PostCreated;
use Modules\Auth\Models\UserActivity;
use Modules\Auth\ServiceManagers\RecordActivityManager;

class RecordPostCreated
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
    public function handle(PostCreated $post)
    {
        $post->post->user->recordLastOnline();

        $this->recordActivity
            ->setOldData([])
            ->setNewData($post->post->toArray())
            ->withDetails()
            ->save(
                UserActivity::POST_CREATED,
                UserActivity::POST,
                $post->post->user_id
            );
    }
}

