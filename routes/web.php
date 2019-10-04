<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/threads', 'ThreadsController@store');
Route::get('/threads', 'ThreadsController@index');
Route::get('/threads/create', 'ThreadsController@create');
Route::get('/threads/{thread}', 'ThreadsController@show');


Route::post('/threads/{thread}/comment', 'ThreadCommentsController@store');

Route::post('/comment/{comment}/vote', 'VotesController@store');
Route::post('/threads/{thread}/vote', 'VotesController@store');
