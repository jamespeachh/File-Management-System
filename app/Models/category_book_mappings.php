<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category_book_mappings extends Model
{
    use HasFactory;

    protected $connection = 'ycl';
    protected $table = 'category_book_mappings';

    public function getByCatID($catID)
    {
        return $this->query()
            ->select()
            ->where('category_id', $catID)
            ->get()
            ->toArray();
    }
    public function getAll()
    {
        return $this->query()
            ->select()
            ->get()
            ->toArray();
    }
}
