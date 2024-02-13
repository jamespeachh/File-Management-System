<?php

use App\Http\Controllers\Books\BookController;
use App\Http\Controllers\Books\DirectoryController;
use App\Http\Controllers\Books\ImportController;
//use App\Http\Controllers\ProfileController;
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
Route::get('/', [DirectoryController::class, 'index'])
    ->name('directory')
    ->middleware('auth');
Route::get('/directory', [DirectoryController::class, 'index'])
    ->name('directory')
    ->middleware('auth');

// Route::get('/import', [ImportController::class, 'index'])->name('import');

/*
|--------------------------------------------------------------------------
| Books
|--------------------------------------------------------------------------
*/
//testing out a new book path
Route::get('/book/{bookName}/{pageNumber}', [BookController::class, 'index'])
    ->middleware('auth');

Route::get('/book/{bookName}', [BookController::class, 'indexNoVar'])
    ->name('book')
    ->middleware('auth');
Route::post('/submit-comment', [BookController::class, 'submitComment'])
    ->name('submit-comment')
    ->middleware('auth');
Route::get('/deleteComment', [BookController::class, 'deleteComment'])
    ->name('deleteComment')
    ->middleware('auth');

Route::get('/book', [BookController::class, 'bookBuilder'])
    ->name('run')
    ->middleware('auth');



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
Route::get('/import', [ImportController::class, 'showUploadForm'])->name('import.form');
Route::post('/submit-form/{bookID}/{pageNumber}', [ImportController::class, 'submitForm'])
    ->name('submit-form');

/*
|--------------------------------------------------------------------------
| TESTING
|--------------------------------------------------------------------------
*/
Route::get('/test', [TestController::class, 'index'])
    ->name('test');
//    ->middleware('auth');



Route::get('/home',function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})  ->middleware(['auth'])
    ->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/admin', [\App\Http\Controllers\adminController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');
Route::get('/admin-submit', [\App\Http\Controllers\adminController::class, 'submit'])
    ->middleware(['auth'])
    ->name('admin-submit');
