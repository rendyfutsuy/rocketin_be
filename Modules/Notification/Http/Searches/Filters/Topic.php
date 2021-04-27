<?php

namespace Modules\Notification\Http\Searches\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class Topic
{
    /** @var int|string|null */
    protected $topic;

    /**
     * @param  int|string|null $topic
     * @return void
     */
    public function __construct($topic = null)
    {
        $this->topic = $topic;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $notification, Closure $next)
    {
        if (! $this->keyword()) {
            return $next($notification);
        }

        $notification->where('topic', $this->keyword());

        return $next($notification);
    }

    /**
     * Get search keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->topic) {
            return $this->topic;
        }

        return request('topic');
    }
}
