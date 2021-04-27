<?php

namespace Modules\Notification\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Notification\Models\Message;
use App\Http\Localizations\RequestLocalization;
use Modules\Notification\Http\Searches\NotificationSearch;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Notification\ServiceManagers\NotificationManager;
use Modules\Notification\Http\Resources\NotificationCollection;
use Modules\Notification\Http\Resources\Forms\Message as MessageForm;

class NotificationController extends Controller
{
    use RequestLocalization;

    /** @param NotificationSearch */
    protected $search;

    /** @param NotificationManager */
    protected $manager;

    public function __construct(NotificationManager $manager, NotificationSearch $search)
    {
        $this->manager = $manager;
        $this->search = $search;
    }

    public function list(Request $request): ResourceCollection
    {
        $notifications =  $this->search->apply()->get();

        return new NotificationCollection($notifications);
    }

    public function registerDevice(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required',
        ]);

        $device = $this->manager
            ->register(auth()->user(), $request->token);

        return response()->json([
            'device_id' => $device->device_id,
            'user_id' => $device->user_id,
            'message' => $this->translate('notification::message.registered', auth()->user()->getLocale()),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $notification =  new MessageForm(auth()->user(), $request->all());
        $device = $this->manager
            ->pendingNotification($notification->render());

        return response()->json([
            'message' => $this->translate('notification::message.store', auth()->user()->getLocale()),
        ]);
    }

    public function send(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        $notifications = Message::whereIn('id', $request->ids)
            ->whereNotNull('device_id')
            ->get();

        $this->manager
            ->pendingNotification($notifications)
            ->send();

        return response()->json([
            'message' => $this->translate('notification::message.sent', auth()->user()->getLocale()),
        ]);
    }
}
