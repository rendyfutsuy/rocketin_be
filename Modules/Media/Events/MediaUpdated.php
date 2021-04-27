<?php

namespace Modules\Media\Events;

use Illuminate\Http\Request;
use Modules\Media\Models\Media;
use Illuminate\Queue\SerializesModels;

class MediaUpdated
{
    use SerializesModels;

    /**
     * @var Media
     */
    public $media;

    /**
     * @var Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Media $media, Request $request)
    {
        $this->media = $media;
        $this->request = $request;
    }
}