<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class book extends Model
{
    use HasFactory;
    protected $connection = 'ycl';
    protected $table = 'book';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'title',
        'formatted_title',
        'pages',
        'cover_pic'
    ];

    public function addBook($book)
    {
        $this::query()->insert([
            'id' => $book['id'],
            'title' => $book['title'],
            'formatted_title' => $book['formatted_title'],
            'pages' => $book['pages'],
            'cover_pic' => $book['cover_pic']
        ]);
    }
}
