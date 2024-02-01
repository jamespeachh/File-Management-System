<?php

namespace App\Services\yclDB;

use App\Models\book;

class GetBookInformation
{
    public function FullBookFromID($book_id) : array
    {
        return $this->queryBuilder('id', $book_id);
    }
    public function FullBookFromTitle($title) : array
    {
        return $this->queryBuilder('title', $title);
    }
    public function getBookFormattedTitle($unformattedTitle) : string
    {
        return book::query()
            ->select('formatted_title')
            ->where(['title'=>$unformattedTitle])
            ->get()
            ->toArray()[0]['formatted_title'];
    }
    private function queryBuilder($key,$value) : array
    {
        return book::query()
            ->select()
            ->where([$key=>$value])
            ->get()
            ->toArray();
    }
}
