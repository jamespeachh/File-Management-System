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
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $BTXTCache = new BookTxtFileService();
        $file = Cache::get('nextFile');
        $BTXTCache->getBookTxtFile($file);
    }

    private function bookFileExists($cacheLocation): bool
    {
        if (!Cache::has($cacheLocation)) {
            return false;
        }
        return true;
    }
}
