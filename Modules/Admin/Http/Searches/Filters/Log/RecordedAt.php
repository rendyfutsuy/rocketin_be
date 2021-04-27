<?php

namespace Modules\Admin\Http\Searches\Filters\Log;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class RecordedAt
{
    /** @var string|null */
    protected $createdAtStart;

    /** @var string|null */
    protected $createdAtEnd;

    /**
     * @param  string|null $createdAtStart
     * @return void
     */
    public function __construct($createdAtStart = null, $createdAtEnd = null)
    {
        $this->createdAtStart = $createdAtStart;
        $this->createdAtEnd = $createdAtEnd;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $user, Closure $next)
    {
        if (! $this->keyword()) {
            return $next($user);
        }

        $user->when($this->createdAtStart && $this->createdAtEnd, function ($user) {
            $user->whereBetween('recorded_at', [
                $this->createdAtStart,
                $this->createdAtEnd
            ]);
        });

        return $next($user);
    }

    /**
     * Get search keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->createdAtStart) {
            return $this->createdAtStart;
        }

        $this->createdAtStart = request('recorded_at_start', null);
        $this->createdAtEnd = request('recorded_at_end', now());

        return request('recorded_at_start');
    }
}
