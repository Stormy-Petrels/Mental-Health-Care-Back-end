<?php

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patient\SignUpController;
use App\Http\Controllers\Admin\AdminPatientController;

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

Route::post("/sign-up",  [SignUpController::class, 'signUp']); // ADMIN
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminPatientController::class, 'dashboard']);

    Route::prefix('patients')->group(function () {
        Route::get('/', [AdminPatientController::class, 'getAllPatients']);
        // Route::get('/create', [AdminPatientController::class, 'create'])->name('create');
        // Route::post('/create', [AdminPatientController::class, 'store'])->name('admin.patients.store');
        // Route::get('{user_id}/update', [AdminPatientController::class, 'edit'])->name('edit.patient');
        // Route::put('{user_id}/update', [AdminPatientController::class, 'update'])->name('update.patient');
        // Route::get('{id}/delete', [AdminPatientController::class, 'destroy'])->name('delete.patient');
        // Route::get('/search', [AdminPatientController::class, 'search']);
    });
    Route::prefix('doctors')->group(function () {
        Route::get('/', [AdminDoctorController::class, 'getAllDoctors']);
        // Route::get('/create', [AdminPatientController::class, 'create'])->name('create');
        // Route::post('/create', [AdminPatientController::class, 'store'])->name('admin.patients.store');
        // Route::get('{user_id}/update', [AdminPatientController::class, 'edit'])->name('edit.patient');
        // Route::put('{user_id}/update', [AdminPatientController::class, 'update'])->name('update.patient');
        // Route::get('{id}/delete', [AdminPatientController::class, 'destroy'])->name('delete.patient');
        // Route::get('/search', [AdminPatientController::class, 'search']);
    });
    
});
Route::post("/sign-up",  [SignUpController::class, 'signUp']); 
Route::post("/sign-in",  [SignInController::class, 'signIn']); 

Route::get('/profile/{id}', [PatientController::class, 'profilePatient']);
Route::post('/profile/{id}', [PatientController::class, 'updateProfilePatient']);

Route::get("/doctor/profile/{id}", [DoctorController::class, 'profileDoctor']);
Route::post('/updateProfile/doctor', [DoctorController::class, 'updateProfileDoctor']);

// Route::get('/Admin/getAllDoctor', [AdminDoctorController::class, 'getAllDoctors']);