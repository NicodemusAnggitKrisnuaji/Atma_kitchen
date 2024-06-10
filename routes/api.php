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
use App\Http\Controllers\SaldoCustomerApiController;
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

// Route untuk login
Route::post('/login', [LoginApiController::class, 'login']);

// Route untuk tarik saldo
Route::post('/tarik-saldo/{id}', [SaldoCustomerApiController::class, 'tarikSaldo']);


// Route untuk riwayat penarikan saldo
Route::get('/withdrawal-history/{id}', [SaldoCustomerApiController::class, 'withdrawalHistory']);
