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
            return view('admin');
        }
        return view('home');
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

            dd("do not have wipe yet, just wait or change this");
            BookBody::query()->insert([
                'book_id'=>$bookID,
                'page_number'=>$i,
                'body_text'=>$curBook
            ]);
        }
    }

    public function pullChanges()
    {
        dump('sh '.env('LOCAL_PATH_TO_PROJECT').'pull.sh');
        dump(shell_exec('sh '.env('LOCAL_PATH_TO_PROJECT').'pull.sh'));
    }

    public function submit(Request $request)
    {
        $BookBodies = $request->input('book_bodies');
        $pull = $request->input('pull');

        if($BookBodies == 'on') $this->buildAllBooksFromSFTP();
        if($pull == 'on') $this->pullChanges();
    }
}
