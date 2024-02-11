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

class BookController extends Controller
{
     public function index($bookName, $pageNumber)
     {
         $b = new GetBookInformation();
         $bookID = $b->FullBookFromTitle($bookName)[0]['id'];
         return redirect()->route('run', ['bookID' => $bookID, 'pageNumber' => $pageNumber]);
     }

    public function getComments() : array
    {
        $c = new getCommentService;
        return $c->getComments();
    }

     public function indexNoVar($bookName) : \Illuminate\Http\RedirectResponse
     {
         $pageNumber = $this->getPageNumber($bookName);
         $query_builder = new GetBookInformation;
         $book = $query_builder->FullBookFromTitle($bookName);

         return redirect()->route('run', ['bookID' => $book[0]['id'], 'pageNumber' => $pageNumber]);
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

     public function submitComment(Request $request)
     {
         $b = new GetBookInformation();
         $c = new comments();
         $body = $request->input('body');
         $bookID = $request->input('bookID');
         $pageNumber = intval($request->input('pageNumber'));
         $id = Auth::id();

         $bookTitle = $b->FullBookFromID($bookID)[0]['title'];
         if($bookID != 'none') $c->insertComment($body, $bookID, $pageNumber, $id);

         return redirect()->action([BookController::class, 'index'], ['bookName'=>$bookTitle,'pageNumber'=>$pageNumber]);


     }


    public function deleteComment(Request $request)
    {
        $b = new GetBookInformation();
        $c = new comments();
        $comment = $request->query('comment');
        $bookID = $request->query('bookID');
        $pageNumber = $request->query('pageNumber');
        $c->deleteCommentByID($comment);

        $bookTitle = $b->FullBookFromID($bookID)[0]['title'];
        return redirect()->action([BookController::class, 'index'], ['bookName'=>$bookTitle,'pageNumber'=>$pageNumber]);
    }

     public function bookBuilder(Request $request)
     {
         if (!$request->has('bookID'))
         {
             return redirect()->route('directory', ['alertMessage'=>1]);
         }

         $BLCache = new BookListService;
         $BTXTCache = new BookTxtFileService;
         $query_builder = new GetBookInformation;

         $bookID = $request->query('bookID');
         $book = $query_builder->FullBookFromID($bookID);

         if (!$request->has('pageNumber'))
         {
             $pageNumber = $this->getPageNumber($book[0]['title']);
         } else $pageNumber = $request->query('pageNumber');


         // book information
         //book text
         $pageNumber = $this->validatePageNumber($pageNumber, $book[0]['pages']);
         $bookTxtFileContents = $BTXTCache->getBookTxtFile($book[0]['id'], $pageNumber);
         GetAllComments::dispatch($book[0]['id'], $pageNumber);


         // JOBS
         // get next page, so it's smoother for the viewer
         if ($pageNumber != $book[0]['pages'])
             ProcessBookPages::dispatch($book[0]['id'], intval($pageNumber) + 1)->afterResponse();
         UpsertUserInformation::dispatch($book[0]['id'], $pageNumber)->afterResponse();
         error_log('sending to view');
         return view('Books.index', [
             'fileContents' => $bookTxtFileContents,
             'pageNum' => $pageNumber,
             'url' => '/book?bookID=' . $bookID,
             'bookTitle' => $book[0]['formatted_title'],
             'bookID' => $book[0]['id'],
             'data' => $BLCache->getBookList(),
         ]);
     }

    private function getPageNumber($bookName)
    {
        $query_builder = new GetBookInformation;
        $userID = Auth::id();
        $bookID = $query_builder->FullBookFromTitle($bookName);

        $mappings = UserBookMapping::query()
            ->select('page_number')
            ->where('book_id', $bookID[0]['id'])
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

