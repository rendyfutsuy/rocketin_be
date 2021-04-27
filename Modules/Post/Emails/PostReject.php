<?php

namespace Modules\Post\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;

class PostReject extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** @var \Modules\Post\Models\Post */
    public $post;

    /** @var string */
    public $note;


    public $subject = "Penolakan Iklan Kolom Baris";

    /**
     * Create a new message instance.
     *
     * @param  \Modules\Post\Models\Post  $post
     * @param  string  $note
     * @return void
     */
    public function __construct($post, $note)
    {
        $this->post = $post;
        $this->note = $note;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(Config::get('mail.default_email'))
            ->view('post::mails.reject')
            ->with([
                'userName' => $this->post->user->username,
                'locale' => $this->post->user->getLocale(),
                'title' => $this->post->title,
                'note' => $this->note,
                'wpLink' => $this->post->getWpUrl()
            ]);
    }
}
