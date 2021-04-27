<?php

namespace Modules\Media\Http\Resources;

class DeleteWordpress extends StorageResource
{
    public function __construct()
    {
        $this->param = $param;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function render()
    {
        return [
            'source_url' => $this->param->link,
            'title' => $this->param->title->raw,
            'description' => $this->param->description->raw,
            'media_type' => $this->param->media_type,
            'caption' => $this->param->caption->raw,
            'alt_text' => $this->param->alt_text,
            'meta' => $this->param->meta,
            'media_detail' => $this->param->media_detail,
        ];
    }
}
