<?php

namespace Modules\Post\Listeners;

use Modules\Post\Models\Post;
use Illuminate\Support\Facades\Mail;
use Modules\Auth\Models\UserActivity;
use Modules\Post\Events\PostPublished;
use Modules\Post\Emails\PostPublication;
use Modules\Auth\ServiceManagers\RecordActivityManager;

class SendPublishNotification
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
        Mail::to($post->post->user->email)
            ->send(new PostPublication($post->post));

        $post->post->user->recordLastOnline();

        $this->recordActivity
            ->withDetails([
                'message' => __('post.publish.notification', [
                    'title' => $post->post->title,
                ], $post->post->user->getLocale()),
                'post_id' => $post->post->id,
                'post_title' => $post->post->title,
            ])
            ->save(
                UserActivity::POST_PUBLICATION_NOTIFY,
                UserActivity::POST,
                $post->post->user_id
            );
    }
}

