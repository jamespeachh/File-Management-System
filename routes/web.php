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
| FOR NOW, i am putting all the literal routes into groups, not the ones
| that "should" be in different places but are not right now.
|
| If something routes to directory right now, then it will be under:
| "Directory routes"
*/

/*
|--------------------------------------------------------------------------
| Directory
|--------------------------------------------------------------------------
*/
Route::get('/', [DirectoryController::class, 'index'])->name('directory');//->middleware('auth');
Route::get('/home', [DirectoryController::class, 'index'])->name('home');//->middleware('auth');
Route::get('/directory', [DirectoryController::class, 'index'])->name('directory');//->middleware('auth');

// Route::get('/import', [ImportController::class, 'index'])->name('import');

/*
|--------------------------------------------------------------------------
| Books
|--------------------------------------------------------------------------
*/
//testing out a new book path
Route::get('/book/{bookName}/{pageNumber}', [BookController::class, 'index'])
    ->name('book');//->middleware('auth');
Route::get('/book/{bookName}', [BookController::class, 'indexNoVar']);//->middleware('auth');

/*
|--------------------------------------------------------------------------
| Calendar
|--------------------------------------------------------------------------
*/
//Route::get('/calander', function(){
//    return view('calanders');
//});//->middleware('auth');

/*
|--------------------------------------------------------------------------
| IMPORT
|--------------------------------------------------------------------------
*/
Route::get('/import', [ImportController::class, 'showUploadForm'])->name('upload.form');
Route::post('/submit-form', [ImportController::class, 'submitForm'])->name('submit-form');

/*
|--------------------------------------------------------------------------
| TESTING
|--------------------------------------------------------------------------
*/
Route::get('/test', [TestController::class, 'index'])
    ->name('test');


