<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessBookPages;
use App\Services\Cache\BookListService;
use App\Services\Cache\BookTxtFileService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index($bookName, $pageNumber)
    {
        $BTXTCache = new BookTxtFileService();
        $BLCache = new BookListService();
        $data = $BLCache->getBookList();

        $fileInfo = $this->findBookFileInfo($bookName, $pageNumber);
        $pageNumber = $fileInfo[1];

        $bookTxtFileContents = $BTXTCache->getBookTxtFile($fileInfo[0] . '/' . $bookName . '_' . $pageNumber . '.txt');
        $bookNameFormatted = $this->formatBookTitle($bookName, $data);

        // get next page so it's smoother for the viewer
//        Cache::put('nextFile', $fileInfo[0] . '/' . $bookName . '_' . ($pageNumber+1) . '.txt', 600);
//        ProcessBookPages::dispatch()->afterResponse();

        return view('Books.index', [
            'fileContents' => $bookTxtFileContents,
            'pageNum' => $pageNumber,
            'url' => '/book/' . $bookName . '/',
            'bookTitle'=>$bookNameFormatted,
            'data' => $data
        ]);
    }

    public function indexNoVar($bookName)
    {
        $this->index($bookName, 1);
    }

    private function findBookFileInfo($bookName, $pageNumber) : array
    {
        $filePath = '/'.$bookName;

        // count how many files are in the directory
        if (Storage::disk('books')->directories($filePath)) {
            $files = Storage::disk('books')->allFiles($filePath);
            dd($files);
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
