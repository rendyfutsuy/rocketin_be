<?php

namespace Modules\Post\Events;

use Illuminate\Http\Request;
use Modules\Post\Models\Post;
use Illuminate\Queue\SerializesModels;

class PostRejected
{
    use SerializesModels;

    /**
     * @var Post
     */
    public $post;

    /**
     * @var Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Post $post, Request $request)
    {
        $this->post = $post;
        $this->request = $request;
    }
}