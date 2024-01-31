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
        'url',
        'formatted_title',
        'pages',
        'cover_pic'
    ];
}
