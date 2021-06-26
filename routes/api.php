<?php

use Illuminate\Http\Request;

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

//ruta za login
Route::group([
    'namespace' => 'Auth',
    'prefix' => 'auth'
], function() {
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');
});

Route::resource('galleries', GalleriesController::class)
    ->except([ 'edit', 'create' ]);

//dovlacimo sve galerije od autora
Route::get('authors/{id}', 'AuthorController@show');

//ruta za postavljanje komentara
Route::post('galleries/{id}/comments', 'CommentsController@store');
//brisanje komentara
Route::delete('/comments/{id}', 'CommentsController@destroy');



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
