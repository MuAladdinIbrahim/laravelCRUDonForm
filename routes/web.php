<?php

use Illuminate\Support\Facades\Route;
use App\Post;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware'=>'auth'],function(){

    Route::get('/posts','PostController@index')->name('posts.index');
    Route::get('/posts/create', 'PostController@create')->name('posts.create');
    Route::get('/posts/{post}/edit', 'PostController@edit')->name('post.edit');
    Route::get('/posts/{post}', 'PostController@show')->name('posts.show');
    Route::post('/posts', 'PostController@store')->name('posts.store');
    Route::put('/posts/{post}', 'PostController@update')->name('posts.update');
    Route::delete('/posts/{post}', 'PostController@destroy')->name('posts.destroy');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
