<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\BookBody;
use App\Models\categories;
use App\Models\category_book_mappings;
use App\Models\passwords;
use App\Models\User;
use App\Services\Cache\GetBookFileFromSQL;
use Faker\Core\File;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class TestController extends Controller
{
    public function index(Request $request)
    {
        return view('test');
    }
    public function submit(Request $request)
    {
        dump($request->input('rating'));
        dd("working");

    }
}
