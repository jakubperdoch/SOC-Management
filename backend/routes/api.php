<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EncryptionController;
use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API Routes for your application. These
| Routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return 'Database connection successful!';
    } catch (\Exception $e) {
        return 'Could not connect to the database. Please check your configuration.';
    }
});

Route::post('/encrypt-data', [EncryptionController::class, 'encryptData']);

Route::post('/decrypt-data', [EncryptionController::class, 'decryptData']);


Route::post('/users', [UserController::class, 'getUsers']); //done

Route::post('/login', [AuthController::class, 'login']); //done

Route::post('/register', [AuthController::class, 'register']); //done

Route::put('/login/update', [AuthController::class, 'updateLogin']);

Route::delete('/login/delete', [AuthController::class, 'deleteLogin']);


Route::post('/project', [ProjectController::class, 'getSingleProject']); //admin-done teacher-done  student-done  

Route::post('/project/info', [ProjectController::class, 'getProject']); //admin-done teacher-done  student-done  

Route::post('/project/create', [ProjectController::class, 'createProject']); //done

Route::put('/project/update', [ProjectController::class, 'updateProject']);

Route::delete('/project/delete', [ProjectController::class, 'deleteProject']);

Route::put('/project/add-review', [ProjectController::class, 'addReview']);


Route::post('/student/info', [StudentController::class, 'getStudent']);


Route::post('/teacher', [TeacherController::class, 'getTeacher']);

Route::post('/teacher/create', [TeacherController::class, 'createTeacher']);

Route::put('/teacher/update', [TeacherController::class, 'updateTeacher']);

Route::delete('/teacher/delete', [TeacherController::class, 'deleteTeacher']);



Route::post('/project/deadline', [ProjectController::class, 'setProjectDeadline']);

Route::post('/project/deadline/get-deadline', [ProjectController::class, 'getProjectDeadline']);

Route::post('project/deadline/alert-deadline', [AdminController::class, 'alertDeadlines']);


