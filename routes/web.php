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

Route::get('invite', 'InviteController@index')->name('invite.list');
Route::get('invite/new', 'InviteController@create')->name('invite.create');
Route::post('invite', 'InviteController@store')->name('invite.store');
Route::get('invite/{id}/delete', 'InviteController@destroy')->name('invite.delete');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('weightlog/{id?}', 'WeightLogController@index')->name('weightlog.index');
Route::post('weightlog/{id?}', 'WeightLogController@store')->name('weightlog.addlog');
Route::get('weightlog/{id}/delete', 'WeightLogController@destroy')->name('weightlog.deleteLog');