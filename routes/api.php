<?php

use App\Http\Controllers\OrdersController;
use Illuminate\Support\Facades\Route;

Route::post('/orders', [OrdersController::class, 'ordersCheck']);
