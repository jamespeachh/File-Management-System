<?php

namespace App\Console\Commands;

use App\Services\Cache\BookListService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

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
        Cache::forget('bookList');
        $BLServe = new BookListService;
        $BLServe->getBookList();
        ERROR_LOG('CACHE UPDATED //' . Cache::has('bookList'));
        return 0;
    }
}
