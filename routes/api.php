<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\GenresController;
use App\Http\Controllers\RentsController;
use App\Models\Genre;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PharIo\Manifest\AuthorCollection;

Route::get('/test', function (Request $request) {
    return 'Authenticated now';
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes

Route::middleware(
    [
        'auth:sanctum',

        // another athentication can be added here 
        // like jetstream session athentication
    ]
)->group(function () {
    Route::prefix('v1')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });
});


Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('bookstore')->group(function () {

        //  define a list of resources 
        Route::apiResources(
            [
                // api route for authors 
                '/authors' => AuthorsController::class,

                // api route for books
                'books' => BooksController::class,

                // api route for rents
                '/rents'    => RentsController::class,

                // api route for genres
                '/genres'  => GenresController::class,
            ]
        );

            // Route::get('rents/book/{book}', [RentsController::class, 'rentBook']);

            // api route for authors 
            // Route::apiResource('/authors', AuthorsController::class);

            // api route for genres
            // Route::apiResource('/genres', GenresController::class);
            // ->only(['show', 'create', 'update']);

            // Route::apiResource('/rents', RentsController::class);

            // api route for books
            // Route::apiResource('/books', BooksController::class)
            // ->only(['update', 'create', 'destroy'])
            // ->middleware('can:create, App\\Models\Book')
            // ->middleware('can:update, App\\Models\Book')
            // ->middleware('can:viewAny, App\\Models\Book') 
            // ->middleware([
            //     'can:create, App\\Models\Book',
            //     'can:update, App\\Models\Book',
            //     'can:viewAny, App\\Models\Book',
            // ])
        ;
    });
});
