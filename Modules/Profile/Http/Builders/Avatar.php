<?php

namespace Modules\Profile\Http\Builders;

use Modules\Auth\Models\User;
use Modules\Profile\Http\Builders\Contracts\BuilderContract;

class Avatar implements BuilderContract
{
    /** @var User|null */
    protected $user;

    /** @var array */
    protected $parameters = [];

    /**
     * @param  User  $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * initialize command to save tour guide component to it Model
     *
     * @return self
    */
    public function apply()
    {
        $this->user->update($this->parameters);
        return $this;
    }

    /**
     * set data that will be added to builders
     *
     * @param  array $data
     * @return self
     */
    public function set($data)
    {
        $this->parameters = $data;
        return $this;
    }

    /** get builder's return values
     * @return mixed
    */
    public function withReturn()
    {
        return $this->user->full_avatar_path;
    }

    public function getName(): string
    {
        return 'avatar';
    }
}
