<?php

namespace Modules\Profile\Http\Resources;

use Modules\Auth\Models\User;
use Modules\Post\Models\Post;

class HomePage
{
    /** @var User */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return array
     */
    public function render()
    {
        return [
            'avatar' => $this->user->full_avatar_path,
            'email' => $this->user->email,
            'is_email_verified' => $this->user->noUnverifiedEmail(),
            'unverified_email' => $this->user->getEmail(),
            'phone' => $this->user->phone,
            'is_phone_verified' => $this->user->noUnverifiedPhone(),
            'unverified_phone' => $this->user->getPhone(),
            'name' => $this->user->getUsername(),
            'birthday' => $this->user->profile->birthday,
            'gender' => $this->user->profile->gender,
            'gender_type' => $this->user->profile->gender_type,
            'full_name' => $this->user->profile->full_name,
            'nationality' => $this->user->profile->nationality,
            'join_at' => $this->user->created_at->format('Y-m-d'),
            'post_all' => $this->user->posts->count(),
            'post_new' => $this->user->posts->where('status', Post::DRAFTED)->count(),
            'post_wait_list' => $this->user->posts->where('status', Post::WAITED)->count(),
            'post_published' => $this->user->posts->where('status', Post::PUBLISHED)->count(),
            'posts_url' => route('api.post.list'),
            'medias_url' => route('api.media.list'),
        ];
    }
}
