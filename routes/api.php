<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TacheController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('register/member', 'registerMember');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::controller(ProjectController::class)->group(function () {
    Route::get('project', 'index');
    Route::post('project', 'store');
    Route::get('project/{id}', 'show');
    Route::put('project/{id}', 'update');
    //exemple api fileter http://127.0.0.1:8000/api/project/project/filter?title=project&limit=1&page=2
    Route::get('project/project/filter', 'filter');

    Route::delete('project/{id}', 'destroy');
}); 

Route::controller(TacheController::class)->group(function () {
    Route::get('tache', 'index');
    Route::post('tache', 'store');
    Route::get('tache/{id}', 'show');
    //exemple api fileter http://127.0.0.1:8000/api/tache/tache/filter?status=pend&page=1&limit=2
    Route::get('tache/tache/filter', 'filter');
    Route::put('tache/{id}', 'update');
});
