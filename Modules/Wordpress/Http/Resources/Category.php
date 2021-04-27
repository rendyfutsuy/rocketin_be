<?php

namespace Modules\Wordpress\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'link' => $this->link,
            'name' => $this->name,
            'label' => $this->name,
            'slug' => $this->slug,
        ];
    }
}
