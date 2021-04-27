<?php

namespace Modules\Admin\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user_id' => $this->id,
            'name' => $this->notGuest() ? $this->full_name : '<strong>This User is Guest</strong>',
            'email' => $this->notGuest() ? $this->email : '<strong>This User is Guest</strong>',
            'username' => $this->username,
            'is_guest' => ! $this->notGuest(),
            'is_banned' => $this->isBanned(),
            'status' => $this->status,
            'type' => $this->type,
            'join_at' => $this->created_at->format('Y M d'),
            'detail_link' => route('api.admin.user.detail', $this->id),
        ];
    }
}
