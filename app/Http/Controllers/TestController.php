<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $data = json_decode(File::get(storage_path('bookList.json')), true);

        return view('test', compact('data'));
    }
}
