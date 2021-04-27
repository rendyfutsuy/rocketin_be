<?php

namespace Modules\Media\Events;

use Modules\Media\Models\Media;
use Illuminate\Queue\SerializesModels;

class MediaCreated
{
    use SerializesModels;

    /**
     * @var Media
     */
    public $media;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Media $media)
    {
        $this->media = $media;
    }
}