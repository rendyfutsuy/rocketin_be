<?php

namespace Modules\Auth\Http\Controllers\Auth;

use Carbon\Carbon;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Modules\Auth\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Models\ResetPhone;
use Illuminate\Support\Facades\Mail;
use Modules\Auth\ServiceManagers\Phone;
use Modules\Auth\Events\UserPhoneChanged;
use Modules\Auth\Events\NewPhoneRegistered;
use Modules\Auth\Http\Requests\UpdatePhone;
use Modules\Auth\Events\MessageSentToUserPhone;

class ResetPhoneController extends Controller
{
    /**
     * Set phone for reset form.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function setResetPhoneForm(UpdatePhone $request)
    {
        /** @var \Modules\Auth\Models\User */
       DB::transaction(function () use ($request) {
            $user = auth()->user();

            $user->resetPhones()->delete();

            $phoneReset = $user->resetPhones()
                ->create($request->getResetPhone());

            $this->sendNotificationToPhone($request->phone);

            event(new NewPhoneRegistered($user, $phoneReset));
       });

        return response()->json([
            'message' => __('auth::phone.reset_request_success', [], $request->locale ?? 'en')
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePhone(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $phoneReset = ResetPhone::query()
                ->where('user_id', $request->user_id)
                ->where('expires_at', '>', Carbon::now())
                ->first();

            if (! $phoneReset || ! $phoneReset->notExpired()) {
                return redirect()->back()->withErrors(__('Verifikasi untuk phone ini sudah tidak bisa dipakai.'));
            }

            $user = User::find($request->user_id);
            $oldPhone = $user->phone;
            $newPhone = $phoneReset->phone;

            $phoneReset->user()->update(['phone' => $phoneReset->phone]);

            event('user.phone.updated', new UserPhoneChanged($user, $oldPhone, $newPhone));

            $phoneReset->delete();

            return redirect(
                route('api.auth.reset.phone.success', ['lang' => $request->lang])
            );
        });
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePhoneWithCode(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $request->validate([
                'activation_code' => 'required',
            ]);

            $phoneReset = ResetPhone::query()
                ->where('user_id', auth()->id())
                ->where('activation_code', $request->activation_code)
                ->where('expires_at', '>', Carbon::now())
                ->first();

            if (! $phoneReset || ! $phoneReset->notExpired()) {
                $phoneReset->delete();
                return redirect()->back()->withErrors(__('Verifikasi untuk nomor telepon ini sudah tidak bisa dipakai.'));
            }

            $user = auth()->user();
            $oldPhone = $user->phone;
            $newPhone = $phoneReset->phone;

            $phoneReset->user()->update(['phone' => $phoneReset->phone]);

            event('user.phone.updated', new UserPhoneChanged($user, $oldPhone, $newPhone));

            $phoneReset->delete();

            return redirect(
                route('api.auth.reset.phone.success', ['lang' => $request->lang])
            );
        });
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendNotificationToPhone()
    {
        $resetPhone = ResetPhone::query()
                    ->whereUserId(auth()->user()->id)
                    ->first();

        if ($resetPhone->notExpired()) {
            $this->sendNotificationToPhone($resetPhone->phone);

            session()->flash('status', __('Kode Verifikasi telah dikirim melalui nomor telepon'));

            return response()->json([
                'message' => __('Kode Verifikasi telah dikirim melalui nomor telepon'),
                'success' => true,
            ], 200);
        }

        $resetPhone->delete();

        return response()->json(['message' => __('Gagal')], 404);
    }

    /**
     * @return void
     */
    public function sendNotificationToNewPhone(string $phone)
    {
        $phone = resolve(Phone::class);
        $phone->sendOtpMessage($user, $phoneNumber);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function success(Request $request)
    {
        $lang = $request->lang;

        return view('auth::reset_phone.success', compact('lang'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        auth()->user()->resetPhones()->delete();

        return response()->json([
            'message' => __('auth.phone.reset_request_success')
        ]);
    }
}
