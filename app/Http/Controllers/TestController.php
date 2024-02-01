<?php

namespace App\Http\Controllers;

use App\Models\BookBody;
use App\Models\UserBookMapping;
use App\Models\book;
use App\Services\BookListAppendService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use stdClass;

class TestController extends Controller
{
    // 1984 = 23
    public function index()
    {
        dd('nothing here');
    }
}
