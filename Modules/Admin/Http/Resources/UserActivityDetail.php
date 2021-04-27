<?php

namespace Modules\Admin\Http\Resources;

use Carbon\Carbon;
use Modules\Auth\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserActivityDetail extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'join_at' => $this->created_at->format('Y-m-d'),
            'total_activity' => $this->activities->count(),
            'last_activity' => $this->lastActivity(),
            'total_activity_today' => $this->activities()->today()->count(),
            'total_activity_week' => $this->activities()->week()->count(),
            'total_activity_month' => $this->activities()->month()->count(),
            'total_activity_year' => $this->activities()->year()->count(),
            'last_updated_at' => $this->updated_at->format('Y-m-d'),
        ];
    }
}
