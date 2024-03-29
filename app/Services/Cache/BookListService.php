<?php

namespace App\Services\Cache;

use App\Models\book;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class BookListService
{
    public function getBookList ()
    {
        if(!$this->bookListExists()){
            $this->getBookListFromSQL();
        }
        return Cache::get('bookList');
    }

    private function bookListExists(): bool
    {
        if (!Cache::has('bookList')) {
            return false;
        }
        return true;
    }

    private function getBookListFromSQL()
    {
        $jsonOBJ = ['books'=>[]];
        $books = book::query()->get()->toArray();
        foreach($books as $book){
            $jsonOBJ['books'][$book['title']] = [
                'id'=>$book['id'],
                'title'=>$book['formatted_title'],
                'unformatted'=>$book['title'],
                'pages'=>$book['pages'],
                'img'=>[
                    'src'=>$book['cover_pic'],
                    'alt'=>$book['title']
                ]
            ];
        }
        $myJSON = json_encode($jsonOBJ);
        $myJSON = json_decode($myJSON,true);
        Cache::put('bookList', $myJSON, 3600); //1 hour
    }
}
