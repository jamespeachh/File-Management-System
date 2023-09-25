<?php

namespace App\Http\Controllers\Books;

use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;

class DirectoryController extends Controller
{
    public function index()
    {
        $data = json_decode(File::get(storage_path('bookList.json')), true);
        // dd($data);
        return view('Books.directory', compact('data'));
    }
}
