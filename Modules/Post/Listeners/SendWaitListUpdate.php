<?php

namespace Modules\Post\Listeners;

use Modules\Auth\Models\User;
use Modules\Post\Models\Post;
use Modules\Post\Events\PostWaited;
use Illuminate\Support\Facades\Mail;
use Modules\Auth\Models\UserActivity;
use Modules\Post\Emails\PostWaitList;
use Modules\Auth\ServiceManagers\RecordActivityManager;

class SendWaitListUpdate
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
        $emails = User::whereIn('level', [
            User::EDITOR,
            User::ADMIN,
        ])->get()->pluck('email')->toArray();

        foreach ($emails as $email) {
            Mail::to($email)
                ->send(new PostWaitList($post->post));
        }

        $post->post->user->recordLastOnline();

        $this->recordActivity
            ->withDetails([
                'message' => __('post.waited.notification', [
                    'title' => $post->post->title,
                ], $post->post->user->getLocale()),
                'post_id' => $post->post->id,
                'post_title' => $post->post->title,
            ])
            ->save(
                UserActivity::POST_WAITED_NOTIFY,
                UserActivity::POST,
                $post->post->user_id
            );
    }
}

