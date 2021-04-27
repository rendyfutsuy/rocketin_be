<?php

namespace Modules\Profile\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Modules\Auth\Models\User;
use Modules\Bible\Models\VerseLog;

class Profile extends User
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string|null
     */
    public function getFullNameAttribute()
    {
        return Arr::get($this->meta, 'full_name', null);
    }

    /**
     * @return string|null
     */
    public function getBirthdayAttribute()
    {
        return Arr::get($this->meta, 'birthday', null);
    }

    /**
     * @return string|null
     */
    public function getGenderTypeAttribute()
    {
        if (Arr::get($this->meta, 'gender') == null) {
            return null;
        }
        
        return __('profile::gender.'.Arr::get($this->meta, 'gender'), [], $this->lang_profile);
    }

    /**
     * @return string|null
     */
    public function getGenderAttribute()
    {
        return Arr::get($this->meta, 'gender', null);
    }

    /**
     * @return string|null
     */
    public function getNationalityAttribute()
    {
        return Arr::get($this->meta, 'nationality', null);
    }

    /**
     * @return string|null
     */
    public function getLangProfileAttribute()
    {
        return Arr::get($this->meta, 'lang_profile', 'id');
    }

    /**
     * @return integer
     */
    public function getRenderCommitDaysAttribute()
    {
        $latestLog = VerseLog::where('user_id', $this->id)
        ->orderBy('id', 'DESC')
        ->first();

        if (Carbon::parse(now()->format('Y-m-d 00:00:00'))->diff($latestLog->recorded_at)->days > 1) {
            return 0;
        }

        return $this->commit_days;
    }

    /**
     * @return integer
     */
    public function getWpPasswordAttribute()
    {
        return Arr::get($this->meta, 'wp_password', null);
    }

    /**
     * @return integer
     */
    public function getWpUsernameAttribute()
    {
        return Arr::get($this->meta, 'wp_username', null);
    }

    /**
     * @return integer
     */
    public function getWpNicknameAttribute()
    {
        return Arr::get($this->meta, 'wp_nickname', null);
    }
}
