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

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/cuong', function () {
//    return null;
//});


Route::get('/', 'HappyController@index');
Route::post('/', 'HappyController@login');
Route::get('logout', 'HappyController@logout');

Route::group(['prefix' => 'bingo'], function () {
    Route::get('/', 'BingoController@index');
    Route::get('/upload-list', 'BingoController@uploadList');
    Route::get('/quizzes', 'BingoController@quizzes');
    Route::get('/start', 'BingoController@start');
});

//Route::resource('/', 'HappyController');

Route::group(['prefix' => 'upload'], function () {
//    Route::get('/', 'UploadController@index');
    Route::post('/', 'UploadController@upload');
});
Route::get('getphoto/upload/{photoname}', 'PhotoController@getphoto');
Auth::routes();

Route::get('/home', 'HomeController@index');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'AdminController@index');
    Route::post('make-random', 'AdminController@makeRandom');
    Route::post('/', 'AdminController@makeHappier');

});

Route::group(['prefix' => 'invite'], function () {
    Route::get('/', 'InviteController@invite');
    Route::get('/send_url', 'InviteController@send_url');
});

Route::get('getqr/{filename}', 'QRController@getQRImg');
//Route::resource('/admin', 'AdminController');

//Auth::routes();

//Route::get('/home', 'HomeController@index');

Route::group(['prefix' => 'quiz'], function () {
    Route::post('/', 'QuizController@save');
});


Route::group(['prefix' => 'start'], function () {
    Route::post('face', 'StartController@face');
    Route::post('quiz', 'StartController@quiz');
    Route::post('restart_game', 'StartController@restart_game');
    Route::post('hit', 'StartController@hit');
    Route::post('undo', 'StartController@undo');
    Route::post('face_shuffle', 'StartController@face_shuffle');
    Route::post('hit_details', 'StartController@hit_details');
});