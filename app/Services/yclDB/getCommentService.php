<?php

namespace App\Services\yclDB;

use App\Models\comments;
use Illuminate\Support\Facades\Cache;

class getCommentService
{
    public function getComments() : array
    {
        $commentQuery = new comments();
        $comments = $commentQuery->getAllByBookAndPage(1, 18);
        Cache::put('cur_comments', $comments);
        return $comments;
    }
}
