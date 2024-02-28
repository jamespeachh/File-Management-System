<?php

namespace App\Http\Controllers\Books;

use App\Jobs\GetAllUserMappedBooks;
use App\Services\Cache\BookListService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DirectoryController extends Controller
{
    public function index(Request $request)
    {
        $Cache = new BookListService();
        $data = $Cache->getBookList();

        GetAllUserMappedBooks::dispatch()->afterResponse();
        if ($request->has('alertMessage'))
        {
            return view('Books.directory', [
                'alertExists'=>true,
                'alertMessage'=>$request->get('alertMessage'),
                'data'=>$data
            ]);
        }
        return view('Books.directory', ['data'=>$data, 'alertExists'=>false]);
    }
}
