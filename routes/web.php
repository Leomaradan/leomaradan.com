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
    Route::resource('pages', 'AdminPageController', ['except' => ['show']]);
    Route::resource('posts', 'AdminPostController', ['except' => ['show']]);
    Route::resource('categories', 'AdminCategoryController', ['as' => 'posts', 'except' => ['create', 'edit']]);
    Route::resource('tags', 'AdminTagController', ['as' => 'posts', 'except' => ['create', 'edit']]);
    Route::resource('users', 'AdminUserController');
    Route::resource('menus', 'AdminMenuController', ['except' => ['store','create']]);
    Route::get('galleries/flickr', ['uses' => 'AdminGalleryController@getFlickAlbums', 'as' => 'flickr.index']);
    Route::put('galleries/flickr/{album}', ['uses' => 'AdminGalleryController@importFlickrAlbum', 'as' => 'flickr.import']);    
    Route::resource('galleries', 'AdminGalleryController', []);

    Route::resource('links', 'AdminLinkController', ['except' => ['create','show','edit']]);
    Route::get('links/tweet', ['uses' => 'AdminLinkController@importTweet', 'as' => 'twitter.import']);
});

Route::group(['prefix' => 'blog'], function() {
    Route::get('/', ['uses' => 'PostController@index', 'as' => "blog.index"]);
    //Route::get('/q/{search}', ['uses' => 'PostController@search', 'as' => "blog.search"]);
    Route::get('/tag/{slug}', ['uses' => 'PostController@tags', 'as' => "blog.tag"]);
    Route::get('/categorie/{slug}', ['uses' => 'PostController@category', 'as' => "blog.category"]);
    Route::get('/feed', ['uses' => 'PostController@feed', 'as' => "blog.feed"]);
    Route::get('/{slug}', ['uses' => 'PostController@show', 'as' => "blog.show"]);
});
/*
  Route::resource('liens', 'LinksController', ['only' => ['index', 'create', 'store']]);
  Route::get("liens/about", ['as' => 'link.about', 'uses' =>'LinksController@about']);
  Route::get('r/{key}', ['as' => 'r.show', 'uses' => 'LinksController@show'])->where('key', '[A-Za-z0-9]+');

  Route::controller('auth','Auth\AuthController', ['getLogout' => 'auth.logout']);
  Route::controller('password', 'Auth\PasswordController'); */
Auth::routes();

Route::get('/', ['as' => 'index', 'uses' => 'PageController@index']);
Route::get('/{slug}', ['as' => 'pages', 'uses' => 'PageController@pages']);
