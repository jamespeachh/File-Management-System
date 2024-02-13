<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\BookBody;
use App\Models\User;
use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index()
    {

        return view('test');
    }
    public function submit(Request $request)
    {


    }
}
