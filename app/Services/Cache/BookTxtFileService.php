<?php

namespace App\Services\Cache;

use App\Models\BookBody;
use App\Models\UserBookMapping;
use Illuminate\Support\Facades\Auth;
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

    public function allUserMappedFiles()
    {
        $ubm = new UserBookMapping;
        $datas = $ubm->allMappingsForUser(Auth::id());

        foreach($datas as $data)
        {
            $this->getBookTxtFile($data['book_id'], $data['page_number']);
        }
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

        Cache::put($fileName, $data, 86400); //24 hours
    }
}
