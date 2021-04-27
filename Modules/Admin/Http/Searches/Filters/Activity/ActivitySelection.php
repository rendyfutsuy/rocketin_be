<?php

namespace Modules\Admin\Http\Searches\Filters\Activity;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class ActivitySelection
{
    /**
     * @return mixed
     */
    public function handle(Builder $log, Closure $next)
    {
        $log->selectRaw(DB::raw('id, user_id, type, activity_code, details, created_at'));

        return $next($log);
    }
}
