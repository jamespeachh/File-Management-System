<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessBookPages;
use App\Models\UserBookMapping;
use App\Models\book;
use App\Services\Cache\BookListService;
use App\Services\Cache\BookTxtFileService;
use Illuminate\Support\Facades\Auth;
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
        $this->upsertPageNum($bookName, $pageNumber);


        return view('Books.index', [
            'fileContents' => $bookTxtFileContents,
            'pageNum' => $pageNumber,
            'url' => '/book/' . $bookName . '/',
            'bookTitle'=>$bookNameFormatted,
            'data' => $data
        ]);
    }

    public function indexNoVar($bookName) : \Illuminate\Http\RedirectResponse
    {
        $userID = Auth::id();
        $bookID = book::query()->select('id')->where('title', $bookName)
            ->get()
            ->toArray()[0]['id'];
        $mappings = UserBookMapping::query()
            ->select('page_number')
            ->where('book_id', $bookID)
            ->where('user_id',$userID)
            ->count();

        if($mappings!=0){
            $pageNumber = UserBookMapping::query()
                ->select('page_number')
                ->where('book_id', $bookID)
                ->where('user_id',$userID)
                ->get()
                ->toArray()[0]['page_number'];
            return redirect()->action([BookController::class, 'index'], ['bookName'=>$bookName,'pageNumber'=>$pageNumber]);
        } else {
//            $this->index($bookName, 1);
            return redirect()->action([BookController::class, 'index'], ['bookName'=>$bookName,'pageNumber'=>1]);
        }

    }

    public function upsertPageNum($bookName, $pageNumber) {
        $id = Auth::id();
        $curBook = book::query()->select('id')->where(['title'=>$bookName])->get()->toArray()[0]['id'];
        UserBookMapping::query()->upsert(
            [
                ['book_id' => intval($curBook), 'user_id' => intval($id), 'page_number' => intval($pageNumber)],
            ],
            ['book_id', 'user_id'],
            ['page_number']
        );
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
