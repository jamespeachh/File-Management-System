<?php

namespace App\Http\Controllers;

use App\Models\UserBookMapping;
use App\Models\book;
use App\Services\BookListAppendService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class TestController extends Controller
{
    public function index()
    {
        $bookName = 'circe';
        $userID = Auth::id();
        $bookID = book::query()
            ->select('id')
            ->where('title', $bookName)
            ->get()
            ->toArray()[0]['id'];

        $data = UserBookMapping::query()
            ->select('page_number')
            ->where('book_id', $bookID)
            ->where('user_id',$userID)
            ->get()
            ->toArray();
        dd($data);
    }
}
