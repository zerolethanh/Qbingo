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

Route::get('/cuong', function () {
    return null;
});

Route::group(['prefix' => 'upload'], function () {
    Route::get('/', 'UploadController@index');
    Route::post('/', 'UploadController@upload');
});
Auth::routes();

Route::get('/home', 'HomeController@index');
