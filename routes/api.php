<?php
use App\Http\Models\Book;
use App\Http\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BookController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);

// routes proteced by the auth middleware

Route::middleware('auth:api')->group(function () {
    
    //basic form i did not delete
    Route::get('/home',function(){
        Return view('welcome');
    }    
    );

    //API endpoints

    Route::get('/books', 'BookController@index');
    Route::post('/books', 'BookController@store');
    Route::get('/books/{id}', 'BookController@show');
    Route::put('/books/{id}', 'BookController@update');
    Route::delete('/books/{id}', 'BookController@destroy');
    
    Route::post('logout',[PassportAuthController::class, 'logout']);
});


