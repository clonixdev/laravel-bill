<?php

use Illuminate\Support\Facades\Route;
use Clonixdev\LaravelBill\Http\Controllers\InvoiceController;

Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');