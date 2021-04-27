<?php

namespace Modules\Profile\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Profile\Models\Profile;
use App\Http\Controllers\Controller; 
use Modules\Profile\Events\ProfileUpdated;
use App\Http\Localizations\RequestLocalization;
use Modules\Profile\Http\Factories\ProfileFactory;

class UpdateProfile extends Controller
{
    use RequestLocalization;

    /** @var ProfileFactory */
    protected $factory;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProfileFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        // dd($request->all());
        $previousUser = clone(Profile::find(auth()->id()));

        $this->factory->submit(auth()->user());

        event(new ProfileUpdated($previousUser, $request));

        return response()->json([
            'message' => $this->translate('profile::edit.profile.success', auth()->user()->getLocale()),
        ]);
    }
}