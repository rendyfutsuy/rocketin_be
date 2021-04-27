<?php

namespace Modules\Message\ServiceManager\Contracts;

interface ProviderContract
{
    /** 
     * render header for Wordpress Authentication.
     *
     * @param  mixed  ...$params
     *  
     */
    public function  send(...$params): array;
}
