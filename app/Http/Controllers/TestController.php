<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessBookPages;
use App\Services\Cache\BookListService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index()
    {
        Cache::put('bookName', '1Q84');
        ProcessBookPages::dispatch()->afterResponse();
        return view('test');
    }
}
