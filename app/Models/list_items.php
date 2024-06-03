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

    public function ActiveItemsByUser($userId) : array
    {
        return $this->query()->select()->where('active', 1)->where('user_id',$userId)->get()->toArray();
    }
    public function ActiveItemsByItemId($id) : array
    {
        return $this->query()->select()->where('active', 1)->where('id',$id)->get()->toArray();
    }

    public function UpdateItemById($id,$data) : bool
    {
        dump($this->query()->select());
        dump($data);
        dump($this->ActiveItemsByItemId($id));
        dump($id);
        return $this->query()->where('id', $id)->update($data);
    }
}
