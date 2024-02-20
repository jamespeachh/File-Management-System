<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class getPassword extends Controller
{
    public function index($password, $userID)
    {
        if(Auth::id() == $userID)
        {
            echo "username";
            dump('username');
            echo "password";
            dump($password);
        }
    }
}
