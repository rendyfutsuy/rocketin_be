<?php

namespace Modules\Post\Listeners;

use Modules\Post\Models\Post;
use Modules\Post\Emails\PostReject;
use Illuminate\Support\Facades\Mail;
use Modules\Auth\Models\UserActivity;
use Modules\Post\Events\PostRejected;

class SendRejectedNoteToUserEmail
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(PostRejected $post)
    {
        auth()->user()->recordLastOnline();

        Mail::to($post->post->user->email)
            ->send(new PostReject($post->post, $post->request->note));
    }
}

