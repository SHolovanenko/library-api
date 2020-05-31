<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->resource('/books', 'BookController', 
    ['only' => ['index', 'store', 'show', 'update', 'destroy']]
);

Route::middleware('api')->resource('/authors', 'AuthorController', 
    ['only' => ['index', 'store', 'show', 'destroy']]
);

Route::middleware('api')->resource('/categories', 'CategoryController', 
    ['only' => ['index', 'store', 'show', 'destroy']]
);