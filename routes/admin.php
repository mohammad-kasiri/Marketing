<?php

use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DeleteGroupOfSalesCases;
use App\Http\Controllers\Admin\DistributeController;
use App\Http\Controllers\Admin\FailureReasonController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\AgentInvoiceController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SalesCaseController;
use App\Http\Controllers\Admin\SalesCaseStatusController;
use App\Http\Controllers\Admin\SalesCaseStatusRuleController;
use App\Http\Controllers\Admin\SalesCaseTagController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SMSController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\API\ChartController;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth' , 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get ('',       [HomeController::class ,  'index'])->name('index');

    Route::get ('agent',                                    [AgentController::class , 'index'])         ->name('agent.index');
    Route::get('agents/create',                             [AgentController::class , 'create'])        ->name('agent.create');
    Route::post('agents',                                   [AgentController::class , 'store'])         ->name('agent.store');
    Route::get('agents/{agent}',                            [AgentController::class , 'show'])          ->name('agent.show');
    Route::get('agents/{agent}/login',                      [AgentController::class , 'login'])         ->name('agent.login');
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

    Route::patch('invoice/{invoice}/status',                [InvoiceController::class , 'status'])      ->name('invoice.update.status');

    Route::get ('user_base_report',                         [ReportController::class , 'userBaseReport'])->name('report.userBase.index');
    Route::get ('general_report',                           [ReportController::class , 'generalReport'])->name('report.general.index');
    Route::get ('setting',                                  [SettingController::class , 'index'])       ->name('setting.index');
    Route::patch('setting',                                 [SettingController::class , 'update'])      ->name('setting.update');

    Route::get ('setting/failure_reasons',                  [FailureReasonController::class , 'index'])  ->name('failure-reasons.index');
    Route::post ('setting/failure_reasons',                 [FailureReasonController::class , 'store'])  ->name('failure-reasons.store');
    Route::delete('setting/failure_reasons/{reason}',       [FailureReasonController::class , 'destroy'])->name('failure-reasons.destroy');

    Route::get('setting/distribute',                        [DistributeController::class, 'index'])      ->name('distribute.index');
    Route::post('setting/distribute',                       [DistributeController::class, 'distribute']) ->name('distribute.action');

    Route::get('setting/sales_case_tag',                    [SalesCaseTagController::class, 'index'])    ->name('sales-case-tag.index');
    Route::post('setting/sales_case_tag',                   [SalesCaseTagController::class, 'sort'])     ->name('tag-case-sales.sort');


    Route::get ('setting/sms',                              [SMSController::class, 'index'])             ->name('sms.index');
    Route::post ('setting/sms',                             [SMSController::class, 'store'])             ->name('sms.store');
    Route::get ('setting/sms/{sms}',                        [SMSController::class, 'edit'])              ->name('sms.edit');
    Route::patch('setting/sms/{sms}',                       [SMSController::class, 'update'])            ->name('sms.update');

    Route::get ('setting/group_tag',                        [DeleteGroupOfSalesCases::class, 'index'])   ->name('delete.sales.cases.index');
    Route::delete('setting/group_tag',                      [DeleteGroupOfSalesCases::class, 'destroy']) ->name('delete.sales.cases.destroy');


    Route::get ('transaction',                              [TransactionController::class , 'index'])   ->name('transaction.index');
    Route::get('transaction/create',                        [TransactionController::class , 'create'])  ->name('transaction.create');
    Route::post('transaction/{user}',                       [TransactionController::class , 'store'])   ->name('transaction.store');
    Route::get('transaction/{transaction}/edit',            [TransactionController::class , 'edit'])    ->name('transaction.edit');
    Route::patch('transaction/{transaction}/update',        [TransactionController::class , 'update'])  ->name('transaction.update');
    Route::patch('transaction/{transaction}/status',        [TransactionController::class , 'status'])  ->name('transaction.update.status');

    Route::get ('customer',                                 [CustomerController::class , 'index'])      ->name('customer.index');
    Route::get('customer/create',                           [CustomerController::class , 'create'])     ->name('customer.create');
    Route::get('customer/create/excel',                     [CustomerController::class , 'createExcel'])->name('customer.create.excel');
    Route::post('customer',                                 [CustomerController::class , 'store'])      ->name('customer.store');
    Route::post('customer/excel',                           [CustomerController::class , 'storeExcel']) ->name('customer.store.excel');
    Route::get('customer/{customer}',                       [CustomerController::class , 'show'])       ->name('customer.show');
    Route::get('customer/{customer}/edit',                  [CustomerController::class , 'edit'])       ->name('customer.edit');
    Route::patch('customer/{customer}/update',              [CustomerController::class , 'update'])     ->name('customer.update');
    Route::get('customer/{customer}/smslog',                [CustomerController::class , 'smslog'])     ->name('customer.smslog');
    Route::get('customer/{customer}/calllog',               [CustomerController::class , 'calllog'])    ->name('customer.calllog');

    Route::get ('sales_case',                               [SalesCaseController::class , 'index'])     ->name('sales-case.index');
    Route::get ('sales_case/{salesCase}',                   [SalesCaseController::class , 'show'])      ->name('sales-case.show');
    Route::post ('sales_case/{salesCase}/sms',              [SalesCaseController::class , 'sendSms'])   ->name('sales-case.send-sms');
    Route::post ('sales_case/{salesCase}/status',           [SalesCaseController::class , 'status'])    ->name('sales-case.status');
    Route::post ('sales_case/{salesCase}/description',      [SalesCaseController::class , 'description'])->name('sales-case.description');
    Route::post ('sales_case/{salesCase}/adminNote',        [SalesCaseController::class , 'adminNote']) ->name('sales-case.admin-note');
    Route::post ('sales_case/{salesCase}/close',            [SalesCaseController::class , 'close'])     ->name('sales-case.close');
    Route::post ('sales_case/{salesCase}/open',             [SalesCaseController::class , 'open'])      ->name('sales-case.open');
    Route::post ('sales_case/{salesCase}/promotion',        [SalesCaseController::class , 'promotion']) ->name('sales-case.promotion');
    Route::post ('sales_case/{salesCase}/changeAgent',      [SalesCaseController::class , 'changeAgent'])->name('sales-case.change-agent');

    Route::get ('sales_case_status',                        [SalesCaseStatusController::class , 'index'])      ->name('sales-case-status.index');
    Route::get ('sales_case_status/create',                 [SalesCaseStatusController::class , 'create'])     ->name('sales-case-status.create');
    Route::post ('sales_case_status',                       [SalesCaseStatusController::class , 'store'])      ->name('sales-case-status.store');
    Route::get ('sales_case_status/{status}/edit',          [SalesCaseStatusController::class , 'edit'])       ->name('sales-case-status.edit');
    Route::patch ('sales_case_status/{status}/update',      [SalesCaseStatusController::class , 'update'])     ->name('sales-case-status.update');

    Route::get ('assignment',                               [AssignmentController::class , 'index'])           ->name('assignment.index');
    Route::post('assignment',                               [AssignmentController::class , 'store'])           ->name('assignment.store');


    Route::get ('task',                                     [TaskController::class , 'index'])                 ->name('task.index');
    Route::get ('sales_case/{salesCase}/task/create',       [TaskController::class , 'create'])                ->name('task.create');
    Route::post('sales_case/{salesCase}/task',              [TaskController::class , 'store'])                 ->name('task.store');
    Route::get ('task/{task}/edit',                         [TaskController::class , 'edit'])                  ->name('task.edit');
    Route::patch('task/{task}',                             [TaskController::class , 'update'])                ->name('task.update');
    Route::get('task/markAllAsDone',                        [TaskController::class , 'markAllAsDone'])         ->name('task.mark-all-as-done');
    Route::get('task/{task}',                               [TaskController::class , 'markAsDone'])            ->name('task.mark-as-done');
    Route::delete('task/{task}',                            [TaskController::class , 'destroy'])               ->name('task.destroy');

    Route::get ('sales_case_status_rule',                   [SalesCaseStatusRuleController::class, 'index'])   ->name('sales-case-status-rule.index');
    Route::post ('sales_case_status_rule',                  [SalesCaseStatusRuleController::class, 'store'])   ->name('sales-case-status-rule.store');
    Route::delete('sales_case_status_rule/{rule}',          [SalesCaseStatusRuleController::class, 'destroy']) ->name('sales-case-status-rule.destroy');

    Route::get ('backup/customers_by_product',              [BackupController::class, 'customersByProductIndex']) ->name('backup.customers-by-product.index');
    Route::post('backup/customers_by_product',              [BackupController::class, 'customersByProductPost'])  ->name('backup.customers-by-product.post');



    Route::get('chart/weekly' ,                             [ChartController::class   , 'weekly'])      ->name('chart.total.weekly');
    Route::get('chart/monthly' ,                            [ChartController::class   , 'monthly'])     ->name('chart.total.monthly');

    Route::get('chart/w/{agent}' ,                          [ChartController::class   , 'agentWeekly']) ->name('chart.agent.weekly');
    Route::get('chart/m/{agent}' ,                          [ChartController::class   , 'agentMonthly'])->name('chart.agent.monthly');

});

