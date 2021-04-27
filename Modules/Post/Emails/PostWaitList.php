<?php

namespace Modules\Post\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Queue\ShouldQueue;

class PostWaitList extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** @var \Modules\Post\Models\Post */
    public $post;

    public $subject = "Iklan Masuk Wait List Kolom Baris";

    /**
     * Create a new message instance.
     *
     * @param  \Modules\Post\Models\Post  $post
     * @return void
     */
    public function __construct($post)
    {
        $this->post = $post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(Config::get('mail.default_email'))
            ->view('post::mails.wait-list')
            ->with([
                'locale' => $this->post->user->getLocale(),
                'title' => $this->post->title,
                'wpLink' => $this->post->getWpUrl(),
                'status' => $this->post->status,
                'postLink' => route('super.admin.detail.post', $this->post->id),
            ]);
    }
}
