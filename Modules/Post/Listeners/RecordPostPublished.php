<?php

namespace Modules\Post\Listeners;

use Modules\Post\Models\Post;
use Modules\Auth\Models\UserActivity;
use Modules\Post\Events\PostPublished;
use Modules\Auth\ServiceManagers\RecordActivityManager;

class RecordPostPublished
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
    public function handle(PostPublished $post)
    {
        $post->post->user->recordLastOnline();

        $this->recordActivity
            ->setOldData([
                'status' => Post::DRAFTED,
                'post_id' => $post->post->id,
            ])
            ->setNewData([
                'status' => Post::PUBLISHED,
                'post_id' => $post->post->id,
            ])
            ->withDetails()
            ->save(
                UserActivity::POST_PUBLISHED,
                UserActivity::POST,
                $post->post->user_id
            );
    }
}

