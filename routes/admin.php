<?php

/**
 * route for admin system
 */

Route::group(['prefix'=> 'admin'], function(){
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout')->middleware('auth:admin');
});

Route::group([
    'middleware'    => 'auth:admin',
    'prefix'        => 'admin',
    'as'            => 'admin.'
], function(){

    Route::get('/', function(){
        return 'admin page';
    });

    Route::get('/dashboard', 'DashboardController@index');
    Route::get('print/page', ['as'=> 'print.page', 'uses' => 'PrintController@index']);
    Route::post('peserta/data', ['as' => 'peserta.data', 'uses' => 'PesertaController@data']);
    Route::resource('peserta', 'PesertaController');
});