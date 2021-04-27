<?php

namespace Modules\Media\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
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
            'id' => $this->id,
            'wp_media_id' => $this->wp_media_id,
            'url' => $this->source_url,
            'caption' => $this->caption,
            'title' => $this->title,
            'uploader' => $this->user->username,
            'created_at' => $this->created_at->format('Y M d H:i:s'),
            'detail_url' => route('api.media.detail', $this->id),
        ];
    }
}
