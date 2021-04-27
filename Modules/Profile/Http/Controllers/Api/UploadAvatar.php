<?php

namespace Modules\Profile\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Modules\Profile\Events\AvatarUploaded;
use App\Http\Localizations\RequestLocalization;
use Modules\Profile\Http\Factories\AvatarFactory;

class UploadAvatar extends Controller
{
    use RequestLocalization;

    /** @var AvatarFactory */
    protected $factory;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AvatarFactory $factory)
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
        $request->validate([
            'file' => ['required', 'file', 'mimes:jpeg,jpg,png', 'max:5120'],
        ]);

        $user = auth()->user();

        $previousUser = clone($user);
        
        $this->factory->submit($user);
        
        event(new AvatarUploaded($previousUser, $user->fresh()->avatar));

        return response()->json([
            'message' => $this->translate('profile::edit.avatar.success', auth()->user()->getLocale()),
        ]);
    }
}
