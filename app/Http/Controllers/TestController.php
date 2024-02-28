<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\BookBody;
use App\Models\categories;
use App\Models\User;
use App\Services\Cache\GetBookFileFromSQL;
use Faker\Core\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class TestController extends Controller
{
    public function index()
    {
        $cat = new categories();
        $items = $cat->getActive();
        Cache::put('testiesss', $items, 60);
        $array = [
            'items'=>$items
        ];

        return view('test', ['hello']);
    }
    public function submit(Request $request)
    {
        dd("working");
    }
}
