<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    // 1984 = 23
    public function index(Request $request)
    {
        $output = shell_exec('/home/dh_zkwizb/yellowcandlelibrary.com/');
        ERROR_LOG("<pre>$output</pre>");
        dd($output);
        $data = Storage::disk('assets')->get('covers/1q84.jpeg');
        dump(Storage::disk('assets')->files('covers/'));
        $paramValue = $request->query('testinghehe');
        dd($paramValue);
        $data = "Hello?????";

        return view('test', ['data'=>$data]);
    }
}
