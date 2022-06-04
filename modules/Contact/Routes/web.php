<?php
use Illuminate\Support\Facades\Route;
//Contact
Route::get('/contact','ContactController@index')->name("contact.index");
Route::post('/contact/store','ContactController@store')->name("contact.store");

Route::get('/enquiry','ContactController@enquiryIndex')->name("enquiry.index");
Route::post('/enquiry/store','ContactController@enquiryStore')->name("enquiry.store");
Route::get('/embed_enquiry','ContactController@embedEnquiry')->name("enquiry.embedEnquiry");

Route::get('/forex','ContactController@forexIndex')->name("forex.forexIndex");
Route::post('/forexStore','ContactController@forexStore')->name("forex.forexStore");
Route::post('/getForexRate','ContactController@getForexRate')->name("forex.getForexRate");
