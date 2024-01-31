<?php

namespace App\Http\Controllers;

use App\Models\BookBody;
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
        $data = BookBody::query()
            ->select()
            ->get()
            ->toArray();
        dd($data);
    }
}
