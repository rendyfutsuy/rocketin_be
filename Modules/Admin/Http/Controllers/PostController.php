<?php

namespace Modules\Admin\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
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

class PostController extends Controller
{
    public function postThisYear(Request $request)
    {
        $statics = [];
        if ($request->year) {
            $begin = $request->year.'-01-01 00:00:00';
            $end = $request->year.'-12-31 23:59:59';
        } else {
            $begin = Carbon::now()->startOfYear();
            $end = Carbon::now()->endOfYear();
        }

        $logs = UserActivity::query()
            ->whereType(UserActivity::POST)
            ->whereIn('activity_code', [
                UserActivity::POST_CREATED,
                UserActivity::POST_DELETED,
                UserActivity::POST_WAITED,
                UserActivity::POST_PUBLISHED,
            ])
            ->selectRaw(DB::raw('MONTHNAME(created_at) as month, activity_code, type'))
            ->selectRaw(DB::raw('created_at'))
            ->whereBetween('created_at', [$begin, $end])
            ->get()
            ->groupBy('activity_code');
        
        foreach ($logs as $key => $log) {
            $post = new YearStatic($log->groupBy('month'));

            $statics[Str::snake($log->first()->getLabel($key))] = $post->render();
        }

        return response()->json([
            'data' => $statics,
        ]);
    }

    public function personalPostThisYear(Request $request, User $user)
    {
        $statics = [];
        if ($request->year) {
            $begin = $request->year.'-01-01 00:00:00';
            $end = $request->year.'-12-31 23:59:59';
        } else {
            $begin = Carbon::now()->startOfYear();
            $end = Carbon::now()->endOfYear();
        }

        $logs = UserActivity::query()
            ->where('user_id', $user->id)
            ->whereType(UserActivity::POST)
            ->whereIn('activity_code', [
                UserActivity::POST_CREATED,
                UserActivity::POST_DELETED,
                UserActivity::POST_WAITED,
                UserActivity::POST_PUBLISHED,
            ])
            ->selectRaw(DB::raw('MONTHNAME(created_at) as month, activity_code, type'))
            ->selectRaw(DB::raw('created_at'))
            ->whereBetween('created_at', [$begin, $end])
            ->get()
            ->groupBy('activity_code');
        
        foreach ($logs as $key => $log) {
            $post = new YearStatic($log->groupBy('month'));

            $statics[Str::snake($log->first()->getLabel($key))] = $post->render();
        }

        return response()->json([
            'data' => $statics,
        ]);
    }
}
