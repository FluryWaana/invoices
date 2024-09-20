<?php

use App\Http\Controllers\Api\V1\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('invoices', [InvoiceController::class, 'index'])->middleware('isProtected');
    Route::post('invoices', [InvoiceController::class, 'store']);
});
