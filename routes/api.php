<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\api\LoginController;
use App\Http\Controllers\LoginApiController;
use Spatie\FlareClient\Api;

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

Route::post('/login', [LoginApiController::class, 'login']);

Route::post('/forgotPassword', [LoginApiController::class, 'forgotPassword']);
Route::get('/reset-password/{token}', function (string $token) {
    return response()->json(['token' => $token]);
})->middleware('guest')->name('password.reset');
Route::post('/resetPassword', [LoginApiController::class, 'resetPassword']);