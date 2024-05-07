<?php

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patient\SignUpController;
use App\Http\Controllers\Admin\AdminPatientController;
use App\Http\Controllers\AdminPatientController as ControllersAdminPatientController;
use App\Http\Controllers\Common\SignInController;

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
    Route::get('/', [ControllersAdminPatientController::class, 'dashboard']);

    Route::prefix('patients')->group(function () {
        Route::get('/', [ControllersAdminPatientController::class, 'getAllPatients']);
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