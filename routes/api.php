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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get("/admin", ['uses' =>'API\Admin\AdminController@index'])->middleware('api');
Route::get("/admin/pages", ['uses' =>'API\Admin\AdminController@pages'])->middleware('api');

Route::get("gallery/{id}", ['uses' =>'GalleryController@showAPI', 'as' => 'api.gallery.show']);