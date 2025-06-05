<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\InviteController;

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

Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return 'Database connection successful!';
    } catch (\Exception $e) {
        return 'Could not connect to the database. Please check your configuration.';
    }
});


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::post('/invite/validate', [InviteController::class, 'validateToken']);


    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::put('/change-password', [AuthController::class, 'changePassword'])->name('changePassword');
    });
});


Route::middleware('auth:sanctum')->group(function () {
    route::get('/user/info', [StudentController::class, 'getStudent'])->name('user.info');
    Route::delete('/user/delete', [AuthController::class, 'deleteLogin'])->name('user.delete');
    Route::put('/user/{id}/update', [AuthController::class, 'updateLogin'])->name('user.update');
    Route::get('/users/{role}', [UserController::class, 'getUsers'])->name('user.getUsers');
    route::get('/user/{id}', [UserController::class, 'getUser'])->name('user.getUser');
});

Route::middleware('auth:sanctum')->group(function () {
    route::get('/project/{id}', [ProjectController::class, 'getSingleProject'])->name('project.getSingleProject');
    route::get('/projects', [ProjectController::class, 'getProject'])->name('project.getProject');
    route::post('/project/create', [ProjectController::class, 'createProject'])->name('project.createProject');
    route::put('/project/update', [ProjectController::class, 'updateProject'])->name('project.updateProject');
    route::delete('/project/delete', [ProjectController::class, 'deleteProject'])->name('project.deleteProject');
});

Route::middleware('auth:sanctum')->group(function () {
    route::post('/teacher', [TeacherController::class, 'getTeacher'])->name('teacher.getTeacher');
    route::post('/teacher/create', [TeacherController::class, 'createTeacher'])->name('teacher.createTeacher');
    route::put('/teacher/update', [TeacherController::class, 'updateTeacher'])->name('teacher.updateTeacher');
    route::delete('/teacher/delete', [TeacherController::class, 'deleteTeacher'])->name('teacher.deleteTeacher');
});

//TODO: Add middleware for admin and teacher roles
Route::middleware(['auth:sanctum', 'role:admin,teacher'])
    ->post('/invite/send', [InviteController::class, 'sendInvite']);

Route::middleware('auth:sanctum')->group(function () {
    route::get('/stats', [StatsController::class, 'getStats'])->name('stats.getStats');
});


