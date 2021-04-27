<?php

namespace Modules\Media\Http\Resources;

use App\Http\Resources\Form\Form;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class StorageResource extends Form
{
    /** @var array */
    protected $param = [];

    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function render()
    {
        return [
            'wp_media_id' => $this->param->previous->id,
            'source_url' => $this->param->previous->link,
            'title' => $this->param->previous->title->raw,
            'description' => $this->param->previous->description->raw,
            'media_type' => $this->param->previous->media_type,
            'caption' => $this->param->previous->caption->raw,
            'alt_text' => $this->param->previous->alt_text,
            'meta' => $this->param->previous->meta,
            'media_detail' => $this->param->previous->media_detail,
        ];
    }
}
