<?php

namespace Modules\Media\ServiceManager\Contracts;

use Modules\Media\Models\Media;

interface StorageContract
{
    public function return(): Media;
}