<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Packages\Student\Controller\StudentController;
use App\Packages\Exam\Controller\SubjectController;
use App\Packages\Exam\Controller\QuestionController;

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

Route::get('/student/{id}', [StudentController::class,'findById']);

Route::put('/student/{id}', [StudentController::class,'update']);

Route::delete('/student/{id}', [StudentController::class,'remove']);

    //subject

Route::post('/subject', [SubjectController::class, 'store']);

Route::get('/subject', [SubjectController::class,'index']);

Route::get('/subject/{id}', [SubjectController::class,'findById']);

Route::put('/subject/{id}', [SubjectController::class,'update']);

Route::delete('/subject/{id}', [SubjectController::class,'remove']);

//question

Route::post('/question', [QuestionController::class, 'store']);

Route::get('/question', [QuestionController::class,'index']);

Route::get('/question/{id}', [QuestionController::class,'findById']);

Route::put('/question/{id}', [QuestionController::class,'update']);

Route::delete('/question/{id}', [QuestionController::class,'remove']);
