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
        return $test;
        $this->query()->insert([
            'password' => $password,
            'username' => $username,
            'website' => $site,
        ]);
    }

}
