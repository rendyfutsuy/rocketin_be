<?php

namespace Modules\Notification\Models;

use Modules\Auth\Models\User;
use Modules\Auth\Models\UserDevice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    protected $table = 'notification_messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device_id',
        'user_id',
        'topic',
        'notification',
        'data',
        'sent_at',
        'is_sent',
    ];

    protected $casts = [
        'notification' => 'array',
        'data' => 'array',
    ];

    /**
     * Get message owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get device used for message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device()
    {
        return $this->belongsTo(UserDevice::class, 'device_id', 'device_id');
    }
}
