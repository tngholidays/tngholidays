<?php
use Illuminate\Support\Facades\Route;
Route::get('gateway_callback/checkourRazorPayGT/{c}/{r}','RazorPayCheckoutController@handleCheckout')->middleware('auth')
    ->name('checkoutRazorPayGateway');

Route::get('gateway_callback/walletRazorPayGT/{c}/{r}','RazorPayCheckoutController@handleWallet')->middleware('auth')
    ->name('handleWalletRazorPayGateway');

    // http://192.168.1.21:8001/gateway_callback/checkourRazorPayGT/f319a7b6a02922be2de4515226043bf4/booking/f319a7b6a02922be2de4515226043bf4
Route::post('gateway_callback/processRazorPayGT/{c}/{r}','RazorPayCheckoutController@handleProcess')->name('processRazorPayGateway')->middleware('auth');

Route::post('gateway_callback/processRazorPayGTWallet/{c}/{r}','RazorPayCheckoutController@handleProcessWallet')->name('processRazorPayGatewayWallet')->middleware('auth');