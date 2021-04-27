<?php

namespace Modules\Post\Commands;

use Carbon\Carbon;
use Modules\Post\Models\Post;
use Illuminate\Console\Command;

class InputDefaultPublishDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:insert-publish-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'TBA';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        Post::query()
            ->update([
                'published_at' => Carbon::now(),
            ]);

        $this->info(PHP_EOL . 'Post Publish Date Released!');
    }
}
