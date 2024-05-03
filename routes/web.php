<?php

use App\Http\Controllers\HomePageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PenitipController;
use App\Http\Controllers\HampersController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\SearchCustomerController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PembelianBahanBakuController;
use App\Http\Controllers\PencatatanPengeluaranController;
use App\Http\Controllers\GajiBonusController;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [HomePageController::class, 'index'])->name('homePage');
Route::get('home', [HomePageController::class, 'index'])->name('home');

Route::get('login', [LoginController::class, 'page'])->name('login');
Route::post('actionLogin', [LoginController::class, 'actionLogin'])->name('actionLogin');


Route::get('register', [RegisterController::class, 'register'])->name('register');
Route::post('actionRegister', [RegisterController::class, 'actionRegister'])->name('actionRegister');

Route::get('/forgot-password', function () {
    return view('contentCustomer.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );
 
    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
  
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('contentCustomer.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);
 
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));
 
            $user->save();
 
            event(new PasswordReset($user));
        }
    );
 
    return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');


// Route::get('forgotPassword', 'LoginController@showForgotPasswordForm')->name('password.request');
// Route::post('forgotPassword', 'LoginController@sendResetLinkEmail')->name('password.email');

Route::middleware(['auth', 'role:Customer'])->group(function () {
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');

    Route::get('OrderHistory', [ProfileController::class, 'history'])->name('OrderHistory');
    Route::get('profile/edit/{id}', [ProfileController::class, 'editProfile'])->name('editProfile');
    Route::put('profile/update/{id}', [ProfileController::class, 'updateProfile'])->name('updateProfile');
    Route::get('homeCustomer', [HomePageController::class, 'homeCustomer'])->name('homeCustomer');
});

Route::middleware(['auth', 'role:Owner'])->group(function () {
    Route::get('profileOwner', [ProfileController::class, 'index'])->name('profileOwner');
    Route::get('profile/editProfileOwner/{id}', [ProfileController::class, 'editProfileOwner'])->name('editProfileOwner');
    Route::put('profile/updateProfileOwner/{id}', [ProfileController::class, 'updateProfileOwner'])->name('updateProfileOwner');


    Route::get('gaji.edit/{id}', [GajiBonusController::class, 'edit'])->name('gaji.edit');
    Route::get('gaji', [GajiBonusController::class, 'index'])->name('gaji');
    Route::put('gaji.update/{id}', [GajiBonusController::class, 'update'])->name('gaji.update');
});

Route::middleware(['auth', 'role:MO'])->group(function () {
    Route::get('profileMO', [ProfileController::class, 'index'])->name('profileMO');
    Route::get('profile/editProfileMo/{id}', [ProfileController::class, 'editProfileMO'])->name('editProfileMO');
    Route::put('profile/updateProfileMO/{id}', [ProfileController::class, 'updateProfileMO'])->name('updateProfileMO');

    Route::get('karyawan.create', [KaryawanController::class, 'create'])->name('karyawan.create');
    Route::post('karyawan.store', [KaryawanController::class, 'store'])->name('karyawan.store');
    Route::get('karyawan.edit/{id}', [KaryawanController::class, 'edit'])->name('karyawan.edit');
    Route::get('karyawan', [KaryawanController::class, 'index'])->name('karyawan');
    Route::put('karyawan.update/{id}', [KaryawanController::class, 'update'])->name('karyawan.update');
    Route::delete('karyawan.destroy/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');

    Route::get('penitip.create', [PenitipController::class, 'create'])->name('penitip.create');
    Route::post('penitip.store', [PenitipController::class, 'store'])->name('penitip.store');
    Route::get('penitip.edit/{id}', [PenitipController::class, 'edit'])->name('penitip.edit');
    Route::get('penitip', [PenitipController::class, 'index'])->name('penitip');
    Route::put('penitip.update/{id}', [PenitipController::class, 'update'])->name('penitip.update');
    Route::delete('penitip.destroy/{id}', [PenitipController::class, 'destroy'])->name('penitip.destroy');

    
    Route::get('pembelian.create', [PembelianBahanBakuController::class, 'create'])->name('pembelian.create');
    Route::post('pembelian.store', [PembelianBahanBakuController::class, 'store'])->name('pembelian.store');
    Route::get('pembelian.edit/{id}', [PembelianBahanBakuController::class, 'edit'])->name('pembelian.edit');
    Route::get('pembelian', [PembelianBahanBakuController::class, 'index'])->name('pembelian');
    Route::put('pembelian.update/{id}', [PembelianBahanBakuController::class, 'update'])->name('pembelian.update');
    Route::delete('pembelian.destroy/{id}', [PembelianBahanBakuController::class, 'destroy'])->name('pembelian.destroy');

    Route::get('pencatatan.create', [PencatatanPengeluaranController::class, 'create'])->name('pencatatan.create');
    Route::post('pencatatan.store', [PencatatanPengeluaranController::class, 'store'])->name('pencatatan.store');
    Route::get('pencatatan.edit/{id}', [PencatatanPengeluaranController::class, 'edit'])->name('pencatatan.edit');
    Route::get('pencatatan', [PencatatanPengeluaranController::class, 'index'])->name('pencatatan');
    Route::put('pencatatan.update/{id}', [PencatatanPengeluaranController::class, 'update'])->name('pencatatan.update');
    Route::delete('pencatatan.destroy/{id}', [PencatatanPengeluaranController::class, 'destroy'])->name('pencatatan.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('profileAdmin', [ProfileController::class, 'index'])->name('profileAdmin');
    Route::get('profile/editProfileAdmin/{id}', [ProfileController::class, 'editProfileAdmin'])->name('editProfileAdmin');
    Route::put('profile/updateProfileAdmin/{id}', [ProfileController::class, 'updateProfileAdmin'])->name('updateProfileAdmin');

    Route::get('produk.create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('produk.store', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('produk.edit/{id}', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::get('produk', [ProdukController::class, 'index'])->name('produk');
    Route::put('produk.update/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('produk.destroy/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    Route::get('resep.create', [ResepController::class, 'create'])->name('resep.create');
    Route::post('resep.store', [ResepController::class, 'store'])->name('resep.store');
    Route::get('resep.edit/{id}', [ResepController::class, 'edit'])->name('resep.edit');
    Route::get('resep', [ResepController::class, 'index'])->name('resep');
    Route::put('resep.update/{id}', [ResepController::class, 'update'])->name('resep.update');
    Route::delete('resep.destroy/{id}', [ResepController::class, 'destroy'])->name('resep.destroy');

    Route::get('bahanBaku.create', [BahanBakuController::class, 'create'])->name('bahanBaku.create');
    Route::post('bahanBaku.store', [BahanBakuController::class, 'store'])->name('bahanBaku.store');
    Route::get('bahanBaku.edit/{id}', [BahanBakuController::class, 'edit'])->name('bahanBaku.edit');
    Route::get('bahanBaku', [BahanBakuController::class, 'index'])->name('bahanBaku');
    Route::put('bahanBaku.update/{id}', [BahanBakuController::class, 'update'])->name('bahanBaku.update');
    Route::delete('bahanBaku.destroy/{id}', [BahanBakuController::class, 'destroy'])->name('bahanBaku.destroy');

    Route::get('hampers.create', [HampersController::class, 'create'])->name('hampers.create');
    Route::post('hampers.store', [HampersController::class, 'store'])->name('hampers.store');
    Route::get('hampers.edit/{id}', [HampersController::class, 'edit'])->name('hampers.edit');
    Route::get('hampers', [HampersController::class, 'index'])->name('hampers');
    Route::put('hampers.update/{id}', [HampersController::class, 'update'])->name('hampers.update');
    Route::delete('hampers.destroy/{id}', [HampersController::class, 'destroy'])->name('hampers.destroy');

    Route::get('searchCus', [SearchCustomerController::class, 'index'])->name('searchCus');
    Route::get('searchCus.show/{id}', [SearchCustomerController::class, 'show'])->name('searchCus.show');
});

Route::get('logout', [LoginController::class, 'actionLogout'])->name('actionLogout')->middleware('auth');
