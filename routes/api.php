<?php

use Illuminate\Http\Request;
use App\helpers\ResponseHelper;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CompanyController;
use App\Http\Controllers\api\EmployeeController;
use App\Http\Controllers\api\ProfileController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/test', function(){
//     return 'hello';
// });

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware(['auth:api'])->group(function(){

    //profile
    Route::get('profile', [ProfileController::class, 'profile']);

    //logout
    Route::post('logout', [AuthController::class, 'logout']);

     //Company
     Route::get('/company', [CompanyController::class, 'index']);
     Route::post('/company', [CompanyController::class, 'store']);
     Route::put('/company/{id}/update', [CompanyController::class, 'update']);
     Route::get('/company/{id}', [CompanyController::class, 'show']);
     Route::get('/company/{id}/delete', [CompanyController::class, 'destroy']);

     //Employee
     Route::get('/employee', [EmployeeController::class, 'index']);
     Route::post('/employee', [EmployeeController::class, 'store']);
     Route::get('/employee/{id}', [EmployeeController::class, 'show']);
     Route::put('/employee/{id}/update', [EmployeeController::class, 'update']);
     Route::get('/employee/{id}/delete', [EmployeeController::class, 'destroy']);


});







