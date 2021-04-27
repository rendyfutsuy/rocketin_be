<?php

namespace Modules\Post\Events;

use Modules\Post\Models\Post;
use Illuminate\Queue\SerializesModels;

class PostPublished
{
    use SerializesModels;

    /**
     * @var Post
     */
    public $post;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }
}