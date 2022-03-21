<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IvoiceController;
use App\Http\Controllers\GeneralController;
use Illuminate\Support\Facades\Auth;

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

// Default Route
Route::get('/', [IvoiceController::class, 'index'])->name('index')->middleware('auth');
Route::get('/home', [IvoiceController::class, 'home'])->name('home')->middleware('auth');

// To Change The Local Language
Route::get('/change-language{locale}', [GeneralController::class, 'changeLanguage'])->name('frontend_change_locale');

// Delete Invoice
Route::get('/invoice/delete/{id?}', [IvoiceController::class, 'destroy'])->name('invoice.delete');

//  Print Invoice
Route::get('/invoice/print/{id?}', [IvoiceController::class, 'print'])->name('invoice.print');

//  Export Invoice As PDF
Route::get('/invoice/pdf/{id?}', [IvoiceController::class, 'pdf'])->name('invoice.pdf');

//  Send Emali To Customer
Route::get('/invoice/sendemail/{id?}', [IvoiceController::class, 'sendemail'])->name('invoice.sendEmail');

// For All Function In Controller
Route::resource('invoice', IvoiceController::class);
