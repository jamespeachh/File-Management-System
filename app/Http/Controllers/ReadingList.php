<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\list_items;
use Illuminate\Http\Request;

class ReadingList extends Controller
{
    public function index()
    {
        $b = new book();
        $li = new list_items();
        $books = $b->query()->select()
            ->get()
            ->toArray();
        $listItems = $li->ActiveItemsByUser(auth()->id());
//        $listItems = [];
//        $books = [];
        return view('reading-list', ['books'=>$books, 'listItems'=>$listItems]);
    }


    public function submit(Request $request)
    {
        $li = new list_items();

        $onSite = $request->input('onSite') === 'yes' ? 1 : 0;
        $bookID = $request->input('book');
        $title = $request->input('title');
        $author = $request->input('author');
        $summary = $request->input('summary');
        $addBook=$request->input('addBook', false) ? 1 : 0;
        if($onSite == 1){
            $b = new book();
            $title = $b->query()->select()->where("id",$bookID)->get()->toArray()[0]['formatted_title'];
            $author = Null;
            $summary = Null;
            $addBook = 0;
        } else {
            $bookID = Null;
        }

        $data = [
            'list_id' => $request->input('list_id'),
            'user_id' => auth()->id(),
            'on_site' => $onSite,
            'book_id' => $bookID,
            'title' => $title,
            'author' => $author,
            'summary' => $summary,
            'want_book_added' => $addBook,
            'status' => $request->input('read') ? 'read' : 'not read',
            'rating' => $request->input('rateqm') ? $request->input('rate') : null,
            'active' => 1
        ];

        // Insert the data into the database using Eloquent
        $li->query()->insert($data);

        return redirect()->back()->with('success', 'Form submitted successfully!');
    }

    public function edit(Request $request)
    {
        $b = new book();
        $li = new list_items();

        $listItemId = $request->input('listItemId');
        $books = $b->query()->select()
            ->get()
            ->toArray();

        $item = $li->ActiveItemsByItemId($listItemId)[0];

        $data = [
            'listId' => $listItemId,
            'bookId' => $item['book_id'],
            'bookTitle' => $item['title'],
            'bookAuthor' => $item['author'],
            'bookSummary' => $item['summary'],
            'onSiteValue' => $item['on_site'] == '1' ? 'Yes' : 'No',
            'wantBookAdded' => $item['want_book_added'],
            'status' => $item['status'],
            'rating' => $item['rating'],
        ];

        return view('summer-reading-edit', ['item'=>$data, 'books'=>$books]);
    }
    public function submitItem(Request $request)
    {
        dump($li = new list_items());

        dump($listId = $request->input('listID'));
        dump($onSite = $request->input('onSite'));
        dump($rateqm = $request->input('rateqm'));
        dump($read = $request->input('read'));
        dump($rate = null);

        if($rateqm == 1){
            $rate = $request->input('rate');
        }
        if($onSite != 'Yes'){
            $addBook = $request->input('addBook');
            $author = $request->input('author');
            $summary = $request->input('summary');
            dd($li->UpdateItemById($listId, ['author'=>$author, 'summary'=>$summary, 'status'=>$read, 'rating'=>$rate, 'want_book_added'=>$addBook]));
        }else{
            dd($li->UpdateItemById($listId, ['status'=>$read, 'rating'=>$rate, 'on_site'=>$onSite]));
        }
        //have you read this book yet
        //Would you like to rate this book?
        //Rating
        $this->index();
    }
}
