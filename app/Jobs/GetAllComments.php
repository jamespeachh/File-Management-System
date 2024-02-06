<?php

namespace App\Jobs;

use App\Models\comments;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class GetAllComments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $pageNumber;

    private $bookID;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($bookID, $pageNumber)
    {
        $this->bookID = $bookID;
        $this->pageNumber = $pageNumber;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        error_log('getting comments now!');
        $commentQuery = new comments();
        $comments = $commentQuery->getAllByBookAndPage($this->bookID, $this->pageNumber);
        Cache::put('cur_comments', $comments);
    }
}
