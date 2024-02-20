<?php

namespace App\Console\Commands\BooksScheduling;

use App\Services\yclDB\getCommentService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class HourlyGetAllCommentsByMappings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comments:all-comments-by-mapping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $currentDateTime = Carbon::now();
        Log::info("$currentDateTime // Caching the comments by user mappings");
        $commentS = new getCommentService;
        error_log("Getting all comments by mappings");
        $commentS->getComments();
        return 0;
    }
}
