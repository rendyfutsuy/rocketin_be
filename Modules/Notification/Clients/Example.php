<?php

namespace Modules\Notification\Clients;

use Modules\Notification\Models\Message;
use Modules\Notification\Clients\Contracts\ClientContract;

class Example implements ClientContract
{
    /*
    |--------------------------------------------------------------------------
    | Example to use Client
    |--------------------------------------------------------------------------
    |
    */

    /**
     * @return self
     */
    public function send(Message $notification)
    {
        // Write Your Logic Here
        // Example
        
        // $this->provider
        // ->set($notification)
        // ->send();

        return $this;
    }

    /**
     * @return string
     */
    public function getClientName()
    {
        return 'default';
    }
}
