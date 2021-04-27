<?php

namespace Modules\Admin\ServiceManagers;

use App\Services\ManagerPipeline;

class AdminManager extends ManagerPipeline
{
    /**
     * @return mixed
     */
    public function withReturn()
    {
        return $this->returnValue;
    }
}