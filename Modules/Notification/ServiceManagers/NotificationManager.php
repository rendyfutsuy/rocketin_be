<?php

namespace Modules\Notification\ServiceManagers;

use Modules\Auth\Models\User;
use Modules\Notification\Models\Message;
use App\Http\Resources\Form\Form;
use Modules\Auth\Models\UserDevice;
use Modules\Notification\Http\Factories\Messenger;
use Illuminate\Database\Eloquent\Collection;

class NotificationManager extends Form
{
    /** @var array */
    protected $parameters;

    /** @var Collection<Message> */
    protected $notifications;

    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    public static function register(User $user, string $token): UserDevice
    {
        return UserDevice::create([
            'user_id' => $user->id,
            'device_id' => $token,
        ]);
    }

    /**
     * @param Message|Collection<Message> $notification
     */
    public function pendingNotification($notifications = null): self
    {
        if ($notifications instanceof Collection) {
            $this->notifications = $notifications;
            return $this;
        }

        if (! is_array($notifications)) {
            $this->notifications = collect($notifications);
            return $this;
        }

        $this->notifications = collect(Message::create($notifications));
        
        return $this;
    }

    /**
     * @return void
    */
    public function send()
    {
        $messenger = new Messenger();
        
        foreach ($this->notifications as $notification) {
            $notification->is_sent = true;
            $notification->save();

            $messenger->send($notification);
        }
    }
}
