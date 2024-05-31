<?php

use App\Http\Controllers\Admin\AdminController;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patient\SignUpController;
use App\Http\Controllers\Admin\AdminPatientController;
use App\Http\Controllers\Common\SignInController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Admin\AdminDoctorController;
use App\Http\Controllers\Patient\AppoinmentController;

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

Route::post("/sign-up",  [SignUpController::class, 'signUp']); // ADMIN
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminPatientController::class, 'dashboard']);

    Route::prefix('patients')->group(function () {
        Route::get('/', [AdminPatientController::class, 'getAllPatients']);
        Route::post('/create', [AdminPatientController::class, 'createPatient']);
        Route::post('/profile/{id}', [AdminPatientController::class, 'updateProfilePatient']);
        // Route::get('/search', [AdminPatientController::class, 'search']);
    });
    Route::prefix('doctors')->group(function () {
        Route::get('/', [AdminDoctorController::class, 'getAllDoctors']);
        Route::post('/create', [AdminDoctorController::class, 'createDoctor']);
    });

    Route::prefix('users')->group(function () {
        Route::post('/status/active/{id}', [AdminController::class, 'updateStatusUsersActive']);
        Route::post('/status/block/{id}', [AdminController::class, 'updateStatusUsersInactive']);
    });
});
Route::post("/sign-up",  [SignUpController::class, 'signUp']); 
Route::post("/sign-in",  [SignInController::class, 'signIn']); 

Route::get('/detail/{id}', [PatientController::class, 'ViewInformationDoctor']);

Route::get('/profile/{id}', [PatientController::class, 'profilePatient']);

Route::post('/profile/{id}/edit', [PatientController::class, 'updatePatient']);

Route::post("/doctor/profile", [DoctorController::class, 'profileDoctor']);
Route::get("/doctor/profile/{id}", [DoctorController::class, 'profileDoctor']);
Route::post('/updateProfile/doctor', [DoctorController::class, 'updateProfileDoctor']);
Route::get('/major', [DoctorController::class, 'getAllMajors']);

// Route::get('/Admin/getAllDoctor', [AdminDoctorController::class, 'getAllDoctors']);

Route::post('/appoinment', [AppoinmentController::class, 'appoinment']);
Route::get('/appoinment', [AppoinmentController::class, 'getAppointments']);
Route::get('/getTotalApointment', [AppoinmentController::class, 'getTotalAppointment']);
Route::post('/time', [AppoinmentController::class, 'checkTime']);



Route::get('/patient/viewListDoctors', [PatientController::class, 'viewListDoctors']);