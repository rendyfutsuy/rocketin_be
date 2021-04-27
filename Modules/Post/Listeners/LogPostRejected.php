<?php

namespace Modules\Post\Listeners;

use Modules\Post\Models\Log;
use Modules\Post\Models\Post;
use Modules\Auth\Models\UserActivity;
use Modules\Post\Events\PostRejected;

class LogPostRejected
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(PostRejected $post)
    {
        auth()->user()->recordLastOnline();
        
        Log::create([
            'user_id' => auth()->id(),
            'post_id' => $post->post->id,
            'status' => Log::REJECTED,
            'message' => $post->request->note,
        ]);
    }
}

