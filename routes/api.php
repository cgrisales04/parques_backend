<?php

use App\Http\Controllers\ParquesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/parques', [ParquesController::class, 'insert_park']);
Route::put('/parques/{codigo_parques}', [ParquesController::class, 'update_park']);
Route::delete('/parques/{codigo_parques}', [ParquesController::class, 'delete_park']);
Route::get('/parques/{codigo_parques}', [ParquesController::class, 'find_one_park']);
Route::get('/parques', [ParquesController::class, 'find_park']);