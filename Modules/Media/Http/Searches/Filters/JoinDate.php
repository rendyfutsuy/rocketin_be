<?php

namespace Modules\Media\Http\Searches\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class JoinDate
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
    public function handle(Builder $media, Closure $next)
    {
        if (! $this->keyword()) {
            return $next($media);
        }

        $media->when($this->createdAtStart && $this->createdAtEnd, function ($media) {
            $media->whereBetween('created_at', [
                $this->createdAtStart,
                $this->createdAtEnd
            ]);
        });

        return $next($media);
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

        $this->createdAtStart = request('created_at_start', null);
        $this->createdAtEnd = request('created_at_end', now());

        return request('created_at_start');
    }
}
