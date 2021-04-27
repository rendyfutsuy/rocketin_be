<?php

namespace Modules\Media\Http\Resources;

class EditWordpress extends StorageResource
{
    public function __construct(object $param)
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
            'source_url' => $this->param->source_url,
            'title' => $this->param->title->raw,
            'description' => $this->param->description->raw,
            'media_type' => $this->param->media_type,
            'caption' => $this->param->caption->raw,
            'alt_text' => $this->param->alt_text,
            'meta' => $this->param->meta,
            'media_detail' => (array) $this->param->media_details,
        ];
    }
}
