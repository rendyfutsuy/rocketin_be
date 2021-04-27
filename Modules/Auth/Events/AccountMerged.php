<?php

namespace Modules\Auth\Events;

use Illuminate\Http\Request;
use Modules\Auth\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Collection;

class AccountMerged
{
    use SerializesModels;

    /**
     * @var User
     */
    public $mergeFrom;

    /**
     * @var Collection
     */
    public $statics;

    /**
     * @var User
     */
    public $mergeTo;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $mergeFrom, User $mergeTo)
    {
        $this->mergeFrom = $mergeFrom;
        $this->statics = $mergeFrom->verseStatics;
        $this->mergeTo = $mergeTo;
    }
}
