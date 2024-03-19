<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\FundManagerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('/fund-managers')->controller(FundManagerController::class)->group(function () {
    Route::get('/', 'list');
    Route::post('/', 'create');

    Route::get('/{fund_manager}', 'details');
    Route::put('/{fund_manager}', 'update');
});

Route::prefix('/companies')->controller(CompanyController::class)->group(function () {
    Route::get('/', 'list');
    Route::post('/', 'create');

    Route::get('/{company}', 'details');
    Route::put('/{company}', 'update');
});

Route::prefix('/funds')->controller(FundController::class)->group(function () {
    Route::get('/', 'list');
    Route::post('/', 'create');
    Route::get('/duplicates', 'getPotentialDuplicates');

    Route::get('/{fund}', 'details');
    Route::put('/{fund}', 'update');
});
