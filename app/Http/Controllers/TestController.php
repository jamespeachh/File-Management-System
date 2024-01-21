<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
        $users = DB::connection('ycl')->select('select * from book', [1]);
        dd($users);
        return view('user.index', ['users' => $users]);
        return view('test');
    }
}
