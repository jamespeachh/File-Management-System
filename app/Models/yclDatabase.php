<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class yclDatabase extends Model
{
    use HasFactory;
    protected $connection = 'ycl';
    protected $table = 'book';
}
