<?php

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patient\SignUpController;
use App\Http\Controllers\Common\SignInController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Admin\AdminDoctorController;

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

Route::post("/sign-up",  [SignUpController::class, 'signUp']); 
Route::post("/sign-in",  [SignInController::class, 'signIn']); 
Route::post("/doctor/profile", [DoctorController::class, 'profileDoctor']);
Route::post("/sign-up",  [SignUpController::class, 'signUp']);


Route::post("/sign-in",  [SignInController::class, 'signIn']);
Route::get('/profile/{id}', [PatientController::class, 'index']);
Route::post('/profile/{id}', [PatientController::class, 'update']);

Route::get("/doctor/profile/{id}", [DoctorController::class, 'profileDoctor']);

Route::get('/Admin/getAllDoctor', [AdminDoctorController::class, 'getAllDoctors']);
Route::post('/Admin/createDoctor', [AdminDoctorController::class, 'createDoctor']);