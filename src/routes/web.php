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
    return redirect('/discoveries');
});

// 発見情報の一覧
Route::get('/discoveries', 'DiscoveryController@index');

// 花の一覧
Route::get('/flowers', 'FlowerController@index');

// 科を指定した花の一覧
Route::get('/flowers/family/{family}', 'FlowerController@family');

// 花の登録
Route::post('/flower', 'FlowerController@regist');

// 花の編集
Route::post('/flower/edit/{flower}','FlowerController@edit');

// 花の更新
Route::post('/flower/update/{flower}','FlowerController@update');

// 花の削除
Route::delete('/flower/delete/{flower}', 'FlowerController@delete');


