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

    public function getPasswordByID($id): ?string
    {
        $encrypted = $this->query()
            ->select()
            ->where('id',$id)
            ->get()
            ->toArray()[0];

        $decryptedArr = [
            'password'=>Crypt::decryptString($encrypted['password']),
            'username'=>$encrypted['username'],
            'website'=>$encrypted['website'],
        ];
        dd($decryptedArr);

        try {
            return Crypt::decryptString($encrypted);
        } catch (DecryptException $e) {
            dump($e);
            Log::info($e);
        }
        return null;
    }

    public function addPassword($username, $password, $site)
    {
        $test = Crypt::encryptString($password);

        return $this->query()->insert([
            'password' => $test,
            'username' => $username,
            'website' => $site,
        ]);
    }

}
