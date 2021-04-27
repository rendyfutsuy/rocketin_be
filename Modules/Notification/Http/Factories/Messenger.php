<?php

namespace Modules\Notification\Http\Factories;

use Modules\Notification\Http\Factories\Workers\ClientWorker;
use Modules\Notification\Clients\Example;

class Messenger extends ClientWorker
{
    public function clients(): array
    {
        return [
            Example::class,
            // Ex: Name::class,
            // Ex: new Name($parameters),
        ];
    }
}