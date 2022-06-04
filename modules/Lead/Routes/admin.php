<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/1/2019
 * Time: 10:02 AM
 */
use Illuminate\Support\Facades\Route;

Route::get('/','LeadController@index')->name('Lead.admin.index');

Route::match(['get'],'/create','LeadController@create')->name('Lead.admin.create');
Route::match(['get'],'/edit/{id}','LeadController@edit')->name('Lead.admin.edit');
Route::match(['get'],'/delete/{id}','LeadController@delete')->name('Lead.admin.delete');

Route::post('/store/{id}','LeadController@store')->name('Lead.admin.store');
Route::post('/changeLeadStatus','LeadController@changeLeadStatus')->name('Lead.admin.changeLeadStatus');
Route::post('/viewleadInfo','LeadController@viewleadInfo')->name('Lead.admin.viewleadInfo');
Route::post('/leadMailSend','LeadController@leadMailSend')->name('Lead.admin.leadMailSend');
Route::post('/leadComment','LeadController@leadComment')->name('Lead.admin.leadComment');
Route::post('/leadSetReminder','LeadController@leadSetReminder')->name('Lead.admin.leadSetReminder');
Route::post('/switchTab','LeadController@switchTab')->name('Lead.admin.switchTab');
Route::post('/updateLead','LeadController@updateLead')->name('Lead.admin.updateLead');
Route::get('/export', 'LeadController@export')->name('Lead.admin.export');

Route::get('/sync/{mobileno}', 'LeadController@sync')->name('Lead.admin.sync');
Route::get('/campagin', 'LeadController@campagin')->name('Lead.admin.campagin');

Route::get('/lead-interactions', 'LeadController@leadInteractions')->name('Lead.admin.leadInteractions');
Route::get('/lead-call-logs', 'LeadController@leadCallLogs')->name('Lead.admin.leadCallLogs');

