<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Request;

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

Auth::routes();
Route::get('/dinner/dance', function () {
    return view('bookingForm.new-booking');
})->name('dinner.dance');
Route::get('/clover/united/registeration', [App\Http\Controllers\TicketController::class, 'cloverUnitedIndex'])->name('clover.united.registeration');
Route::get('/', [App\Http\Controllers\TicketController::class, 'cloverUnitedIndex'])->name('customer.registeration');
Route::get('/search-patient', [App\Http\Controllers\TicketController::class, 'searchPatient'])->name('searchPatient');

Route::post('storeTicket', [App\Http\Controllers\TicketController::class, 'store'])->name('storeDetails');
Route::post('storeDinnerDanceTicket', [App\Http\Controllers\DinnerDanceTicketController::class, 'store'])->name('storeDinnerDanceDetails');
Route::get('/confirmation/page', [App\Http\Controllers\TicketController::class, 'thankYou'])->name('thankYou');
Route::get('/confirmation/dinner/dance', [App\Http\Controllers\DinnerDanceTicketController::class, 'dinnerDanceThankYouPage'])->name('dinnerDanceThankYouPage');
Route::get('paymentSuccess', [App\Http\Controllers\TicketController::class, 'paymentSuccess'])->name('paymentSuccess');
Route::get('createBooking', [App\Http\Controllers\TicketController::class, 'createBooking'])->name('createBooking');
Route::get('sendEmail', [App\Http\Controllers\TicketController::class, 'sendEmail'])->name('sendEmail');
Route::post('/stripe/webhook', [App\Http\Controllers\TicketController::class, 'handleWebhook'])->name('stripe.webhook');
Route::get('/booking/confirm', [App\Http\Controllers\TicketController::class, 'confirm'])->name('booking.confirm');
Route::get('/dinnerDance/confirm', [App\Http\Controllers\DinnerDanceTicketController::class, 'confirmDinerDanceTicket'])->name('dinnerDance.confirm');
Route::get('/logsDownload', [App\Http\Controllers\TicketController::class, 'logsDownload'])->name('logsDownload');
Route::get('/stripe', function (Request $request) {
    $id = $request->input('id');
    // $returnUrl = $request->input('returnUrl');
    // $failureUrl = $request->input('failureUrl');
    return view('stripe', ['paymentIntentId' => $id]);
})->name('stripe.confirm');

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::get('/registrations', [App\Http\Controllers\TicketDetailsController::class, 'ticketEntries'])->name('bookings');
    Route::get('/ticketDetail/{id}', [App\Http\Controllers\TicketDetailsController::class, 'ticketDetail'])->name('ticketDetail');
    Route::get('exportTickets', [App\Http\Controllers\TicketDetailsController::class, 'exportTickets'])->name('exportTickets');
    Route::get('pdfTickets/{id}', [App\Http\Controllers\TicketDetailsController::class, 'pdfTickets'])->name('pdfTickets');
    Route::get('export', [App\Http\Controllers\TicketDetailsController::class, 'export'])->name('export');
    Route::post('/resend-email', [App\Http\Controllers\TicketDetailsController::class, 'resendEmail'])->name('resendEmail');
    Route::post('/delete-ticket', [App\Http\Controllers\TicketController::class, 'deleteTicket'])->name('deleteTicket');

    Route::get('/medicines/index', [App\Http\Controllers\MedicineController::class, 'index'])->name('medicines');
    Route::get('/medicines/fetch', [App\Http\Controllers\MedicineController::class, 'fetch'])->name('medicines.fetch');
    Route::post('/medicines', [App\Http\Controllers\MedicineController::class, 'store'])->name('medicines.store');
    Route::put('/medicines/{id}', [App\Http\Controllers\MedicineController::class, 'update']);
    Route::delete('/medicines/{id}', [App\Http\Controllers\MedicineController::class, 'destroy']);

    Route::get('/labs/index', [App\Http\Controllers\LabController::class, 'index'])->name('labs');
    Route::get('/labs/fetch', [App\Http\Controllers\LabController::class, 'fetch'])->name('labs.fetch');
    Route::post('/labs', [App\Http\Controllers\LabController::class, 'store'])->name('labs.store');
    Route::put('/labs/{id}', [App\Http\Controllers\LabController::class, 'update']);
    Route::delete('/labs/{id}', [App\Http\Controllers\LabController::class, 'destroy']);


    Route::post('/appointments/add-details', [App\Http\Controllers\AppoinmentController::class, 'store'])->name('items.store');

    



    // Route::get('/thankyou', [App\Http\Controllers\TicketDetailsController::class, 'thankyou'])->name('thankyou');
});
