<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$blog = config('routes.blog');
$link = config('routes.link');
$url = config('routes.url');


Carbon::setLocale(config('app.locale'));


$admin = [];
$admin['_'] = config('routes.admin._');

$admin['blog'] = config('routes.admin.blog');
$admin['category'] = config('routes.admin.category');
$admin['tag'] = config('routes.admin.tag');

$admin['user'] = config('routes.admin.user');

//Route::get('/', ['as' => 'index', 'uses' =>'HomeController@index']);
Route::get('/', function() {
	return redirect(route(config('routes.blog') . '.index'));
});

Route::group(['prefix' => $admin['_'], 'namespace' => 'Admin'], function() use ($admin) {
	Route::get('/', 'Controller@index');
	Route::resource($admin['blog'], 'AdminPostsController', ['except' => ['show']]);
	Route::resource($admin['category'], 'AdminCategoryController', ['except' => ['create', 'edit']]);
	Route::resource($admin['tag'], 'AdminTagController', ['except' => ['create', 'edit']]);

	Route::resource($admin['user'], 'AdminUserController');
});


Route::group(['prefix' => $blog], function() use ($blog) {
	Route::get('/', ['uses' => 'PostsController@index', 'as' => "${blog}.index"]);
	Route::get('/q/{search}', ['uses' => 'PostsController@search', 'as' => "${blog}.search"]);
	Route::get('/'.config('routes.tag').'/{slug}', ['uses' => 'PostsController@tags', 'as' => "${blog}.tag"]);
	Route::get('/'.config('routes.category').'/{slug}', ['uses' => 'PostsController@category', 'as' => "${blog}.category"]);
	Route::get('/feed', ['uses' => 'PostsController@feed', 'as' => "${blog}.feed"]);
	Route::get('/{slug}', ['uses' => 'PostsController@show', 'as' => "${blog}.show"]);
});

Route::resource($link, 'LinksController', ['only' => ['index', 'create', 'store']]);

Route::get($link . "/about", ['as' => $link.'.about', 'uses' =>'LinksController@about']);


Route::get($url . '/{key}', ['as' => $url.'.show', 'uses' => 'LinksController@show'])->where('key', '[A-Za-z0-9]+');

Route::get('home', 'HomeController@auth');


Route::controller('auth','Auth\AuthController', ['getLogout' => 'auth.logout']);
Route::controller('password', 'Auth\PasswordController');
