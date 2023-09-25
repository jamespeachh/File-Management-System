<?php

use App\Http\Controllers\Books\BookController;
use App\Http\Controllers\Books\DirectoryController;
use App\Http\Controllers\books\ImportController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DirectoryController::class, 'index'])->name('directory');//->middleware('auth');
Route::get('/home', [DirectoryController::class, 'index'])->name('home');//->middleware('auth');

// book directory
Route::get('/directory', [DirectoryController::class, 'index'])
    ->name('directory');//->middleware('auth');

// Route::get('/import', [ImportController::class, 'index'])->name('import');

Route::get('/upload', [ImportController::class, 'showUploadForm'])->name('upload.form');
Route::post('/upload', [ImportController::class, 'processUpload'])->name('upload.process');

//testing out a new book path
Route::get('/book/{bookName}/{pageNumber}', [BookController::class, 'index'])
    ->name('book');//->middleware('auth');
Route::get('/book/{bookName}', [BookController::class, 'indexNoVar']);//->middleware('auth');
Route::get('/calander', function(){
    return view('calanders');
});//->middleware('auth');

Route::get('/test', [TestController::class, 'index'])
    ->name('test');
    //runtest


