<?php

namespace Modules\Auth\Http\Controllers\Auth;

use Carbon\Carbon;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Modules\Auth\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Models\ResetEmail;
use Illuminate\Support\Facades\Mail;
use Modules\Auth\Events\UserEmailChanged;
use Modules\Auth\Events\NewEmailRegistered;
use Modules\Auth\Http\Requests\UpdateEmail;
use Modules\Auth\Emails\NewEmailVerification;
use Modules\Auth\Events\MessageSentToUserPhone;

class ResetEmailController extends Controller
{
    /**
     * Set email for reset form.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function setResetEmailForm(UpdateEmail $request)
    {
        /** @var \Modules\Auth\Models\User */
       DB::transaction(function () use ($request) {
            $user = auth()->user();

            $user->resetEmails()->delete();

            $emailReset = $user->resetEmails()
                ->create($request->getResetEmail());

            $this->resendNotificationToNewEmail();

            event(new NewEmailRegistered($user, $emailReset));
       });

        return response()->json([
            'message' => __('auth::email.reset_request_success', [], $request->locale ?? 'en')
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEmail(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $emailReset = ResetEmail::query()
                ->where('user_id', $request->user_id)
                ->where('expires_at', '>', Carbon::now())
                ->first();

            if (! $emailReset || ! $emailReset->notExpired()) {
                return redirect()->back()->withErrors(__('Verifikasi untuk email ini sudah tidak bisa dipakai.'));
            }

            $user = User::find($request->user_id);
            $oldEmail = $user->email;
            $newEmail = $emailReset->email;

            $emailReset->user()->update(['email' => $emailReset->email]);

            event('user.email.updated', new UserEmailChanged($user, $oldEmail, $newEmail));

            $emailReset->delete();

            return redirect(
                route('api.auth.reset.email.success', ['lang' => $request->lang])
            );
        });
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEmailWithCode(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $request->validate([
                'activation_code' => 'required',
            ]);

            $emailReset = ResetEmail::query()
                ->where('user_id', auth()->id())
                ->where('activation_code', $request->activation_code)
                ->where('expires_at', '>', Carbon::now())
                ->first();

            if (! $emailReset || ! $emailReset->notExpired()) {
                if (request()->ajax() || request()->wantsJson() || request()->expectsJson()) {
                    return response()->json([
                        'message' => __('Verifikasi untuk email ini sudah tidak bisa dipakai.'),
                        'success' => false,
                    ], 403);
                }

                return redirect()->back()->withErrors(__('Verifikasi untuk email ini sudah tidak bisa dipakai.'));
            }

            $user = auth()->user();
            $oldEmail = $user->email;
            $newEmail = $emailReset->email;

            $emailReset->user()->update(['email' => $emailReset->email]);

            event('user.email.updated', new UserEmailChanged($user, $oldEmail, $newEmail));

            $emailReset->delete();
            
            if (request()->ajax() || request()->wantsJson() || request()->expectsJson()) {
                return response()->json([
                    'message' => __('Email berhasil diganti.'),
                    'success' => true,
                ], 200);
            }

            return redirect(
                route('api.auth.reset.email.success', ['lang' => $request->lang])
            );
        });
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendNotificationToNewEmail()
    {
        $resetEmail = ResetEmail::query()
                    ->whereUserId(auth()->user()->id)
                    ->first();

        if ($resetEmail->notExpired()) {
            Mail::to($resetEmail->email)
                ->send(new NewEmailVerification($resetEmail->user, $resetEmail));

            session()->flash('status', __('Kode Verifikasi telah dikirim melalui alamat email'));

            return response()->json([
                'message' => __('Kode Verifikasi telah dikirim melalui alamat email'),
                'success' => true,
            ], 200);
        }

        $resetEmail->delete();

        return response()->json(['message' => __('Gagal')], 404);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function success(Request $request)
    {
        $lang = $request->lang;

        return view('auth::reset_email.success', compact('lang'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        auth()->user()->resetEmails()->delete();

        return response()->json([
            'message' => __('auth.email.reset_request_success')
        ]);
    }
}
