<?php

use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth' , 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get ('',       [HomeController::class ,  'index'])->name('index');

    Route::get ('agent',                     [AgentController::class , 'index'])         ->name('agent.index');
    Route::get('agents/create',              [AgentController::class , 'create'])        ->name('agent.create');
    Route::post('agents',                    [AgentController::class , 'store'])         ->name('agent.store');
    Route::get('agents/{agent}',             [AgentController::class , 'show'])          ->name('agent.show');
    Route::get('agents/{agent}/edit',        [AgentController::class , 'edit'])          ->name('agent.edit');
    Route::patch('agents/{agent}',           [AgentController::class , 'update'])        ->name('agent.update');


});

