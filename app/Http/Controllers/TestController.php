<?php

namespace App\Http\Controllers;

use App\Models\yclDatabase;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
        dd( yclDatabase::query()->select('title'));
    }
}
