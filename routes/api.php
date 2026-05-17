<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonitorController;


Route::post('/monitors', [MonitorController::class, 'store']);

