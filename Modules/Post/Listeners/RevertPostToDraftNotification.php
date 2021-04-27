<?php

namespace Modules\Post\Listeners;

use Modules\Auth\Models\User;
use Modules\Post\Models\Post;
use Illuminate\Support\Facades\Mail;
use Modules\Post\Emails\PostRedraft;
use Modules\Post\Events\PostUpdated;
use Modules\Auth\Models\UserActivity;
use Modules\Wordpress\ServiceManager\Wordpress;

class RevertPostToDraftNotification
{
    /** @var Wordpress */
    public $wordpress;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Wordpress $wordpress)
    {
        $this->wordpress = $wordpress;
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(PostUpdated $edit)
    {
        $emails = [];

        if ($edit->previous->status == Post::DRAFTED || empty($edit->previous->wp_post_id)) {
            return;
        }
        
        $emails = User::whereIn('level', [
            User::EDITOR,
            User::ADMIN,
        ])->get()->pluck('email')->toArray();

        $emails = array_merge($emails, [
            $edit->previous->user->email
        ]);

        $emails = array_unique($emails);

        foreach ($emails as $email) {
            Mail::to($email)
                ->send(new PostRedraft($edit->current));
        }
    }
}

