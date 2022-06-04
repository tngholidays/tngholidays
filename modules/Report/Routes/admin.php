<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/1/2019
 * Time: 10:02 AM
 */
use Illuminate\Support\Facades\Route;
Route::group(['prefix' => 'booking'],function (){
    Route::get('/','BookingController@index')->name('report.admin.booking');
    Route::get('/email_preview/{id}','BookingController@email_preview')->name('report.booking.email_preview');
    Route::get('/invoice_preview/{id}','BookingController@invoice_preview')->name('report.booking.invoice_preview');
    Route::get('/ticket_preview/{id}','BookingController@ticket_preview')->name('report.booking.ticket_preview');
    Route::get('/manage_itinerary/{id}','BookingController@manage_itinerary')->name('report.booking.manage_itinerary');
    Route::get('/manage_voucher/{id}','BookingController@manage_voucher')->name('report.booking.manage_voucher');
    Route::get('/documents/{id}','BookingController@documents')->name('report.booking.documents');
    Route::get('/mail_voucher/{id}','BookingController@mail_voucher')->name('report.booking.mail_voucher');
    Route::post('/send_mail/{id}','BookingController@send_mail')->name('report.booking.send_mail');
    Route::post('/send_ticket_mail/{id}','BookingController@send_ticket_mail')->name('report.booking.send_ticket_mail');
    Route::get('/edit_voucher/{id}','BookingController@edit_voucher')->name('report.booking.edit_voucher');
    Route::get('/delete_voucher/{id}','BookingController@delete_voucher')->name('report.booking.delete_voucher');
    Route::post('/store/{id}','BookingController@storeItinerary')->name('report.admin.storeItinerary');
    Route::post('/storeVoucher/{id}','BookingController@storeVoucher')->name('report.admin.storeVoucher');
    Route::post('/storeDocuments/{id}','BookingController@storeDocuments')->name('report.admin.storeDocuments');

    Route::get('/mail_ticket/{id}','BookingController@mail_ticket')->name('report.booking.mail_ticket');

    Route::get('/custom_tour/{id}/{tour_id?}','EnquiryController@customTour')->name('report.booking.customTour');
    Route::get('/booking_proposal/{id}/{tour_id?}','EnquiryController@booking_proposal')->name('report.booking.booking_proposal');
    Route::post('/storeCustomTour/{id}','EnquiryController@storeCustomTour')->name('report.admin.storeCustomTour');
    Route::post('/storeProposal/{id}','EnquiryController@storeProposal')->name('report.admin.storeProposal');
    Route::any('/view_proposal/{id}/{action?}','EnquiryController@viewProposal')->name('report.admin.viewProposal');
    Route::any('/proposal_pdf/{id}/{action?}','EnquiryController@viewProposalFromLead')->name('report.admin.viewProposalFromLead');
    Route::get('/copyEnquiry/{id}','EnquiryController@copyEnquiry')->name('report.admin.copyEnquiry');
    Route::get('/booking-form/{id}','EnquiryController@bookingForm')->name('report.admin.bookingForm');
    Route::post('/bookingByAdmin/{id}','EnquiryController@bookingByAdmin')->name('report.admin.bookingByAdmin');
});
