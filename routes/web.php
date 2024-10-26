<?php

use App\Http\Controllers\ApiTestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('testapi');
});


Route::get('/testapi', function () {
    return view('testapi');
});
