<?php

use App\Http\Controllers\Books\BookController;
use App\Http\Controllers\Books\DirectoryController;
use App\Http\Controllers\Books\ImportController;
//use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;

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
Route::get('/book', [BookController::class, 'index'])
    ->name('book')
    ->middleware('auth');


/*
|--------------------------------------------------------------------------
| Comments
|--------------------------------------------------------------------------
*/
Route::post('/submit-comment', [CommentController::class, 'submitComment'])
    ->name('submit-comment')
    ->middleware('auth');
Route::get('/deleteComment', [CommentController::class, 'deleteComment'])
    ->name('deleteComment')
    ->middleware('auth');


/*
|--------------------------------------------------------------------------
| IMPORT
|--------------------------------------------------------------------------
|
| Allows a user to add a book to the list
|
*/
Route::get('/import', [ImportController::class, 'showUploadForm'])->name('import.form');
Route::post('/submit-form', [ImportController::class, 'submitForm'])
    ->name('submit-form');

/*
|--------------------------------------------------------------------------
| TESTING
|--------------------------------------------------------------------------
*/
Route::get('/test', [TestController::class, 'index'])
    ->name('test');
//    ->middleware('auth');
Route::post('/test-submit', [TestController::class, 'submit'])
    ->name('test-submit');


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
    ->name('admin');
Route::post('/admin-submit', [\App\Http\Controllers\adminController::class, 'submit'])
    ->middleware(['auth'])
    ->name('admin-submit');

Route::get('/tempPassword/', function (Request $request) {
    if (! $request->hasValidSignature()) {
        abort(401);
    }
    $admin = new \App\Http\Controllers\adminController();

    $admin->sendPassword($request->query('passwordID'), $request->query('userID'));
})->name('sendPassword');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
