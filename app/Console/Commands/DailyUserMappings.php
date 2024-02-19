<?php

namespace App\Console\Commands;

use App\Services\Cache\GetBookFileFromSQL;
use Illuminate\Console\Command;

class DailyUserMappings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:get-files';

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
        error_log("in mappings");
        $service = new GetBookFileFromSQL;
        $service->allUserMappings();
        return 0;
    }
}
