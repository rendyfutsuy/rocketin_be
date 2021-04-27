<?php

namespace Modules\Post\Listeners;

use Modules\Post\Models\Post;
use Modules\Auth\Models\UserActivity;
use Modules\Post\Events\PostWaited;
use Modules\Auth\ServiceManagers\RecordActivityManager;

class RecordPostWaited
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
    public function handle(PostWaited $post)
    {
        $post->post->user->recordLastOnline();

        $this->recordActivity
            ->withDetails([
                'post_id' => $post->post->id,
                'post_title' => $post->post->title,
            ])
            ->save(
                UserActivity::POST_WAITED,
                UserActivity::POST,
                $post->post->user_id
            );
    }
}

