<?php

use App\Http\Controllers\Agent\CallCheckController;
use App\Http\Controllers\Agent\CustomerController;
use App\Http\Controllers\Agent\HomeController;
use App\Http\Controllers\Agent\InvoiceController;
use App\Http\Controllers\Agent\ReportController;
use App\Http\Controllers\Agent\SalesCaseController;
use App\Http\Controllers\Agent\TaskController;
use App\Http\Controllers\API\ChartController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('agent')->name('agent.')->group(function () {
    Route::get ('',       [HomeController::class ,  'index'])->name('index');

    Route::get ('invoice',                 [InvoiceController::class , 'index'])                ->name('invoice.index');

    Route::get('invoice/create',                                        [InvoiceController::class , 'createInvoice'])              ->name('invoice.create');
    Route::get('invoice/create/check_customer_exists',                  [InvoiceController::class , 'checkCustomerExists'])        ->name('invoice.create.check-customer-exists');

    Route::get('invoice/create/without_customer',                       [InvoiceController::class , 'createWithoutCustomer'])      ->name('invoice.create.without_customer');
    Route::post('invoice/store/without_customer',                       [InvoiceController::class , 'storeWithOutCustomer'])       ->name('invoice.store.without-customer');

    Route::get('invoice/create/customer_exist',                         [InvoiceController::class , 'customerExists'])             ->name('invoice.create.customer_exist');

    Route::get('invoice/create/customer_exist/{salesCase}',             [InvoiceController::class , 'createWithSalesCase'])        ->name('invoice.create.with-sales-case');
    Route::post('invoice/store/with_sales_case',                        [InvoiceController::class , 'storeWithSalesCase'])         ->name('invoice.store.with-sales-case');

    Route::get('invoice/create/customer_exist_without_sales_case/',     [InvoiceController::class , 'createWithoutSalesCase'])      ->name('invoice.create.without-sales-case');
    Route::post('invoice/store/without_sales_case',                     [InvoiceController::class , 'storeWithoutSalesCase'])      ->name('invoice.store.without-sales-case');


    Route::get('invoice/{invoice}/edit',            [InvoiceController::class , 'edit'])          ->name('invoice.edit');
    Route::patch('invoice/{invoice}',               [InvoiceController::class , 'update'])        ->name('invoice.update');
    Route::delete('invoice/{invoice}',              [InvoiceController::class , 'destroy'])       ->name('invoice.destroy');

    Route::get ('report',                  [ReportController::class , 'index'])          ->name('report.index');

    Route::get ('sales_case',                               [SalesCaseController::class , 'index'])      ->name('sales-case.index');
    Route::get ('sales_case/{salesCase}',                   [SalesCaseController::class , 'show'])       ->name('sales-case.show');
    Route::post ('sales_case/{salesCase}/sms',              [SalesCaseController::class , 'sendSms'])    ->name('sales-case.send-sms');
    Route::post ('sales_case/{salesCase}/status',           [SalesCaseController::class , 'status'])     ->name('sales-case.status');
    Route::post ('sales_case/{salesCase}/description',      [SalesCaseController::class , 'description'])->name('sales-case.description');
    Route::post ('sales_case/{salesCase}/close',            [SalesCaseController::class , 'close'])      ->name('sales-case.close');
    Route::post ('sales_case/{salesCase}/open',             [SalesCaseController::class , 'open'])       ->name('sales-case.open');

    Route::get ('task',                                     [TaskController::class , 'index'])           ->name('task.index');
    Route::get ('sales_case/{salesCase}/task/create',       [TaskController::class , 'create'])          ->name('task.create');
    Route::post('sales_case/{salesCase}/task',              [TaskController::class , 'store'])           ->name('task.store');
    Route::get ('task/{task}/edit',                         [TaskController::class , 'edit'])            ->name('task.edit');
    Route::patch('task/{task}',                             [TaskController::class , 'update'])          ->name('task.update');
    Route::get('task/markAllAsDone',                        [TaskController::class , 'markAllAsDone'])   ->name('task.mark-all-as-done');
    Route::get('task/{task}',                               [TaskController::class , 'markAsDone'])      ->name('task.mark-as-done');
    Route::delete('task/{task}',                            [TaskController::class , 'destroy'])         ->name('task.destroy');

    Route::get('customer/{customer}',                       [CustomerController::class , 'show'])       ->name('customer.show');
    Route::get('customer/{customer}/edit',                  [CustomerController::class , 'edit'])       ->name('customer.edit');
    Route::patch('customer/{customer}/update',              [CustomerController::class , 'update'])     ->name('customer.update');

    Route::get('chart/w/{agent}' ,                          [ChartController::class   , 'agentWeekly'])   ->name('chart.agent.weekly');
    Route::get('chart/m/{agent}' ,                          [ChartController::class   , 'agentMonthly'])  ->name('chart.agent.monthly');
    Route::post('call-check' ,                              [CallCheckController::class   , 'check'])     ->name('call.check');
});
