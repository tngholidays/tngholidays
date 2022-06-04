<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/1/2019
 * Time: 10:02 AM
 */
use Illuminate\Support\Facades\Route;

Route::get('/','ForexController@index')->name('forex.admin.index');

Route::match(['get'],'/create','ForexController@create')->name('forex.admin.create');
Route::match(['get'],'/edit/{id}','ForexController@edit')->name('forex.admin.edit');
Route::match(['get'],'/delete/{id}','ForexController@delete')->name('forex.admin.delete');

Route::post('/store/{id}','ForexController@store')->name('forex.admin.store');


Route::get('/forex-order','ForexController@forexOrders')->name('forex.admin.orders');
Route::get('/view-order/{id}','ForexController@viewOrder')->name('forex.admin.viewOrder');
