<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use Illuminate\Http\Request;
use App\Http\Controllers\EmployeeController;

Route::apiResource('employees', EmployeeController::class);