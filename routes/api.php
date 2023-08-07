<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Import\ImportExcelController;
use App\Http\Controllers\Row\RowController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/import', [ImportExcelController::class, 'import'])->middleware('basic.auth');
Route::resource('rows', RowController::class)->only('index');
