<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class list_items extends Model
{
    use HasFactory;
    protected $connection = 'ycl';
    protected $table = 'list_items';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'list_id',
        'user_id',
        'on_site',
        'book_id',
        'title',
        'author',
        'summary',
        'want_book_added',
        'status',
        'rating',
        'active'
    ];

}
