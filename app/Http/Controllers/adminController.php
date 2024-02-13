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
        $this->insert(23, '1984', 1);
        $this->insert(79, '1Q84', 2);
        $this->insert(60, 'ADarkerShadeOfMagic', 3);
        $this->insert(31, 'BalladOfSongbirdsAndSnakes', 4);
        $this->insert(28, 'circe', 5);
        $this->insert(11, 'thestranger', 6);
    }

    public function insert($pages, $bookTitle, $bookID)
    {
        for($i=1; $i<=$pages; $i++)
        {
            $curBook = Storage::disk('books')
                ->get($bookTitle.'/'.$bookTitle.'_'.$i.'.txt');

            BookBody::query()->insert([
                'book_id'=>$bookID,
                'page_number'=>$i,
                'body_text'=>$curBook
            ]);
        }
    }

    public function submit(Request $request)
    {
        $BookBodies = $request->query('book_bodies');
        $pull = $request->query('pull');
        dd($BookBodies, $pull);
    }
}
