<?php

namespace Modules\Profile\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Modules\Profile\Events\AvatarUploaded;
use Modules\Profile\Http\Factories\AvatarFactory;

class UploadAvatar extends Controller
{
    /** @var AvatarFactory */
    protected $factory;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AvatarFactory $factory)
    {
        $this->middleware('auth');
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
            'message' => __('profile::edit.avatar.success', [], auth()->user()->getLocale()),
        ]);
    }
}
