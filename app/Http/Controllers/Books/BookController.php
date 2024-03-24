<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Jobs\GetAllComments;
use App\Jobs\ProcessBookPages;
use App\Jobs\UpsertUserInformation;
use App\Models\comments;
use App\Models\UserBookMapping;
use App\Services\Cache\BookListService;
use App\Services\Cache\BookTxtFileService;
use App\Services\yclDB\GetBookInformation;
use App\Services\yclDB\getCommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
     public function index(Request $request)
     {
         $BLCache = new BookListService;
         $BTXTCache = new BookTxtFileService;
         $query_builder = new GetBookInformation;

         if (!$request->has('bookID'))
         {
             return redirect()->route('directory', ['alertMessage'=>1]);
         }

         $bookID = $request->query('bookID');
         $book = $query_builder->FullBookFromID($bookID);

         if (!$request->has('pageNumber'))
         {

             $pageNumber = $this->getPageNumber($book);
         } else $pageNumber = $request->query('pageNumber');
         if ($request->has('reported'))
         {
             Log::error('');
             Log::error('PAGE REPORTED // PAGE REPORTED // PAGE REPORTED // PAGE REPORTED');
             Log::error('');
             Log::error('BOOK ID // ' . $bookID);
             Log::error('PAGE NUM // ' . $pageNumber);
             Log::error('');
             Log::error('PAGE REPORTED // PAGE REPORTED // PAGE REPORTED // PAGE REPORTED');
             Log::error('');
         }

         // book information
         //book text
         $pageNumber = $this->validatePageNumber($pageNumber, $book[0]['pages']);
         $bookTxtFileContents = $BTXTCache->getBookTxtFile($bookID, $pageNumber);
         GetAllComments::dispatch($bookID, $pageNumber);

         // JOBS
         // get next page, so it's smoother for the viewer
         if ($pageNumber != $book[0]['pages'])
             ProcessBookPages::dispatch($bookID, intval($pageNumber) + 1)->afterResponse();
         UpsertUserInformation::dispatch($bookID, $pageNumber)->afterResponse();
         error_log('sending to view');


         return view('Books.index', [
             'fileContents' => $bookTxtFileContents,
             'pageNum' => $pageNumber,
             'url' => '/book?bookID=' . $bookID,
             'bookTitle' => $book[0]['formatted_title'],
             'bookID' => $bookID,
             'data' => $BLCache->getBookList(),
         ]);
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

    private function getPageNumber($book)
    {
        $userID = Auth::id();

        $mappings = UserBookMapping::query()
            ->select('page_number')
            ->where('book_id', $book[0]['id'])
            ->where('user_id', $userID)
            ->get()
            ->toArray();

        if(count($mappings)!=0){
            return $mappings[0]['page_number'];
        } else {
            return 1;
        }
    }

}

