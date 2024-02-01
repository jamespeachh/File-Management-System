<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBookMapping extends Model
{
    use HasFactory;

    protected $connection = 'ycl';
    protected $table = 'user_book_mapping';
    public $timestamps = false;

    protected $fillable = [
        'book_id',
        'user_id',
        'page_number'
    ];

    public function allMappingsForUser($user_id) : array
    {
        return $this->query()
            ->select()
            ->where(['user_id'=>$user_id])
            ->get()
            ->toArray();
    }
}
