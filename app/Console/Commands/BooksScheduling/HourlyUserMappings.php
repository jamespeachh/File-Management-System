<?php

namespace App\Console\Commands\BooksScheduling;

use App\Services\Cache\GetBookFileFromSQL;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class HourlyUserMappings extends Command
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
        $currentDateTime = Carbon::now();
        Log::info("$currentDateTime // Caching book mappings by user");
        $service = new GetBookFileFromSQL;
        $service->allUQserMappings();
        return 0;
    }
}
