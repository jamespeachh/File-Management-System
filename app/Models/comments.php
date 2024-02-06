<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    use HasFactory;

    protected $connection = 'ycl';
    protected $table = 'comments';
    public $timestamps = false;

    public function getAllByBookAndPage($bookID,$pageNumber)
    {
        return $this->query()
            ->select('comments.comment_body', 'users.name', 'comments.book_id', 'comments.id', 'comments.active_comment', 'users.id as user_id')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->where(['book_id'=>$bookID])
            ->where(['page_number'=>$pageNumber])
            ->get()
            ->toArray();
    }

    public function insertComment($body, $bookID, $pageNumber, $userID)
    {
        return $this->query()->insert([
            'book_id' => intval($bookID),
            'page_number' => intval($pageNumber),
            'user_id' => intval($userID),
            'comment_body' => $body,
            'active_comment' => 1
        ]);
    }

    public function deleteCommentByID($id)
    {
        return $this->query()
            ->where('active_comment', 1)
            ->where('id', $id)
            ->update(['active_comment'=>0]);
    }
}
