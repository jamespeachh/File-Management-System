<?php

namespace App\Services;

use App\Models\book;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use stdClass;

class BookListAppendService
{
    public function getBookList ()
    {
        if(!$this->bookListExists()){
            $this->getBookListFromSFTP();
        }
        return Cache::get('bookListFile');
    }

    private function bookListExists(): bool
    {
        if (!Cache::has('bookListFile')) {
            return false;
        }
        return true;
    }

    private function getBookListFromSFTP()
    {
        $data = Storage::disk('books')->get('bookList.json');
        Cache::put('bookListFile', $data, 60); //1 mins
    }
}
