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
        $books = $b->query()->select()
            ->get()
            ->toArray();

        return view('test', ['books'=>$books]);
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
            $author = "";
            $summary="";
            $addBook=0;
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
}
