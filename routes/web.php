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

Route::get('/intro','LandingpageController@index');
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/install/check-db', 'HomeController@checkConnectDatabase');

Route::get('/update', function (){
    return redirect('/');
});

//Cache
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cleared!";
});

//Login
Auth::routes();
Route::any('getHotels', '\Modules\Tour\Admin\TourController@getHotels');
Route::any('getRooms', '\Modules\Tour\Admin\TourController@getRooms');
Route::any('getFlights', '\Modules\Tour\Admin\TourController@getFlights');

Route::any('getToursByLocation', '\Modules\Tour\Admin\TourController@getToursByLocation');
Route::any('getTermsByAttr', '\Modules\Tour\Admin\TourController@getTermsByAttr');

Route::any('getChangeHotels', '\Modules\Tour\Controllers\TourController@getChangeHotels');
Route::any('getChangeRooms', '\Modules\Tour\Controllers\TourController@getChangeRooms');

Route::any('getTourActivities', '\Modules\Tour\Controllers\TourController@getTourActivities');
Route::any('getTourMeals', '\Modules\Tour\Controllers\TourController@getTourMeals');

Route::any('applyCouponCode', '\Modules\Tour\Controllers\TourController@applyCouponCode');
//Custom User Login and Register
Route::post('register','\Modules\User\Controllers\UserController@userRegister')->name('auth.register');
Route::post('login','\Modules\User\Controllers\UserController@userLogin')->name('auth.login');
Route::post('logout','\Modules\User\Controllers\UserController@logout')->name('auth.logout');
// Social Login
Route::get('social-login/{provider}', 'Auth\LoginController@socialLogin');
Route::get('social-callback/{provider}', 'Auth\LoginController@socialCallBack');

// Logs
Route::get('admin/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware(['auth', 'dashboard','system_log_view']);
