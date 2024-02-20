<?php

namespace App\Console\Commands\BooksScheduling;

use App\Services\Cache\BookListService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class hourlyGetList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:get-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the book list for the directory and other things';

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
        Log::info("$currentDateTime // Caching booklist");
        Cache::forget('bookList');
        $BLServe = new BookListService;
        $BLServe->getBookList();
        Log::info('CACHE UPDATED //' . Cache::has('bookList'));
        return 0;
    }
}
