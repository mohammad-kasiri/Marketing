<?php

use App\Http\Controllers\Agent\HomeController;
use App\Http\Controllers\Agent\InvoiceController;
use App\Http\Controllers\API\ChartController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('agent')->name('agent.')->group(function () {
    Route::get ('',       [HomeController::class ,  'index'])->name('index');

    Route::get ('invoice',                 [InvoiceController::class , 'index'])         ->name('invoice.index');
    Route::get('invoice/create',           [InvoiceController::class , 'create'])        ->name('invoice.create');
    Route::post('invoice',                 [InvoiceController::class , 'store'])         ->name('invoice.store');
    Route::get('invoice/{invoice}/edit',   [InvoiceController::class , 'edit'])          ->name('invoice.edit');
    Route::patch('invoice/{invoice}',      [InvoiceController::class , 'update'])        ->name('invoice.update');
    Route::delete('invoice/{invoice}',     [InvoiceController::class , 'destroy'])       ->name('invoice.destroy');

    Route::get('chart/w/{agent}' ,         [ChartController::class   , 'agentWeekly'])   ->name('chart.agent.weekly');
    Route::get('chart/m/{agent}' ,         [ChartController::class   , 'agentMonthly'])  ->name('chart.agent.monthly');
});
