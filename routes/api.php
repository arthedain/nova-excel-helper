<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

// Route::get('/endpoint', function (Request $request) {
//     //
// });
Route::post('/import', 'Arthedain\NovaExcelHelper\Http\Controllers\ExcelController@import');
Route::get('/export', 'Arthedain\NovaExcelHelper\Http\Controllers\ExcelController@export');
Route::get('/get-models', 'Arthedain\NovaExcelHelper\Http\Controllers\ExcelController@getModels');
