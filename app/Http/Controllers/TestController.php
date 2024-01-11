<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Cache\CacheService;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index()
    {
        $Cache = new CacheService();
        $data = $Cache->getBookList();

        return view('test', compact('data'));
    }
}
