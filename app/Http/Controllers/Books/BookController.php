<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Jobs\GetAllComments;
use App\Jobs\UpsertUserInformation;
use App\Models\UserBookMapping;
use App\Services\EPUBService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    private $epubService;

    public function __construct(EPUBService $epubService)
    {
        $this->epubService = $epubService;
    }

    public function addBook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'chapters' => 'required|array',
            'chapters.*' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $book = $this->epubService->addNewBook(
                $request->title,
                $request->author,
                $request->chapters
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Book added successfully',
                'book' => $book
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add book',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index(Request $request)
    {
        $epubService = new EPUBService();

        if (!$request->has('bookID'))
        {
            return redirect()->route('directory', ['alertMessage'=>1]);
        }

        $bookID = $request->query('bookID');
        $bookMetadata = $epubService->getBookMetadata($bookID);

        if (!$bookMetadata) {
            return redirect()->route('directory', ['alertMessage'=>2]);
        }

        if (!$request->has('pageNumber'))
        {
            $pageNumber = $this->getPageNumber($bookMetadata);
        } else {
            $pageNumber = $request->query('pageNumber');
        }

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

        $pageNumber = $this->validatePageNumber($pageNumber, $bookMetadata['pages']);
        $bookContent = $epubService->getBookContent($bookID, $pageNumber);
        
        GetAllComments::dispatch($bookID, $pageNumber);
        UpsertUserInformation::dispatch($bookID, $pageNumber)->afterResponse();

        return view('Books.index', [
            'fileContents' => $bookContent,
            'pageNum' => $pageNumber,
            'url' => '/book?bookID=' . $bookID,
            'bookTitle' => $bookMetadata['title'],
            'bookID' => $bookID,
            'data' => [], // This will need to be updated based on how you want to handle the book list
        ]);
    }

    private function validatePageNumber($pageNumber, $bookTotalPageNumber) : int
    {
        $pageNumber = (int) $pageNumber;
        
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

    private function getPageNumber($bookMetadata)
    {
        $userID = Auth::id();

        $mappings = UserBookMapping::query()
            ->select('page_number')
            ->where('book_id', $bookMetadata['id'])
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

