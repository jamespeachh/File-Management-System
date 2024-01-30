<?php

namespace App\Http\Controllers;

use App\Models\yclDatabase;
use App\Services\BookListAppendService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

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
//        dd($user, $id,$group);
        $BLCache = new BookListAppendService();
        $BLData = $BLCache->getBookList();
        $hi = json_decode($BLData);
        dd($hi);
    }
}
