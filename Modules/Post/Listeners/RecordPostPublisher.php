<?php

namespace Modules\Post\Listeners;

use Modules\Post\Models\Post;
use Modules\Auth\Models\UserActivity;
use Modules\Post\Events\PostPublished;
use Modules\Auth\ServiceManagers\RecordActivityManager;

class RecordPostPublisher
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
            ->withDetails([
                'post_id' => $post->post->id,
                'post_title' => $post->post->title,
                'publisher_id' => auth()->id(),
            ])
            ->save(
                UserActivity::POST_PUBLISHER,
                UserActivity::POST,
                $post->post->user_id
            );
    }
}

