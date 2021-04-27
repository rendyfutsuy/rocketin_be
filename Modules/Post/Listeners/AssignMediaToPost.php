<?php

namespace Modules\Post\Listeners;

use Modules\Post\Models\Post;
use Modules\Post\Events\PostCreated;

class AssignMediaToPost
{
    /**
     * Handle the event.
     *
     * @param  PostUpdated  $login
     * @return void
     */
    public function handle(PostCreated $creation)
    {
        if (empty($creation->request->image_ids)) {
            return;
        }

        $creation->post
            ->medias()
            ->sync($creation->request->image_ids);
    }
}

