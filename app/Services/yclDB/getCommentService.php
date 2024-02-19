<?php

namespace App\Services\yclDB;

use App\Models\comments;
use App\Models\UserBookMapping;
use Illuminate\Support\Facades\Cache;

class getCommentService
{
    public function getComments()
    {
        $ubm = new UserBookMapping;
        $commentQuery = new comments();

        $mappings = $ubm->allMappings();
        foreach($mappings as $mapping)
        {
            $comments = $commentQuery->getAllByBookAndPage($mapping['book_id'], $mapping['page_number']);
            Cache::put('cur_comments', $comments);
        }
    }
}
