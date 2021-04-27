<?php

namespace App\Builders\Contracts;

interface BuilderContract
{
    /**
     * initialize command to save tour guide component to it Model
     *
     * @return self
    */
    public function apply();

    /**
     * set data that will be added to builders
     *
     * @param  array $data
     * @return self
     */
    public function set($data);

    /** get builder's return values
     * @return mixed
    */
    public function withReturn();

    /** get builder's name
     * @return string
    */
    public function getName();
}