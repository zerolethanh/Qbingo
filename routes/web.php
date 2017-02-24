<?php

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
Route::get('getphoto/{photoname?}', 'PhotoController@getphoto');
Route::get('thumb/{photoname}', 'PhotoController@getThumbPhoto');
//new Photo
Route::group(['prefix' => '/photo'], function () {
    Route::get('/{name}', 'PhotoController@getPhotoByName');
    Route::get('/thumb/{name}', 'PhotoController@getPhotoThumbByName');
});
//Auth::routes();

//Route::get('/home', 'HomeController@index');

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
    Route::post('update-hit-number', 'StartController@update_hit_number');
});

Route::group(['prefix' => 'master'], function () {

    Route::get('', 'MasterController@showLoginForm');
    Route::post('login', 'MasterController@login');
    Route::get('logout', 'MasterController@logout');

    Route::get('control', 'MasterController@control');
    Route::get('create', 'MasterController@create');

    Route::get('shops', 'MasterController@shops');
    Route::get('/shops/register', 'MasterController@showShopRegisterForm');
    Route::post('/shops/register', 'MasterController@shopRegister');
    Route::get('/shops/{shop_id}', 'MasterController@shopDetail');
    Route::post('/shops/{shop_id}', 'MasterController@updateShopDetail');
    Route::get('users', 'MasterController@users');

});

Route::group(['prefix' => 'ticket'], function () {
    Route::post('create', 'TicketController@create');
    Route::post('stop', 'TicketController@stop');
    Route::post('delete', 'TicketController@delete');
    Route::post('search', 'TicketController@search');
    Route::post('clear_tickets_cache', 'TicketController@clear_tickets_cache');
    Route::post('clear_shop_ticket_session', 'TicketController@clear_shop_ticket_session');

});

Route::group(['prefix' => 'shop'], function () {
    Route::post('stop', 'ShopController@stop');
    Route::post('delete', 'ShopController@delete');
    Route::post('search', 'ShopController@search');
    Route::post('stop_search', 'ShopController@stop_search');
    Route::post('show_activity_users', 'ShopController@show_activity_users');
});