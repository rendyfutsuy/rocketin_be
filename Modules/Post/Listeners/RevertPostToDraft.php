<?php

namespace Modules\Post\Listeners;

use Modules\Post\Models\Post;
use Modules\Post\Events\PostUpdated;
use Modules\Auth\Models\UserActivity;
use Modules\Wordpress\ServiceManager\Wordpress;

class RevertPostToDraft
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
        if (empty($edit->current->wp_post_id)) {
            return;
        }

        $token = base64_encode(config('wordpress.basic_auth_username') . ':' .config('wordpress.basic_auth_password'));

        $response = $this->wordpress->requestUpdatePost($edit->current->wp_post_id, $token, $edit->request->wpRequest());

        $edit->current->status = Post::DRAFTED;
        $edit->current->save();
    }
}

