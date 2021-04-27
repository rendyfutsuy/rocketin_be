<?php

namespace Modules\Wordpress\ServiceManager\Contracts;

interface WpAuthContract
{
    /** 
     * render header for Wordpress Authentication.
     *
     * @param  mixed  ...$params
     *  
     */
    public function  getHeaders(...$params): array;
}
