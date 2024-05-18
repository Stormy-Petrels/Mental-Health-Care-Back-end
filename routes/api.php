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
      
        // Route::get('/search', [AdminPatientController::class, 'search']);
    });
    Route::prefix('doctors')->group(function () {
        Route::get('/', [AdminDoctorController::class, 'getAllDoctors']);
        Route::post('/create', [AdminDoctorController::class, 'createDoctor']);
        // Route::put('{user_id}/update', [AdminPatientController::class, 'update'])->name('update.patient');
        // Route::get('/search', [AdminPatientController::class, 'search']);
    });
    
});
Route::post("/sign-up",  [SignUpController::class, 'signUp']); 
Route::post("/sign-in",  [SignInController::class, 'signIn']); 
Route::post("/sign-up",  [SignUpController::class, 'signUp']);

Route::get('/detail/{id}', [PatientController::class, 'ViewInformationDoctor']);

Route::get('/profile/{id}', [PatientController::class, 'profilePatient']);
Route::post('/profile/{id}', [PatientController::class, 'updateProfilePatient']);

Route::post("/doctor/profile", [DoctorController::class, 'profileDoctor']);
Route::get("/doctor/profile/{id}", [DoctorController::class, 'profileDoctor']);
Route::post('/updateProfile/doctor/{id}', [DoctorController::class, 'updateProfileDoctor']);

Route::get('/Admin/getAllDoctor', [AdminDoctorController::class, 'getAllDoctors']);

Route::post('/Doctor/update/healthCondition/{id}', [DoctorController::class, 'updateHealthCondition']);

Route::post('/appoinment', [AppoinmentController::class, 'appoinment']);
Route::post('/time', [AppoinmentController::class, 'checkTime']);


Route::post('/Admin/Update/Status/Active/{id}', [AdminController::class, 'updateStatusUsersActive']);
Route::post('/Admin/Update/Status/Block/{id}', [AdminController::class, 'updateStatusUsersInactive']);
Route::get('/Patient/viewListDoctors', [PatientController::class, 'viewListDoctors']);
