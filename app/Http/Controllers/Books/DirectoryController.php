<?php

namespace App\Http\Controllers\Books;

use App\Jobs\GetAllUserMappedBooks;
use App\Services\Cache\BookListService;
use App\Http\Controllers\Controller;

class DirectoryController extends Controller
{
    public function index()
    {
        $Cache = new BookListService();
        $data = $Cache->getBookList();

        GetAllUserMappedBooks::dispatch()->afterResponse();

        return view('Books.directory', compact('data'));
    }
}
