<?php

namespace App\Http\Controllers;

use App\Models\yclDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
         $test = yclDatabase::query()->get()->toArray();
         dump($test);
        $user = json_decode(Auth::user(), true);
        $group = $user['auth_group'];
        if($group == 9){
            dump(true);
        }
        $id = Auth::id();
        dd($user, $id,$group);
    }
}
