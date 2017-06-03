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

Auth::routes();

Route::get('/unbk', function(){
    return redirect()->to('/');
});
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::post('ujian/informasi', ['as' => 'ujian.informasi', 'uses' => 'UjianController@informasi']);
Route::post('ujian/mulai', ['as' => 'ujian.mulai', 'uses' => 'UjianController@mulai']);
Route::post('ujian/update/jawaban', ['as' => 'update.jawaban', 'uses' => 'UjianController@jawab']);
Route::post('ujian/update/status', ['as' => 'update.setstatus', 'uses' => 'UjianController@setStatus']);
Route::get('ujian/{id}/finish', ['as' => 'ujian.finish', 'uses' => 'UjianController@finish']);
Route::get('ujian/{id}/no/1', ['as' => 'ujian', 'uses' => 'UjianController@index']);
Route::get('ujian/{id}/no/{no}', ['as' => 'ujian.show', 'uses' => 'UjianController@show']);

