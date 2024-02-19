<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\BookBody;
use App\Models\User;
use App\Services\Cache\GetBookFileFromSQL;
use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index()
    {
        $i = new GetBookFileFromSQL;
        $i->allUserMappings();
        return view('test');
    }
    public function submit(Request $request)
    {


    }
}
