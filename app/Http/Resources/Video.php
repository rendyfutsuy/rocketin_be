<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class Video extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'duration' => $this->duration . 'Menit',
            'artist' => $this->artists()->pluck('name'),
            'genre' => $this->genres()->pluck('name'),
            'watch_url' => Storage::url($this->watch_url),
            'user_id' => $this->user->username,
            'views' => (int) $this->views,
            'vote' => (int) $this->vote,
            'like' => (int) $this->like,
        ];
    }
}
