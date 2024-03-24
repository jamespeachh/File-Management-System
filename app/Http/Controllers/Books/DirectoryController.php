<?php

namespace App\Http\Controllers\Books;

use App\Jobs\GetAllUserMappedBooks;
use App\Models\categories;
use App\Models\category_book_mappings;
use App\Services\Cache\BookListService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DirectoryController extends Controller
{
    public function index(Request $request)
    {
        $alert = false;
        $Cache = new BookListService();
        $data = $Cache->getBookList();
        $alertMessage = 0;


        $cat = new categories();
        $items = $cat->getActive();


        GetAllUserMappedBooks::dispatch()->afterResponse();
        if ($request->has('alertMessage'))
        {
            $alert = true;
            $alertMessage=$request->get('alertMessage');
        }
        if($request->has('selected_cat_id')){
            $selected = $request->get('selected_cat_id');
            $catMap = new category_book_mappings;
            $selectedCategoryMappings = $catMap->getByCatID($selected);
            $temp = [];
            foreach($data['books'] as $item)
            {
                foreach($selectedCategoryMappings as $i){
                    if($item['id'] == $i['book_id'])
                        $temp['books'][] = $item;
                }
            }
            if(count($temp) !== 0)
                return view('Books.directory', ['data'=>$temp, 'alertExists'=>$alert, 'items'=>$items, 'alertMessage'=>$alertMessage, 'name'=>" - " . $items[$selected-3]['title']]);
            else {
                $alert = true;
                $alertMessage=2;
            }
        }
        dump($items, $data);
        return view('Books.directory', ['data'=>$data, 'alertExists'=>$alert, 'items'=>$items, 'alertMessage'=>$alertMessage, 'name'=>'']);

    }
}
