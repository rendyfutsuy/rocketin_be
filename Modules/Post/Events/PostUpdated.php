<?php

namespace Modules\Post\Events;

use Illuminate\Http\Request;
use Modules\Post\Models\Post;
use Illuminate\Queue\SerializesModels;

class PostUpdated
{
    use SerializesModels;

    /**
     * @var Post
     */
    public $previous;

    /**
     * @var Post
     */
    public $current;

    /**
     * @var Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Post $previous, Post $current, Request $request)
    {
        $this->previous = $previous;
        $this->current = $current;
        $this->request = $request;
    }
}