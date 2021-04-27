<?php

namespace Modules\Admin\Http\Searches;

use App\Http\Searches\HttpSearch;
use Modules\Auth\Models\UserActivity;
use Illuminate\Database\Eloquent\Builder;

class UserActivitySearch extends HttpSearch
{
    protected function filters(): array
    {
        return [
            Filters\Activity\ActivitySelection::class,
            Filters\Activity\TimeSelection::class,
            Filters\Activity\User::class,
            Filters\Activity\Week::class,
            Filters\Activity\Today::class,
            Filters\Activity\Month::class,
            Filters\Activity\Year::class,
            Filters\Activity\Code::class,
            Filters\Activity\Type::class,
            Filters\Log\UserName::class,
            Filters\Activity\RecordedAt::class,
            Filters\Log\Name::class
        ];
    }

    /**
     * @return Builder<UserActivity>
     */
    protected function passable()
    {
        return UserActivity::query()
            ->with('user');
    }

    /**
     * @inheritdoc
     */
    protected function thenReturn($logs)
    {
        return $logs;
    }

    public function perDays(): self
    {
        request()->request->add([
            'today' => true,
        ]);

        return $this;
    }

    public function perWeeks(): self
    {
        request()->request->add([
            'week' => true,
        ]);

        return $this;
    }

    public function perMonths(): self
    {
        request()->request->add([
            'month' => true,
        ]);

        return $this;
    }

    public function perYears(): self
    {
        request()->request->add([
            'year' => true,
        ]);

        return $this;
    }
}
