<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Imports\DrocaveProductImport;
use Maatwebsite\Excel\Facades\Excel;
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

Route::post('/eventos', "App\Http\Controllers\EventosController@store");
Route::get('/puestos/{id}', "App\Http\Controllers\PuestosController@index");
Route::put('/ocupar/{id}', "App\Http\Controllers\PuestosController@update");
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/import', function (Request $request) {
    $file = $request->file('file');
    Excel::import(new DrocaveProductImport, $file);
});
