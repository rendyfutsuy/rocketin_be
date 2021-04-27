<?php

namespace Modules\Notification\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Notification extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $notification = $this->notification;

        return [
            'id' => $this->id,
            'topic' => $this->topic,
            'device_id' => $this->device_id,
            'title' => $notification['title'],
            'message' => $notification['body'],
            'sent_at' => $this->sent_at,
            'is_sent' => $this->is_sent,
        ];
    }
}
