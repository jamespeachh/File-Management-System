<?php

namespace App\Jobs;

use App\Services\Cache\BookTxtFileService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ProcessBookPages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $nextFile;
    public function __construct($nextFile)
    {
        $this->nextFile = $nextFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $BTXTCache = new BookTxtFileService();
        error_log('NEXT FILE CONFIRMATION // ' . $this->nextFile);
        $BTXTCache->getBookTxtFile($this->nextFile);
    }

}
