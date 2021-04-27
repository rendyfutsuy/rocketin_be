<?php

namespace Modules\Notification\Http\Factories\Workers;

use Illuminate\Support\Facades\Config;
use Modules\Notification\Models\Message;
use Modules\Notification\Exceptions\ClientException;
use Modules\Notification\Clients\Contracts\ClientContract;

abstract class ClientWorker
{
    /** @var ClientContract */
    protected $client;

    public function __construct()
    {
        if (empty($this->clients())) {
            throw new ClientException(__('notification::message.no_registered_client'), 401);
        }

        foreach ($this->clients() as $clientClass) {
            $solvedClass = $this->resolveClass($clientClass);

            if  ($solvedClass->getClientName() == Config::get('notification.provider')) {
                $this->client = $solvedClass; 
            }
        }
        
        if (empty($this->client)) {
            throw new ClientException(__('notification::message.client_not_found'), 402);
        }
    }

    public function clients(): array
    {
        return [];
    }

    public function send(Message $notification): void
    {
        $this->client->send($notification);

        return;
    }

    /**
     * @param  string|ClientContract $class
     * 
     * @throws ClientException
     */
    protected function resolveClass($class): ClientContract
    {
        if ($class instanceof ClientContract) {
            return $class;
        }

        if (is_string($class) && app()->make($class) instanceof ClientContract) {
            return app()->make($class);
        }

        throw new ClientException(__('notification::message.client_not_valid'), 406);

    }
}