<?php

use Illuminate\Support\Facades\Route;
use Clonixdev\LaravelBill\Http\Controllers\InvoiceController;
use Clonixdev\LaravelBill\Http\Controllers\CurrencyController;
use Clonixdev\LaravelBill\Http\Controllers\OrderController;
use Clonixdev\LaravelBill\Http\Controllers\PayMethodController;

Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
Route::post('/invoices/{id}/checkout', [InvoiceController::class, 'checkout'])->name('invoices.checkout');
Route::delete('/invoices/{id}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');


Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
Route::post('/orders/{id}/bill', [OrderController::class, 'bill'])->name('orders.bill');
Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');


Route::get('/currencies', [CurrencyController::class, 'index'])->name('currencies.index');
Route::get('/currencies/{id}', [CurrencyController::class, 'show'])->name('currencies.show');
Route::post('/currencies', [CurrencyController::class, 'store'])->name('currencies.store');
Route::put('/currencies/{id}', [CurrencyController::class, 'update'])->name('currencies.update');
Route::delete('/currencies/{id}', [CurrencyController::class, 'destroy'])->name('currencies.destroy');

Route::get('/pay-methods', [PayMethodController::class, 'index'])->name('pay-method.index');
Route::get('/pay-methods/{id}', [PayMethodController::class, 'show'])->name('pay-method.show');
Route::post('/pay-methods', [PayMethodController::class, 'store'])->name('pay-method.store');
Route::put('/pay-methods/{id}', [PayMethodController::class, 'update'])->name('pay-method.update');
Route::delete('/pay-methods/{id}', [PayMethodController::class, 'destroy'])->name('pay-method.destroy');


Route::get('/external-link', [PayMethodController::class, 'externalLink'])->name('pay-method.external-link');