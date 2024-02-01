<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class BookBody extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $connection = 'ycl';
    protected $table = 'book_body';

    public function getBody($book_id, $page_number)
    {
        return $this->query()
            ->select()
            ->where(['book_id'=>$book_id])
            ->where(['page_number'=>$page_number])
            ->get()
            ->toArray()[0]['body_text'];
    }

}
