<?php

namespace Modules\Post\Listeners;

use Modules\Post\Models\Post;
use Modules\Auth\Models\UserActivity;
use Modules\Post\Events\PostRejected;
use Modules\Auth\ServiceManagers\RecordActivityManager;

class RecordPostRejected
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
    public function handle(PostRejected $post)
    {
        auth()->user()->recordLastOnline();

        $this->recordActivity
            ->withDetails([
                'post_id' => $post->post->id,
                'post_title' => $post->post->title,
                'rejected_note' => $post->request->note,
            ])
            ->save(
                UserActivity::POST_REJECTED,
                UserActivity::POST,
                auth()->id()
            );
    }
}

