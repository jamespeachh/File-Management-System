<?php

namespace App\Services\Cache;

use App\Models\BookBody;
use Illuminate\Support\Facades\Cache;

class GetBookFileFromSQL
{
    public function getBookTxtFile($book_id, $page_number)
    {
        $file = 'text_content_book_'.$book_id.'_page_'.$page_number;
        if(!$this->bookTxtFileExists($file)){
            $this->getBookTxtFileFromMySQL($file,$book_id,$page_number);
        }
        return Cache::get($file);
    }

    private function bookTxtFileExists($file): bool
    {
        if (!Cache::has($file)) {
            return false;
        }
        return true;
    }

    private function getBookTxtFileFromMySQL($fileName, $bid, $pnum)
    {
        $data = BookBody::query()
            ->select()
            ->where(['book_id'=>$bid])
            ->where(['page_number'=>$pnum])
            ->get()
            ->toArray();
        Cache::put($fileName, $data[0]['body_text'], 86400); //24 hour
    }
}
