<?php

namespace Modules\Admin\Http\Controllers\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Auth\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Modules\Auth\Models\UserActivity;
use Modules\Admin\ServiceManagers\YearStatic;
use Modules\Admin\Http\Searches\UserListSearch;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Admin\Http\Searches\UserActivitySearch;
use Modules\Admin\Http\Resources\UserActivityDetail;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Admin\Http\Resources\UserActivityCollection;
use Modules\Admin\Http\Resources\StaticPerDaysCollection;
use Modules\Admin\Http\Resources\StaticPerWeeksCollection;
use Modules\Admin\Http\Resources\StaticPerYearsCollection;
use Modules\Admin\Http\Resources\StaticPerMonthsCollection;

class ActivityController extends Controller
{
    public function list(Request $request): ResourceCollection
    {
        $results = app()->make(UserActivitySearch::class)
            ->apply()
            ->orderBy('id', 'DESC')
            ->paginate($request->limit ?? 5);
            
        return new UserActivityCollection($results);
    }

    public function detail(User $user, Request $request): JsonResource
    {
        return new UserActivityDetail($user);
    }

    public function staticPerDay(User $user, string $day): ResourceCollection
    {
        $logs = app()->make(UserActivitySearch::class)
            ->perDays()
            ->apply([
                'day' => $day,
                'user_id' => $user->id,
            ])
            ->paginate(5);
            
        return new StaticPerDaysCollection($logs);
    }

    public function staticPerWeek(User $user, string $start, string $end): ResourceCollection
    {
        $logs = app()->make(UserActivitySearch::class)
            ->perWeeks()
            ->apply([
                'start' => $start,
                'end' => $end,
                'user_id' => $user->id,
            ])
            ->get();

        return new StaticPerWeeksCollection($logs->groupBy('date'));
    }

    public function staticPerMonth(User $user, string $start, string $end): ResourceCollection
    {
        $logs = app()->make(UserActivitySearch::class)
            ->perWeeks()
            ->apply([
                'start' => $start,
                'end' => $end,
                'user_id' => $user->id,
            ])
            ->get();

        return new StaticPerMonthsCollection($logs->groupBy('month'));
    }

    public function staticPerYear(User $user, string $start, string $end): ResourceCollection
    {
        $logs = app()->make(UserActivitySearch::class)
            ->perYears()
            ->apply([
                'start' => $start,
                'end' => $end,
                'user_id' => $user->id,
            ])
            ->get();
            
        return new StaticPerYearsCollection($logs->groupBy('year'));
    }

    public function activityThisYear(Request $request)
    {
        if ($request->year) {
            $begin = $request->year.'-01-01 00:00:00';
            $end = $request->year.'-12-31 23:59:59';
        } else {
            $begin = Carbon::now()->startOfYear();
            $end = Carbon::now()->endOfYear();
        }

        $verseLogs = UserActivity::query()
            ->selectRaw(DB::raw('MONTHNAME(created_at) as month'))
            ->selectRaw(DB::raw('created_at'))
            ->whereBetween('created_at', [$begin, $end])
            ->cursor()
            ->groupBy('month');

        $static = new YearStatic($verseLogs);

        return $static->render();
    }

    public function activityCodeList(): JsonResponse
    {
        $codes = UserActivity::showAllCodes();

        return response()->json([
            'data' => $codes,
        ]);
    }
}
