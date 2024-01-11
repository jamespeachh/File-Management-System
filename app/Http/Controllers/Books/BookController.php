<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Services\Cache\CacheService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index($bookName, $pageNumber)
    {
        $Cache = new CacheService();
        $data = $Cache->getBookList();
        
        $fileInfo = $this->findBookFileInfo($bookName, $pageNumber);
        $pageNumber = $fileInfo[1];

        //make sure the file/Book exists
        try {
            $fileContents = File::get($fileInfo[0] . '/' . $bookName . '_' . $pageNumber . '.txt');
        }catch (\Exception $e) {
            dump($e);
            return view('Books.directory');
        }

        $bookNameFormatted = $this->formatBookTitle($bookName, $data);

        return view('Books/index', [
            'fileContents' => $fileContents,
            'pageNum' => $pageNumber,
            'url' => '/book/' . $bookName . '/',
            'bookTitle'=>$bookNameFormatted,
            'data' => $data
        ]);
    }

    public function indexNoVar($bookName)
    {
        $filePath = public_path('/Book/' . $bookName);

        //make sure the file/Book exists
        try {
            $fileContents = File::get($filePath . '/' . $bookName . '_' . 1 . '.txt');
        }catch (\Exception $e) {
            return view('Books.directory');
        }

        return view('Books/index', [
            'fileContents' => $fileContents,
            'pageNum' => 1,
            'url' => '/book/' . $bookName . '/',
            'bookTitle'=>$bookName
        ]);
    }

    private function findBookFileInfo($bookName, $pageNumber) : array
    {
        $filePath = public_path('/Book/' . $bookName);

        // count how many files are in the directory
        if (File::isDirectory($filePath)) {
            $files = File::files($filePath);
            $fileCount = count($files);
            // replace pageNumber if too high or too low
            if ($pageNumber > $fileCount) $pageNumber = 1;
            if ($pageNumber <= 0) $pageNumber = 1;
        }

        return [$filePath, $pageNumber];
    }

    private function formatBookTitle($originalTitle, $data) : string
    {
        foreach($data['books'] as $item){
            if(strtolower($originalTitle) == strtolower($item['unformatted'])) return $item['title'];
        }
        return $originalTitle;
    }

}
