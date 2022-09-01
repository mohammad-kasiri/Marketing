<?php

use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\AgentInvoiceController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\API\ChartController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth' , 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get ('',       [HomeController::class ,  'index'])->name('index');

    Route::get ('agent',                                    [AgentController::class , 'index'])         ->name('agent.index');
    Route::get('agents/create',                             [AgentController::class , 'create'])        ->name('agent.create');
    Route::post('agents',                                   [AgentController::class , 'store'])         ->name('agent.store');
    Route::get('agents/{agent}',                            [AgentController::class , 'show'])          ->name('agent.show');
    Route::get('agents/{agent}/edit',                       [AgentController::class , 'edit'])          ->name('agent.edit');
    Route::patch('agents/{agent}',                          [AgentController::class , 'update'])        ->name('agent.update');

    Route::get('agents/{agent}/invoice',                    [AgentInvoiceController::class , 'index'])       ->name('agent.invoice.index');
    Route::get('agents/{agent}/invoice/{invoice}/edit',     [AgentInvoiceController::class , 'edit'])        ->name('agent.invoice.edit');
    Route::patch('agents/{agent}/invoice/{invoice}',        [AgentInvoiceController::class , 'update'])      ->name('agent.invoice.update');
    Route::delete('agents/{agent}/invoice/{invoice}',       [AgentInvoiceController::class , 'destroy'])     ->name('agent.invoice.destroy');

    Route::get ('product',                                  [ProductController::class , 'index'])       ->name('product.index');
    Route::get('product/create',                            [ProductController::class , 'create'])      ->name('product.create');
    Route::post('product',                                  [ProductController::class , 'store'])       ->name('product.store');
    Route::get('product/{product}',                         [ProductController::class , 'show'])        ->name('product.show');
    Route::get('product/{product}/edit',                    [ProductController::class , 'edit'])        ->name('product.edit');
    Route::patch('product/{product}',                       [ProductController::class , 'update'])      ->name('product.update');
    Route::delete('product/{product}',                      [ProductController::class , 'destroy'])     ->name('product.destroy');

    Route::get ('invoice',                                  [InvoiceController::class , 'index'])       ->name('invoice.index');
    Route::get('invoice/{invoice}/edit',                    [InvoiceController::class , 'edit'])        ->name('invoice.edit');
    Route::patch('invoice/{invoice}',                       [InvoiceController::class , 'update'])      ->name('invoice.update');
    Route::delete('invoice/{invoice}',                      [InvoiceController::class , 'destroy'])     ->name('invoice.destroy');


    Route::get('chart/weekly' ,                             [ChartController::class   , 'weekly'])      ->name('chart.total.weekly');
    Route::get('chart/monthly' ,                            [ChartController::class   , 'monthly'])     ->name('chart.total.monthly');

    Route::get('chart/w/{agent}' ,                          [ChartController::class   , 'agentWeekly']) ->name('chart.agent.weekly');
    Route::get('chart/m/{agent}' ,                          [ChartController::class   , 'agentMonthly'])->name('chart.agent.monthly');
});

