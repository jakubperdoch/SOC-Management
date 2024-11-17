<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
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

Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return 'Database connection successful!';
    } catch (\Exception $e) {
        return 'Could not connect to the database. Please check your configuration.';
    }
});

Route::post('/users', [UserController::class, 'getUsers']); //done

Route::post('/login', [AuthController::class, 'login']); //done

Route::post('/register', [AuthController::class, 'register']); //done

Route::put('/login/update', [AuthController::class, 'updateLogin']);

Route::delete('/login/delete', [AuthController::class, 'deleteLogin']);


route::post('/project', [ProjectController::class, 'getSingleProject']); //admin-done teacher-done  student-done  

route::post('/project/info', [ProjectController::class, 'getProject']); //admin-done teacher-done  student-done  

route::post('/project/create', [ProjectController::class, 'createProject']); //done

route::put('/project/update', [ProjectController::class, 'updateProject']);

route::delete('/project/delete', [ProjectController::class, 'deleteProject']);


route::post('/student/info', [StudentController::class, 'getStudent']);


route::post('/teacher', [TeacherController::class, 'getTeacher']);

route::post('/teacher/create', [TeacherController::class, 'createTeacher']);

route::put('/teacher/update', [TeacherController::class, 'updateTeacher']);

route::delete('/teacher/delete', [TeacherController::class, 'deleteTeacher']);


