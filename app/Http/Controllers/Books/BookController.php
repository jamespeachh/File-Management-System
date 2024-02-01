<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessBookPages;
use App\Jobs\UpsertUserInformation;
use App\Models\UserBookMapping;
use App\Services\Cache\BookListService;
use App\Services\Cache\BookTxtFileService;
use App\Services\yclDB\GetBookInformation;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
     public function index($bookName, $pageNumber)
     {
         $BLCache = new BookListService;
         $BTXTCache = new BookTxtFileService;
         $query_builder = new GetBookInformation;

         // book information
         $book = $query_builder->FullBookFromTitle($bookName);
         //book text
         $pageNumber = $this->validatePageNumber($pageNumber, $book[0]['pages']);
         $bookTxtFileContents = $BTXTCache->getBookTxtFile($book[0]['id'], $pageNumber);


         // JOBS
         // get next page, so it's smoother for the viewer
         ProcessBookPages::dispatch($book[0]['id'], intval($pageNumber)+1)->afterResponse();
         UpsertUserInformation::dispatch($book[0]['id'], $pageNumber)->afterResponse();


         return view('Books.index', [
             'fileContents' => $bookTxtFileContents,
             'pageNum' => $pageNumber,
             'url' => '/book/' . $bookName . '/',
             'bookTitle'=>$book[0]['formatted_title'],
             'data' => $BLCache->getBookList()
         ]);
     }

     public function indexNoVar($bookName) : \Illuminate\Http\RedirectResponse
     {
         $query_builder = new GetBookInformation;
         $userID = Auth::id();
         $bookID = $query_builder->FullBookFromTitle($bookName);

         $mappings = UserBookMapping::query()
             ->select('page_number')
             ->where('book_id', $bookID[0]['id'])
             ->where('user_id',$userID)
             ->get()
             ->toArray();

         if(count($mappings)!=0){
             $pageNumber = $mappings[0]['page_number'];
             return redirect()->action([BookController::class, 'index'], ['bookName'=>$bookName,'pageNumber'=>$pageNumber]);
         } else {
             return redirect()->action([BookController::class, 'index'], ['bookName'=>$bookName,'pageNumber'=>1]);
         }
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

}

