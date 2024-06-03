<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\Books\BookController;
use App\Http\Controllers\Books\DirectoryController;
use App\Http\Controllers\Books\ImportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReadingList;
use App\Http\Controllers\TestController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
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
Route::prefix('directory')->middleware('auth')->group(function () {
    Route::controller(DirectoryController::class)
        ->group(function () {
            Route::get('/', 'index')
                ->name('directory');
        });
});

// Route::get('/import', [ImportController::class, 'index'])->name('import');

/*
|--------------------------------------------------------------------------
| Books
|--------------------------------------------------------------------------
*/
Route::prefix('book')->middleware('auth')->group(function () {
    Route::controller(BookController::class)
        ->group(function () {
            Route::get('/', 'index')
                ->name('book');
        });
});



/*
|--------------------------------------------------------------------------
| Comments
|--------------------------------------------------------------------------
*/
Route::prefix('comment')->name('comment.')->middleware('auth')->group(function () {
    Route::controller(CommentController::class)
        ->group(function () {
            Route::post('/submit', 'submitComment')
                ->name('submit');
            Route::get('/delete', 'deleteComment')
                ->name('delete');
        });
});

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::controller(adminController::class)
        ->group(function () {
            Route::get('/', 'index')
                ->name('admin');
            Route::post('/submit', 'submit')
                ->name('submit');
            Route::post('/submitNewPassword', 'addPassword')
                ->name('submitNewPassword');
        });
});



/*
|--------------------------------------------------------------------------
| IMPORT
|--------------------------------------------------------------------------
|
| Allows a user to add a book to the list
| Trying to get rid of this soon.
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
Route::prefix('test')->name('test.')->group(function () {
    Route::controller(TestController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/submit', 'submit')->name('test-submit');
        });
});

//    Route::get('/', [TestController::class, 'index'])
//        ->name('test');
//    //    ->middleware('auth');
//    Route::post('/test-submit', [TestController::class, 'submit'])
//        ->name('test-submit');

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


Route::get('/tempPassword/', function (Request $request) {
    if (! $request->hasValidSignature()) {
        abort(401);
    }
    $admin = new adminController();

    $admin->sendPassword($request->query('passwordID'), $request->query('userID'));
})->name('sendPassword');


Route::middleware('auth')->name('profile.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile', [ProfileController::class, 'updatePFP'])->name('profile.updatepfp');
});


/*
|--------------------------------------------------------------------------
| Reading list !!!
|--------------------------------------------------------------------------
*/
Route::prefix('reading')->name('reading.')->middleware('auth')->group(function () {
    Route::controller(ReadingList::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/edit', 'edit')->name('edit-item');
            Route::get('/delete', 'delete')->name('delete-item');
            Route::post('/submit-item', 'submitItem')->name('submit-edit-item');
            Route::post('/submit', 'submit')->name('reading-list-submit');
        });
});
