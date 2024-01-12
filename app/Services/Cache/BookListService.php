<?php

namespace App\Services\Cache;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class BookListService
{
    public function getBookList ()
    {
        if(!$this->bookListExists()){
            $this->getBookListFromSFTP();
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

    private function getBookListFromSFTP()
    {
        $data = json_decode(Storage::disk('books')->get('bookList.json'), true);
        Cache::put('bookList', $data, 600); //10 mins
    }
}
