<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

  Route::middleware('auth:api')->get('/user', function (Request $request) {
      return $request->user();
  });

  Route::post('register', 'AdminController@register');
  Route::post('login', 'AdminController@login');
  Route::get('/', function(){
    return Auth::user()->level;
  })->middleware('jwt.verify');

  Route::get('user', 'AdminController@getAuthenticatedUser')->middleware('jwt.verify');

  //kategori
  Route::post('/simpan_kategori','KategoriController@store')->middleware('jwt.verify');
  Route::put('/ubah_kategori/{id}','KategoriController@update')->middleware('jwt.verify');
  Route::get('/tampil_kategori','KategoriController@tampil_kategori')->middleware('jwt.verify');
  Route::delete('/hapus_kategori/{id}','KategoriController@destroy')->middleware('jwt.verify');


  //design
  Route::post('/simpan_design','DesignController@store')->middleware('jwt.verify');
  Route::put('/ubah_design/{id}','DesignController@update')->middleware('jwt.verify');
  Route::get('/tampil_design','DesignController@tampil_design')->middleware('jwt.verify');
  Route::delete('/hapus_design/{id}','DesignController@destroy')->middleware('jwt.verify');


  //barang
  Route::post('/simpan_barang','BarangController@store')->middleware('jwt.verify');
  Route::put('/ubah_barang/{id}','BarangController@update')->middleware('jwt.verify');
  Route::get('/tampil_barang','BarangController@tampil_barang')->middleware('jwt.verify');
  Route::delete('/hapus_barang/{id}','BarangController@destroy')->middleware('jwt.verify');

  //report data Transaksi
  // Route::get('/report/{tgl_trans}/{deadline}','TransaksiController@report')->middleware('jwt.verify');
