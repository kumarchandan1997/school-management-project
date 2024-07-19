<?php

use App\Http\Controllers\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\AddcoursesController;
use App\Http\Controllers\UserController;

use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\User;


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

// Route for Subjeact name
Route::post('/test', [AddcoursesController::class, 'testapi']);


//api for change status requested course
Route::post('status', [CoursesController::class, 'updatestatus']);


Route::post('school', [AddcoursesController::class, 'deactivateSchool']);








