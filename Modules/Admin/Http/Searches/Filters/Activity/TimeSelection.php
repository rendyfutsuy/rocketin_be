<?php

namespace Modules\Admin\Http\Searches\Filters\Activity;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class TimeSelection
{
    /**
     * @return mixed
     */
    public function handle(Builder $log, Closure $next)
    {
        $log->selectRaw(DB::raw('CONCAT(YEAR(created_at), " AD") as year, MONTHNAME(created_at) as month, DATE(created_at) as date'));

        return $next($log);
    }
}
