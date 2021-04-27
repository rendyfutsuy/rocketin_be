<?php

namespace Modules\Admin\Models;

use Modules\Auth\Models\User;
use Illuminate\Database\Eloquent\Builder;

class Admin extends User
{
    /**
     * Boot the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('level', function (Builder $builder) {
            $builder->where('level', User::ADMIN)
                ->orWhere('level', User::EDITOR);
        });

        static::saving(function ($admin) {
            $admin->level = User::ADMIN;
        });
    }
}
