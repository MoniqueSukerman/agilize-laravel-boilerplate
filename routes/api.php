<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Packages\Student\Controller\StudentController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/student', [StudentController::class, 'store']);

Route::get('/student', [StudentController::class,'index']);

Route::get('/student/id/{id}', [StudentController::class,'findById']);

Route::get('/student/name/{name}', [StudentController::class,'findByName']);

Route::put('/student/id/{id}', [StudentController::class,'update']);

Route::delete('/student/id/{id}', [StudentController::class,'remove']);
