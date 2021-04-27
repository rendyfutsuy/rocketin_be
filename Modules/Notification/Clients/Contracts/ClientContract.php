<?php

namespace Modules\Notification\Clients\Contracts;

use Modules\Notification\Models\Message;

interface ClientContract
{
    /**
     * send Notification with this CLient.
     * 
     * @return self
     */
    public function send(Message $notification);

    /**
     * return Client Name.
     * 
     * @return string
     */
    public function getClientName();
}
