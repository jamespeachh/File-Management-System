<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    use HasFactory;

    protected $connection = 'ycl';
    protected $table = 'categories';

    public function getActive()
    {
        return $this->query()
            ->select()
            ->where('active', 1)
            ->get()
            ->toArray();
    }
}
