<?php

namespace App\Jobs;

use App\Services\Cache\BookTxtFileService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessBookPages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $bookID;
    private $pageNumber;
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
        $BTXTCache = new BookTxtFileService();

        $fileName = $this->bookID.'_'. $this->pageNumber;

        error_log('NEXT FILE CONFIRMATION // ' . $fileName);
        $BTXTCache->getBookTxtFile($this->bookID, $this->pageNumber);
    }

}
