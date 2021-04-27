<?php

namespace Modules\Notification\Http\Searches\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class Device
{
    /** @var int|string|null */
    protected $token;

    /**
     * @param  int|string|null $token
     * @return void
     */
    public function __construct($token = null)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $notification, Closure $next)
    {
        if (! $this->keyword()) {
            return $next($notification);
        }
        
        $notification->where('device_id', $this->keyword());

        return $next($notification);
    }

    /**
     * Get search keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->token) {
            return $this->token;
        }

        return request('device_id') ?? request('token');
    }
}
