<?php

namespace App\Http\EmailLimiters;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use App\Exceptions\EmailLimitException;

trait EmailLimiter
{   
    /**
     * @throws EmailLimitException
     */
    protected function attemptMail(string $name, int $limit): void
    {
        $counter = Cache::get($name);
        $counter += 1;

        Cache::put($name, $counter, Config::get('mail.request_attempts_cache'));

        if ($counter > $limit) {
            $this->exceedLimit();
        }
    }

    /**
     * @throws EmailLimitException
     */
    protected function exceedLimit(): void
    {
        throw new EmailLimitException(__('email.exceed_limit'), 429);
    }
}
