<?php

namespace App\Services\Cache;

use App\Models\BookBody;
use Illuminate\Support\Facades\Cache;

class BookTxtFileService
{
    public function getBookTxtFile($bookID, $pageNumber)
    {
        $file = $bookID .'_'. $pageNumber;
        if(!$this->bookTxtFileExists($file)){
            $this->getBookTxtFileFromSFTP($bookID,$pageNumber,$file);
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

    public function getBookTxtFileFromSFTP($book_id, $pageNumber, $fileName)
    {
        $body = new BookBody;
        $data = $body->getBody($book_id, $pageNumber);

        Cache::put($fileName, $data, 600); //10 mins
    }
}
