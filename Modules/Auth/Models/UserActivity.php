<?php

namespace Modules\Auth\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Localizations\RequestLocalization;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Auth\Models\Traits\ActivityExplanations;

class UserActivity extends Model
{
    use ActivityExplanations, RequestLocalization;

    // type
    const BIODATA = 1;
    const IDENTITY = 2;
    const POST = 3;
    const ACTIVITY = 4;
    const ADMIN = 5;

    // activity code
    const LOGIN = 41;
    const LOGOUT = 42;
    const REGISTER = 43;

    // activity code
    const PROFILE_FULL_NAME_UPDATED = 11;
    const PROFILE_BIRTHDAY_UPDATED = 12;
    const PROFILE_GENDER_UPDATED = 13;
    const PROFILE_USERNAME_UPDATED = 14;
    const PROFILE_AVATAR_UPDATED = 15;

    // activity code
    const POST_CREATED = 31;
    const POST_UPDATED = 32;
    const POST_PUBLISHED = 33;
    const POST_DELETED = 34;
    const POST_PUBLISHER = 35;
    const POST_PUBLICATION_NOTIFY = 36;
    const POST_WAITED = 37;
    const POST_WAITED_NOTIFY = 38;
    const POST_REJECTED = 39;

    // activity code
    const ADMIN_USER_DISABLED = 510;
    const ADMIN_USER_ENABLED = 511;

    /** @var string */
    protected $table = 'user_activities';

    /** @var array */
    protected $fillable = [
        'id',
        'user_id',
        'type',
        'activity_code',
        'details',
    ];

    /** @var array */
    protected $casts = [
        'details' => 'object',
    ];

    public function getExplanation(): ?string
    {
        return $this->showExplanation($this->activity_code);
    }

    public function getLabel($code = null): ?string
    {
        return $this->showLabel($code ?? $this->activity_code);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function scopeToday(Builder $logs): Builder
    {
        return $logs->whereBetween('created_at', [
            Carbon::now()->format('Y-m-d 00:00:00'),
            Carbon::now()->format('Y-m-d 23:59:59'),
        ]);
    }

    public function scopeWeek(Builder $logs): Builder
    {
        return $logs->whereBetween('created_at', [
            Carbon::now()->startOfWeek()->format('Y-m-d 00:00:00'),
            Carbon::now()->endOfWeek()->format('Y-m-d 23:59:59'),
        ]);
    }

    public function scopeMonth(Builder $logs): Builder
    {
        return $logs->whereBetween('created_at', [
            Carbon::now()->startOfMonth()->format('Y-m-d 00:00:00'),
            Carbon::now()->endOfMonth()->format('Y-m-d 23:59:59'),
        ]);
    }

    public function scopeYear(Builder $logs): Builder
    {
        return $logs->whereBetween('created_at', [
            Carbon::now()->startOfYear()->format('Y-m-d 00:00:00'),
            Carbon::now()->endOfYear()->format('Y-m-d 23:59:59'),
        ]);
    }
}
