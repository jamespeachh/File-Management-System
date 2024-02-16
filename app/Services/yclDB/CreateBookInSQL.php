<?php

namespace App\Services\yclDB;

use App\Models\book;

class CreateBookInSQL
{
    public function addBook($book)
    {
        book::query()->insert([
            'id' => $book['id'],
            'title' => $book['title'],
            'formatted_title' => $book['formatted_title'],
            'pages' => $book['pages'],
            'cover_pic' => $book['cover_pic']
        ]);
    }

}
