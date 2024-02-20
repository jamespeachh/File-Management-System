<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class passwords extends Model
{
    use HasFactory;

    protected $connection = 'ycl';
    protected $table = 'passwords';
    public $timestamps = false;

    public function getPasswordByID($id)
    {
        return $this->query()
            ->select()
            ->where('id',$id)
            ->get()
            ->toArray()[0];
    }
}
