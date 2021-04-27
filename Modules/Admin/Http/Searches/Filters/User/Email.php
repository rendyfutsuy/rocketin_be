<?php

namespace Modules\Admin\Http\Searches\Filters\User;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class Email
{
    /** @var int|string|null */
    protected $email;

    /**
     * @param  int|string|null $email
     * @return void
     */
    public function __construct($email = null)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $user, Closure $next)
    {
        if (! $this->keyword()) {
            return $next($user);
        }

        return $next($user);
    }

    /**
     * Get search keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->email) {
            return $this->email;
        }

        return request('email');
    }
}
