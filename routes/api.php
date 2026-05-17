<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonitorController;

Route::get('/monitors', [MonitorController::class, 'index']);
Route::post('/monitors', [MonitorController::class, 'store']);
Route::get('/monitors/{id}/history', [MonitorController::class, 'history']);
