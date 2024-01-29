<?php

namespace App\Http\Controllers;

use App\Models\yclDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
         $test = yclDatabase::query()->get()->toArray();
         dump($test);
        $user = Auth::user();

// Retrieve the currently authenticated user's ID...
        $id = Auth::id();
        dd($user, $id);
    }
}
