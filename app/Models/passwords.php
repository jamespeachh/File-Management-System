<?php

namespace App\Models;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class passwords extends Model
{
    use HasFactory;

    protected $connection = 'ycl';
    protected $table = 'passwords';
    public $timestamps = false;

    public function getPasswordByID($id): ?array
    {
        $encrypted = $this->query()
            ->select()
            ->where('id',$id)
            ->get()
            ->toArray()[0];

        $decryptedArr = [
            'password'=>Crypt::decryptString($encrypted['password']),
            'username'=>Crypt::decryptString($encrypted['username']),
            'website'=>Crypt::decryptString($encrypted['website']),
        ];

        return $decryptedArr;
    }

    public function addPassword($password, $username, $site)
    {
        $password = Crypt::encryptString($password);
        $username = Crypt::encryptString($username);
        $site = Crypt::encryptString($site);


        $this->query()->insert([
            'password' => $password,
            'username' => $username,
            'website' => $site,
        ]);
        return $this->query()
            ->select('id')
            ->where('password', $password)
            ->where('username', $username)
            ->where('website', $site)
            ->get()
            ->toArray();
    }

}
