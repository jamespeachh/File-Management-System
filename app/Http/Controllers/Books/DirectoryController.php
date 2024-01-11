<?php

namespace App\Http\Controllers\Books;

use App\Services\Cache\CacheService;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DirectoryController extends Controller
{
    public function index()
    {
        $Cache = new CacheService();
        $data = $Cache->getBookList();

        return view('Books.directory', compact('data'));
    }
}
