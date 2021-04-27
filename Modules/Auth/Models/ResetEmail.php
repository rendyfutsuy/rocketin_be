<?php

namespace Modules\Auth\Models;

use Modules\Auth\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResetEmail extends Model
{
    use SoftDeletes;

    const EXPIRED_TIME = 24;

     /** @var string */
     protected $table = 'user_reset_emails';

     /** @var array */
     protected $fillable = [
        'user_id',
        'email',
        'activation_code',
        'expires_at',
     ];
 
     /**
      * The attributes that should be cast to native types.
      *
      * @var array
      */
     protected $casts = [
         'expires_at' => 'datetime',
     ];

     /**
     * Get email attribute.
     *
     * @param  string  $value
     * @return string
     */
    public function getEmailAttribute($value)
    {
        return strtolower($value);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getActivationCode(): int
    {
        return $this->activation_code;
    }

    public function notExpired(): bool
    {
        return ! $this->expires_at->isPast();
    }
}
