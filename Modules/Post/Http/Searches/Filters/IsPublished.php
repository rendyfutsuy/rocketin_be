<?php

namespace Modules\Post\Http\Searches\Filters;

use Closure;
use Modules\Post\Models\Post;
use Illuminate\Database\Eloquent\Builder;

class IsPublished
{
    /** @var int|string|null */
    protected $isPublished;

    /**
     * @param  int|string|null $isPublished
     * @return void
     */
    public function __construct($isPublished = null)
    {
        $this->isPublished = $isPublished;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $user, Closure $next)
    {
        if (! $this->keyword()) {
            return $next($user);
        }

        $user->whereNotNull('wp_post_id');

        return $next($user);
    }

    /**
     * Get search keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->isPublished) {
            return $this->isPublished;
        }

        return request('is_published') != null;
    }
}
