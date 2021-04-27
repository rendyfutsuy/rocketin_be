<?php

namespace Modules\Profile\Http\Factories;

use Illuminate\Http\Request;
use Modules\Auth\Models\User;
use Illuminate\Support\Facades\Storage;
use Modules\Profile\Http\Builders\Avatar;
use Modules\Profile\ServiceManagers\UserManager;

class AvatarFactory
{
    /** @var User */
    protected $user;

    /** @var Request */
    protected $request;

    /** @var UserManager */
    protected $manager;

    /**
     * @return void
     */
    public function __construct(UserManager $manager, Request $request)
    {
        $this->request = $request;
        $this->manager = $manager;
    }

    protected function builders(?User $user): array
    {
        return [
            new Avatar($user),
        ];
    }

    protected function getParameters(?User $user): array
    {
        return [
            'avatar' => $this->getFilePath(User::avatarPath($user->id)),
        ];
    }

    /**
     * @return void
     */
    public function submit(?User $user)
    {
        $this->manager->with($this->builders($user))
            ->commit($this->getParameters($user));
    }

    protected function getFilePath($prefix = null): ?string
    {
        $file = $this->request->file;
  
        if (! $file) {
            return null;
        }

        return $file ? Storage::put('public/'.$prefix, $file) : ' ';
    }
}
