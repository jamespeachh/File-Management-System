<?php

namespace App\Console\Commands;

use App\Services\yclDB\getCommentService;
use Illuminate\Console\Command;

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
        $commentS = new getCommentService;
        error_log("Getting all comments by mappings");
        $commentS->getComments();
        return 0;
    }
}
