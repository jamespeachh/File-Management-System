<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\BookBody;
use App\Models\categories;
use App\Models\category_book_mappings;
use App\Models\User;
use App\Services\Cache\GetBookFileFromSQL;
use Faker\Core\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class TestController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('id')){
            dump($request->get('id'));
            $catMap = new category_book_mappings;
            $catMap->getByCatID($request->get('id'));
            dd($catMap->getByCatID($request->get('id')));
        }else{
            //all books
        }

        $cat = new categories();
        $items = $cat->getActive();
        $array = [
            'items'=>$items
        ];
//        dd($array);

        return view('test', $array);
    }
    public function submit(Request $request)
    {
        dd($request->get('option'));
        dd("working");

    }
}
