<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function() {
	Route::get('/', 'Controller@index')->name('index');
	Route::resource('pages', 'AdminPageController', 			['except' => ['show']]);
	Route::resource('posts', 'AdminPostController', 			['except' => ['show']]);
	Route::resource('categories', 'AdminCategoryController', 	['as' => 'posts', 'except' => ['create', 'edit']]);
	Route::resource('tags', 'AdminTagController', 				['as' => 'posts', 'except' => ['create', 'edit']]);
	Route::resource('users', 'AdminUserController');
});
/*
Route::group(['prefix' => 'blog'], function() {
	Route::get('/', ['uses' => 'PostsController@index', 'as' => "blog.index"]);
	Route::get('/q/{search}', ['uses' => 'PostsController@search', 'as' => "blog.search"]);
	Route::get('/tag/{slug}', ['uses' => 'PostsController@tags', 'as' => "blog.tag"]);
	Route::get('/categorie/{slug}', ['uses' => 'PostsController@category', 'as' => "blog.category"]);
	Route::get('/feed', ['uses' => 'PostsController@feed', 'as' => "blog.feed"]);
	Route::get('/{slug}', ['uses' => 'PostsController@show', 'as' => "blog.show"]);
});

Route::resource('liens', 'LinksController', ['only' => ['index', 'create', 'store']]);
Route::get("liens/about", ['as' => 'link.about', 'uses' =>'LinksController@about']);
Route::get('r/{key}', ['as' => 'r.show', 'uses' => 'LinksController@show'])->where('key', '[A-Za-z0-9]+');

Route::controller('auth','Auth\AuthController', ['getLogout' => 'auth.logout']);
Route::controller('password', 'Auth\PasswordController');*/
Auth::routes();

Route::get('/', ['as' => 'index', 'uses' =>'PageController@index']);
Route::get('/{slug}', ['as' => 'pages', 'uses' =>'PageController@pages']);
