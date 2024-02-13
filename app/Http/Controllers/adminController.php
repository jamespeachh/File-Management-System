<?php

namespace App\Http\Controllers;

use App\Models\BookBody;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class adminController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        if($id == 1){
//            $this->buildAllBooksFromSFTP();
            dump('inside auth');
        }
        return view('admin');
    }
    private function buildAllBooksFromSFTP()
    {
        $this->insertOrReplace(23, '1984', 1);
        $this->insertOrReplace(79, '1Q84', 2);
        $this->insertOrReplace(60, 'ADarkerShadeOfMagic', 3);
        $this->insertOrReplace(31, 'BalladOfSongbirdsAndSnakes', 4);
        $this->insertOrReplace(28, 'circe', 5);
        $this->insertOrReplace(11, 'thestranger', 6);
    }

    public function insertOrReplace($pages, $bookTitle, $bookID)
    {
        for($i=1; $i<=$pages; $i++)
        {
            $curBook = Storage::disk('books')
                ->get($bookTitle.'/'.$bookTitle.'_'.$i.'.txt');

            dd(BookBody::query()->count()
                ->where('book_id', $bookID)
                ->where('page_number', $i));
            die();
            BookBody::query()->insert([
                'book_id'=>$bookID,
                'page_number'=>$i,
                'body_text'=>$curBook
            ]);
        }
    }

    public function submit(Request $request)
    {
        $BookBodies = $request->input('book_bodies');
        $pull = $request->input('pull');

        if($BookBodies == 'on') $this->buildAllBooksFromSFTP();
        if($pull == 'on') dump('pull: wow');

    }
}
