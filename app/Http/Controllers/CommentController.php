<?php

namespace App\Http\Controllers;

use App\Models\comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function submitComment(Request $request)
    {
        $c = new comments();
        $body = $request->input('body');
        $bookID = $request->input('bookID');
        $pageNumber = intval($request->input('pageNumber'));
        $id = Auth::id();
        if($bookID != 'none') $c->insertComment($body, $bookID, $pageNumber, $id);

        return redirect()->route('book', ['bookID' => $bookID, 'pageNumber' => $pageNumber]);
    }


    public function deleteComment(Request $request)
    {
        $c = new comments();

        $comment = $request->query('comment');
        $bookID = $request->query('bookID');
        $pageNumber = $request->query('pageNumber');

        $c->deleteCommentByID($comment);

        return redirect()->route('book', ['bookID' => $bookID, 'pageNumber' => $pageNumber]);
    }
}
