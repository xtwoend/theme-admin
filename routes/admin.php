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

    Route::get('/dashboard', ['as'=> 'dashboard', 'uses' =>'DashboardController@index']);
    Route::get('print/page', ['as'=> 'print.page', 'uses' => 'PrintController@index']);
    
    // data ujian / test
    Route::post('setting/logo/crop', ['as' => 'setting.logo.crop', 'uses' => 'SettingController@logoCrop']);
    Route::post('setting/logo', ['as' => 'setting.logo', 'uses' => 'SettingController@logo']);
    Route::resource('setting', 'SettingController');

    // data master
    Route::get('peserta/daftar-hadir', ['as' => 'peserta.daftarhadir', 'uses' => 'PesertaController@daftarHadir']);
    Route::get('peserta/daftar-hadir/cetak', ['as' => 'peserta.daftarhadir.cetak', 'uses' => 'PesertaController@daftarHadirPrint']);
    Route::get('peserta/kartu', ['as' => 'peserta.kartu', 'uses' => 'PesertaController@kartu']);
    Route::get('peserta/kartu/cetak', ['as' => 'peserta.kartu.cetak', 'uses' => 'PesertaController@kartuPrint']);

    Route::post('peserta/foto/crop', ['as' => 'peserta.foto.crop', 'uses' => 'PesertaController@fotoCrop']);
    Route::post('peserta/foto', ['as' => 'peserta.foto', 'uses' => 'PesertaController@foto']);
    Route::post('peserta/data', ['as' => 'peserta.data', 'uses' => 'PesertaController@data']);
    Route::get('peserta/upload', ['as' => 'peserta.upload', 'uses' => 'PesertaController@upload']);
    Route::post('peserta/upload', ['as' => 'peserta.upload.post', 'uses' => 'PesertaController@uploadPost']);
    Route::post('peserta/generate', ['as' => 'peserta.generate', 'uses' => 'PesertaController@generate']);
    Route::resource('peserta', 'PesertaController');

    Route::get('status/{id}/unlock', ['as' => 'status.unlock', 'uses'=>'UnlockController@unlock']);
    Route::resource('status', 'UnlockController');

    Route::post('kelas/data', ['as' => 'kelas.data', 'uses' => 'KelasController@data']);
    Route::resource('kelas', 'KelasController');

    Route::post('jurusan/data', ['as' => 'jurusan.data', 'uses' => 'JurusanController@data']);
    Route::resource('jurusan', 'JurusanController');

    Route::post('mapel/data', ['as' => 'mapel.data', 'uses' => 'MapelController@data']);
    Route::resource('mapel', 'MapelController');

    Route::post('paket/sum', ['as' => 'paket.sum', 'uses' => 'PaketSoalController@sum']);
    Route::post('paket/get', ['as' => 'paket.get', 'uses' => 'PaketSoalController@getData']);
    Route::get('paket/{id}/addsoal', ['as' => 'paket.addsoal', 'uses' => 'PaketSoalController@addSoal']);
    Route::post('paket/{id}/addsoal', ['as' => 'paket.addsoal.submit', 'uses' => 'PaketSoalController@addSoalSubmit']);
    Route::post('paket/soal/{id}/data', ['as' => 'paket.datasoal', 'uses' => 'PaketSoalController@dataSoal']);
    Route::delete('paket/{soal_id}/soal/{id}/remove', ['as' => 'paket.remove.soal', 'uses' => 'PaketSoalController@removeSoal']);
    Route::post('paket/data', ['as' => 'paket.data', 'uses' => 'PaketSoalController@data']);
    Route::resource('paket', 'PaketSoalController');

    Route::post('soal/sum', ['as' => 'soal.sum', 'uses' => 'SoalController@sum']);
    Route::get('soal/upload', ['as' => 'soal.upload', 'uses' => 'SoalController@upload']);
    Route::post('soal/upload', ['as' => 'soal.upload.post', 'uses' => 'SoalController@uploadPost']);
    Route::post('soal/data', ['as' => 'soal.data', 'uses' => 'SoalController@data']);
    Route::get('soal/{id}/quickedit', ['as' => 'soal.quickedit', 'uses' => 'SoalController@quickEdit']);
    Route::resource('soal', 'SoalController');
    
    Route::post('ujian/{id}/refresh-token', ['as' => 'ujian.refreshtoken', 'uses' => 'UjianController@refreshToken']);
    Route::post('ujian/data', ['as' => 'ujian.data', 'uses' => 'UjianController@data']);
    Route::resource('ujian', 'UjianController');

    Route::post('ujian/koreksi', ['as' => 'ujian.koreksi', 'uses' => 'LaporanController@koreksi']);
    Route::post('laporan/data', ['as' => 'laporan.data', 'uses' => 'LaporanController@data']);
    Route::get('laporan/download', ['as' => 'laporan.download', 'uses' => 'LaporanController@download']);
    Route::resource('laporan', 'LaporanController');

    Route::resource('rekap', 'RekapController');

    Route::post('media/upload', ['as' => 'media.upload', 'uses' => 'MediaController@upload']);
});