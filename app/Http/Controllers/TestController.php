<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\BookBody;
use App\Models\categories;
use App\Models\category_book_mappings;
use App\Models\list_items;
use App\Models\passwords;
use App\Models\User;
use App\Services\Cache\GetBookFileFromSQL;
use App\Services\yclDB\getCommentService;
use Faker\Core\File;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $b = new book();
        $books = $b->query()->select()
            ->get()
            ->toArray();
//        $books = [["id"=>1,"formatted_title"=>"book 1"],["id"=>2,"formatted_title"=>"book 2"],["id"=>3,"formatted_title"=>"book 3"],["id"=>4,"formatted_title"=>"book 4"]];
        return view('test', ['books'=>$books]);
    }


    public function submit(Request $request)
    {
        $li = new list_items();

//        dd("working");

        $onSite = $request->input('onSite') === 'yes' ? 1 : 0;
        $bookID = $request->input('book');
        $title = $request->input('title');
        $author = $request->input('author');
        $summary = $request->input('summary');
        $addBook=$request->input('addBook', false) ? 1 : 0;
        if($onSite == 1){
            $b = new book();
            $title = $b->query()->select()->where("id",$bookID)->get()->toArray()[0]['formatted_title'];
            $author = "";
            $summary="";
            $addBook=0;
        }

        // Prepare the data for insertion
        dump(
        $data = [
            'list_id' => $request->input('list_id'), // Assuming you have a list_id in your form
            'user_id' => auth()->id(), // Assuming the user is authenticated
            'on_site' => $onSite,
            'book_id' => $bookID,
            'title' => $title,
            'author' => $author,
            'summary' => $summary,
            'want_book_added' => $addBook,
            'status' => $request->input('read') ? 'read' : 'not read',
            'rating' => $request->input('rateqm') ? $request->input('rate') : null,
        ]);

        // Insert the data into the database using Eloquent
        dump(
        $li->query()->insert($data));

//        dd($onSite,$book,$title,$author,$summary,$addBook,$read,$rate);
        dd("working");

    }
}
