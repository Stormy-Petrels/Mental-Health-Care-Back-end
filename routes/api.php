<?php

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patient\SignUpController;
<<<<<<< HEAD
=======
use App\Http\Controllers\Common\SignInController;
use App\Http\Controllers\Doctor\DoctorController;
>>>>>>> 3c9a36611aedf3d1b4d6c78b96466b59178a6182

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
<<<<<<< HEAD
=======
Route::post("/sign-in",  [SignInController::class, 'signIn']); 
Route::post("/doctor/profile", [DoctorController::class, 'profileDoctor']);
>>>>>>> 3c9a36611aedf3d1b4d6c78b96466b59178a6182
