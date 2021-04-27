<?php

namespace Modules\Notification\Http\Resources\Forms;

use Modules\Auth\Models\User;
use App\Http\Resources\Form\Form;

class Message extends Form
{
    /** @var array */
    protected $parameters = [];

    /** @var User */
    protected  $user;

    public function __construct(User $user, array $parameters)
    {
        $this->parameters = $parameters;
        $this->user = $user;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function render()
    {
        return [
            'device_id' => $this->get('token', ''),
            'user_id' => $this->user->id,
            'topic' => $this->get('topic', ''),
            'notification' => [
                'title' => $this->get('title', null),
                'body' => $this->get('body', null),
            ],
            'data' => [
                'title' => $this->get('title', null),
                'body' => $this->get('body', null),
            ],
            'sent_at' => $this->get('sent_at', now()),
            'is_sent' => $this->get('is_sent', false),
        ];
    }
}
