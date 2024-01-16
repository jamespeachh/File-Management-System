<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessBookPages;
use App\Services\Cache\BookListService;
use App\Services\Cache\BookTxtFileService;
use Illuminate\Support\Facades\Cache;

class BookController extends Controller
{
    public function index($bookName, $pageNumber)
    {
        $BTXTCache = new BookTxtFileService();
        $BLCache = new BookListService();
        $data = $BLCache->getBookList();
        $pageNumber = $this->validatePageNumber($pageNumber, $data['books'][$bookName]['pages']);

        $bookTxtFileContents = $BTXTCache->getBookTxtFile($bookName . '/' . $bookName . '_' . $pageNumber . '.txt');
        $bookNameFormatted = $this->formatBookTitle($bookName, $data);

        // get next page so it's smoother for the viewer
        Cache::put('nextFile', $bookName . '/' . $bookName . '_' . (intval($pageNumber)+1) . '.txt', 600);
        ProcessBookPages::dispatch()->afterResponse();

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

    private function validatePageNumber($pageNumber, $bookTotalPageNumber) : string
    {
        if ($pageNumber > $bookTotalPageNumber)
        {
            $pageNumber = $bookTotalPageNumber;
        }
        else if ($pageNumber <= 0)
        {
            $pageNumber = 1;
        }

        return $pageNumber;
    }

    private function formatBookTitle($originalTitle, $data) : string
    {
        foreach($data['books'] as $item){
            if(strtolower($originalTitle) == strtolower($item['unformatted'])) return $item['title'];
        }
        return $originalTitle;
    }

}
