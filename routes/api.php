<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneDataController;
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
Route::get('gene-data', 'App\Http\Controllers\GeneDataController@index');
Route::get('/unique-gene-ids', 'App\Http\Controllers\GeneDataController@uniqueGeneIds');
Route::get('/unique-sras', 'App\Http\Controllers\GeneDataController@uniqueSras');
Route::get('/unique-expriments', 'App\Http\Controllers\GeneDataController@uniqueExpriments');
Route::get('/diseases', 'App\Http\Controllers\GeneDataController@getPossibleDiseases');
Route::get('/possible-expriments', 'App\Http\Controllers\GeneDataController@getPossibleExpriments');
Route::get('/possible-sras', 'App\Http\Controllers\GeneDataController@getPossibleSras');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
