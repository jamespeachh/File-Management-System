<?php

namespace App\Http\Controllers\Books;

use App\Services\Cache\BookListService;
use App\Http\Controllers\Controller;

class DirectoryController extends Controller
{
    public function index()
    {
        $Cache = new BookListService();
        $data = $Cache->getBookList();

        return view('Books.directory', compact('data'));
    }
}
