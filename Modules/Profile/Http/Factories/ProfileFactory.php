<?php

namespace Modules\Profile\Http\Factories;

use Illuminate\Http\Request;
use Modules\Auth\Models\User;
use App\Http\Resources\ProfileForms;
use Modules\Profile\Http\Builders\Phone;
use Modules\Profile\Http\Builders\Gender;
use Modules\Profile\Http\Builders\Birthday;
use Modules\Profile\Http\Builders\FullName;
use Modules\Profile\Http\Builders\UserName;
use Modules\Profile\Http\Builders\Nationality;
use Modules\Profile\ServiceManagers\UserManager;

class ProfileFactory
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
            new UserName($user),
            new FullName($user),
            new Birthday($user),
            new Gender($user),
            new Phone($user),
            new Nationality($user),
        ];
    }

    protected function getParameters(): array
    {
        $forms = new ProfileForms($this->request->all());
        return $forms->render();
    }

    /**
     * @return void
     */
    public function submit(?User $user)
    {
        $this->manager->with($this->builders($user))
            ->commit($this->getParameters());
    }
}
