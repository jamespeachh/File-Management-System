<?php

namespace App\Services\Cache;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class BookTxtFileService
{
    public function getBookTxtFile($file)
    {
        if(!$this->bookTxtFileExists($file)){
            $this->getBookTxtFileFromSFTP($file);
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

    private function getBookTxtFileFromSFTP($file)
    {
        $data = Storage::disk('books')->get($file);
        Cache::put($file, $data, 600); //10 mins
    }
}
