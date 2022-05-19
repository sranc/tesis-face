<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::get('users', [UserController::class, 'index']);
// Route::get('users/{user}', [UserController::class, 'show']);
// Route::post('users', [UserController::class, 'store']);
// Route::put('users/{user}', [UserController::class, 'update']);
// Route::delete('users/{user}', [UserController::class, 'delete']);

Route::post('login', [UserController::class, 'authenticate']);

Route::group(['middleware' => ['jwt.verify']], function () {
 // Add new user
 Route::post('users', [UserController::class, 'register']);
//  get list of users
 Route::get('users', [UserController::class, 'index']);
//  update the selected user
 Route::put('users/{user}', [UserController::class, 'update']);
//  delete the selected user
 Route::delete('users/{user}', [UserController::class, 'delete']);
//  get the authenticated user
 Route::get('user', [UserController::class, 'getAuthenticatedUser']);
 Route::get('refreshToken', [UserController::class, 'refreshToken']);
 Route::get('logout', [UserController::class, 'logout']);

 Route::get('registers', [RegisterController::class, 'index']);
 Route::get('registers/{register}', [RegisterController::class, 'show']);
 Route::post('registers', [RegisterController::class, 'store']);
 Route::put('registers/{register}', [RegisterController::class, 'update']);
 Route::delete('registers/{register}', [RegisterController::class, 'delete']);
});
