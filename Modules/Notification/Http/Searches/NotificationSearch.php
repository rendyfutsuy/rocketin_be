<?php

namespace Modules\Notification\Http\Searches;

use App\Http\Searches\HttpSearch;
use Illuminate\Support\Facades\DB;
use Modules\Notification\Models\Message;
use Illuminate\Database\Eloquent\Builder;

class NotificationSearch extends HttpSearch
{
    protected function filters(): array
    {
        return [
            Filters\Device::class,
            Filters\User::class,
            Filters\Topic::class,
        ];
    }

    /**
     * @return Builder<Message>
     */
    protected function passable()
    {
        return Message::with(['user', 'device']);
    }

    /**
     * @inheritdoc
     */
    protected function thenReturn($notifications)
    {
        return $notifications;
    }
}
