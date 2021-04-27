<?php

namespace Modules\Auth\Models;

use Carbon\Carbon;
use Modules\Post\Models\Post;
use Modules\Auth\Models\ResetEmail;
use Modules\Auth\Models\ResetPhone;
use Modules\Auth\Models\UserDevice;
use Modules\Profile\Models\Profile;
use Modules\Auth\Models\UserActivity;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Auth\Models\Traits\WordpressAuth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, SoftDeletes, WordpressAuth;

    protected $table = 'users';

    /** Level */

    Const GUEST = 0;
    Const REGISTERED = 1;
    Const ADMIN = 2;
    Const EDITOR = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'email_verified_at',
        'banned_at',
        'level',
        'avatar',
        'meta',
        'phone',
        'activation_code',
        'wp_user_id',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'banned_at' => 'datetime',
        'last_login' => 'datetime',
        'meta' => 'array',
    ];

    /** show user banned status */
    public static function avatarPath(int $userId): string
    {
        return $userId .'/profile/avatars' ;
    }

    public function getFullAvatarPathAttribute(): ?string
    {
        if (! $this->avatar) {
            return null;
        }

        return Storage::url($this->avatar);
    }

    public function getLocale(): string
    {
        return $this->profile->lang_profile ?? Config::get('app.locale');
    }

    public function getBibleLocaleAttribute(): ?string
    {
        return $this->profile->lang_bible;
    }

    public function canNotPublishPost(): bool
    {
        if ($this->level == self::ADMIN) {
            return false;
        }

        return $this->level != self::EDITOR;
    }

    public function getUsername(): string
    {
        if (! $this->notGuest()) {
          return __('Guest');  
        }

        return $this->username;
    }

    public function lastActivity(): ?string
    {
        if ($this->activities->isEmpty()) {
            return null;
        }

        return $this->activities
            ->sortByDesc('created_at')
            ->first()->getExplanation();
    }

    /** show user banned status */
    public function isBanned(): bool
    {
        return (bool) $this->banned_at;
    }

    /** show user banned status */
    public function isDeleted(): bool
    {
        return (bool) $this->deleted_at;
    }

    /**  show user activation status */
    public function isActivated(): bool
    {
        return ! $this->activation_code &&
            $this->email_verified_at;
    }

    /**  confirm user level as admin */
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    /**  confirm user level as anot guest */
    public function notGuest(): bool
    {
        return $this->level != self::GUEST;
    }

    public function activities(): HasMany
    {
        return $this->hasMany(UserActivity::class, 'user_id', 'id');
    }

    public function devices(): HasMany
    {
        return $this->hasMany(UserDevice::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function currentDevice(): HasOne
    {
        return $this->hasOne(UserDevice::class);
    }

    public function resetPhones(): HasMany
    {
        return $this->hasMany(ResetPhone::class, 'user_id', 'id');
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class, 'id', 'id');
    }

    public function resetEmails(): HasMany
    {
        return $this->hasMany(ResetEmail::class, 'user_id', 'id');
    }

    public function resetPhonesWithSoftDeletes(): HasMany
    {
        return $this->hasMany(ResetPhone::class, 'user_id', 'id')
            ->withTrashed();
    }

    public function resetEmailsWithSoftDeletes(): HasMany
    {
        return $this->hasMany(ResetEmail::class, 'user_id', 'id')
            ->withTrashed();
    }

    public function noUnverifiedPhone(): bool
    {
        return $this->resetPhones->isEmpty();
    }

    public function noUnverifiedEmail(): bool
    {
        if (empty($this->email_verified_at)) {
            return false;
        }

        return $this->resetEmails->isEmpty();
    }

    public function getEmail(): ?string
    {
        if ($this->resetEmails->isNotEmpty()) {
            return $this->resetEmails->first()->email;
        }
        return null;
    }
    public function getPhone(): ?string
    {
        if ($this->resetPhones->isNotEmpty()) {
            return $this->resetPhones->first()->phone;
        }
        return null;
    }

    public function getMeta(string $label = null): array
    {
        if ($label == null) {
            return $this->meta;
        }

        return $this->meta[$label];
    }

    public function getActivationCode(): ?string
    {
        return $this->activation_code;
    }

    public function markEmailAsVerified(): void
    {
        $this->activation_code = null;
        $this->email_verified_at = Carbon::now();
        $this->last_online = Carbon::now();
        $this->save();  
    }

    public function recordLastOnline(): void
    {
        $this->last_online = Carbon::now();
        $this->save();
    }

    /**
     * Get JWT indentifier.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get JWT custom claims.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function scopeGuest(Builder $users): Builder
    {
        return $users->where('level', self::GUEST);
    }

    public function scopeEditor(Builder $users): Builder
    {
        return $users->where('level', self::EDITOR);
    }

    public function scopeAdmin(Builder $users): Builder
    {
        return $users->where('level', self::ADMIN);
    }

    public function scopeNormalUser(Builder $users): Builder
    {
        return $users->where('level', self::REGISTERED);
    }

    public function getStatusAttribute(): ?string
    {
        if ($this->isBanned()) {
            return __('auth::status.banned', [], $this->getLocale());
        }
        
        if (! $this->isActivated()) {
            return __('auth::status.not_activated', [], $this->getLocale());
        }

        return __('auth::status.activated', [], $this->getLocale());
    }

    public function gettypeAttribute(): ?string
    {
        if ($this->level == self::EDITOR) {
            return __('auth::level.editor', [], $this->getLocale());
        }

        if ($this->level == self::ADMIN) {
            return __('auth::level.admin', [], $this->getLocale());
        }

        return __('auth::level.seller', [], $this->getLocale());
    }
}
