<?php

namespace Modules\Admin\Http\Resources;

use Modules\Auth\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserActivity extends JsonResource
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
            'user_id' => $this->user_id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'username' => $this->user->username,
            'join_at' => $this->user->created_at->format('Y M d'),
            'last_updated_at' => $this->user->updated_at->format('Y M d'),
            'recorded_at' => $this->created_at->format('Y M d'),
            'total_activity' => $this->user->activities->count(),
            'type' => '#' . $this->type . '('. $this->getLabel($this->type). ')',
            'activity_code' => '#' . $this->activity_code . '('. $this->getLabel(). ')',
            'last_activity' => $this->getExplanation(),
        ];
    }
}
