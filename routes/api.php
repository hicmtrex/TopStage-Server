<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\SubjectController;
use Illuminate\Http\Request;
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

Route::get("/subjects", [SubjectController::class, "index"]);



Route::group(['middleware' => ['auth:sanctum', 'banned']], function () {


    // all users && stages
    Route::post("/users/logout", [AuthController::class, "logout"]);
    Route::post('password/reset', [ForgotPasswordController::class, "reset_stage"]);
    Route::post('password/reset_user', [ForgotPasswordController::class, "reset_user"]);
    Route::put("/users/{id}", [AuthController::class, "self_update"]);
    Route::put("/stages/{id}", [StageController::class, "update"]);
    Route::get("/stages/{id}", [StageController::class, "show"]);

    //answers

    Route::get("/answers", [AnswerController::class, "index"]);
    Route::get("/answers_stage", [AnswerController::class, "stage_answers"]);
    Route::get("/answers/approvedresult", [AnswerController::class, "approvedResult"]);


    Route::post("/questions_answers", [AnswerController::class, "store"]);
    Route::get("/questions/quiz", [QuestionController::class, "questions"]);


    // subjects
    Route::post("/subjects", [SubjectController::class, "store"])->middleware('encadrant');
    Route::delete("/subjects/{id}", [SubjectController::class, "destroy"])->middleware('encadrant');

    //encadrant

    //service_rh 
    Route::get("/users", [AuthController::class, "index"])->middleware("service_rh");
    Route::get("/users/{id}", [AuthController::class, "show"])->middleware('service_rh');
    Route::get("/stages", [StageController::class, "index"]);

    Route::put("/questions/{id}", [QuestionController::class, "update"]);
    Route::post("/questions", [QuestionController::class, "store"])->middleware('service_rh');
    Route::get("/questions/{id}", [QuestionController::class, "show"])->middleware('service_rh');
    Route::delete("/questions/{id}", [QuestionController::class, "destroy"])->middleware('service_rh');

    // coordinator
    Route::put("/admin/users/{id}", [AuthController::class, "update"])->middleware('coordinator');
    Route::post("/users", [AuthController::class, "store"])->middleware('coordinator');
    Route::delete("/users/{id}", [AuthController::class, "destroy"])->middleware('coordinator');
});



//forgot password

Route::post("/password/forgot", [ForgotPasswordController::class, "forgot_stage"]);
Route::post("/password/forgot_user", [ForgotPasswordController::class, "forgot_user"]);

//question

Route::get("/questions", [QuestionController::class, "index"]);


//stagers
Route::post("/stages/register", [StageController::class, "register"]);
Route::post("/stages/login", [StageController::class, "login"]);


Route::post("/users/register", [AuthController::class, "register"]);
Route::post("/users/login", [AuthController::class, "login"]);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
