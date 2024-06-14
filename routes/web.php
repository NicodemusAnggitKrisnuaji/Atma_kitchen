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
use App\Http\Controllers\DetailHampersController;
use App\Http\Controllers\DetailResepController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\DetailProdukController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\KonfirmasiSaldoController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\TipController;
use App\Http\Controllers\PengirimanController;
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

Route::get('catalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('detailCake', [DetailProdukController::class, 'detailCake'])->name('detailCake');
Route::get('detailRoti', [DetailProdukController::class, 'detailRoti'])->name('detailRoti');
Route::get('detailMinuman', [DetailProdukController::class, 'detailMinuman'])->name('detailMinuman');
Route::get('detailTitipan', [DetailProdukController::class, 'detailTitipan'])->name('detailTitipan');
Route::get('detailHampers', [DetailProdukController::class, 'detailHampers'])->name('detailHampers');

Route::get('/pemesanan/{id}', [PemesananController::class, 'show'])->name('pemesanan');
Route::get('/pemesanan/{id}/addToCart', [PemesananController::class, 'addToCart'])->name('produk.addToCart');

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

Route::middleware(['auth', 'role:Customer'])->group(function () {
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('OrderHistory', [ProfileController::class, 'history'])->name('OrderHistory');
    Route::get('profile/edit/{id}', [ProfileController::class, 'editProfile'])->name('editProfile');
    Route::put('profile/update/{id}', [ProfileController::class, 'updateProfile'])->name('updateProfile');

    Route::get('homeCustomer', [HomePageController::class, 'homeCustomer'])->name('homeCustomer');
    Route::get('productview/{id}', [HomePageController::class, 'productview'])->name('productview');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart.add', [PemesananController::class, 'addToCart'])->name('cart.add');
    Route::delete('cart.destroy/{id}', [CartController:: class, 'destroy'])->name('cart.destroy');

    Route::get('pembayaran', [CartController::class, 'tampilkanPesananBelumDibayar'])->name('pembayaran');
    Route::post('butki/{id}', [CartController::class, 'kirimBuktiPembayaran'])->name('bukti');

    Route::get('penerimaan', [PemesananController::class, 'showCompletedOrders'])->name('orders.status');
    Route::put('penerimaan/{id}', [PemesananController::class, 'updateCompletedOrders'])->name('orders.updateCompletedOrders');
    
});

Route::middleware(['auth', 'role:Owner'])->group(function () {
    Route::get('profileOwner', [ProfileController::class, 'index'])->name('profileOwner');
    Route::get('profile/editProfileOwner/{id}', [ProfileController::class, 'editProfileOwner'])->name('editProfileOwner');
    Route::put('profile/updateProfileOwner/{id}', [ProfileController::class, 'updateProfileOwner'])->name('updateProfileOwner');

    Route::get('gaji.edit/{id}', [GajiBonusController::class, 'edit'])->name('gaji.edit');
    Route::get('gaji', [GajiBonusController::class, 'index'])->name('gaji');
    Route::put('gaji.update/{id}', [GajiBonusController::class, 'update'])->name('gaji.update');

    Route::get('PresensiDanGajiOwner', [LaporanController::class, 'PresensiDanGajiOwner'])->name('PresensiDanGajiOwner');
    Route::get('download-pdf', [LaporanController::class, 'downloadPdf'])->name('download_pdf');

    Route::get('PemasukanDanPengeluaranOwner', [LaporanController::class, 'PemasukanDanPengeluaranOwner'])->name('PemasukanDanPengeluaranOwner');
    Route::get('download-pdf', [LaporanController::class, 'downloadPdf'])->name('download_pdf');

    Route::get('PenitipRecapOwner', [LaporanController::class, 'PenitipRecapOwner'])->name('PenitipRecapOwner');

    Route::get('laporanOwner', [LaporanController::class, 'cetakLaporanBulananOwner'])->name('laporanOwner');
    Route::get('/laporan/penjualan-bulanan', [LaporanController::class, 'LaporanPenjualanBulananPerProdukOwner'])->name('laporan.penjualan-bulanan');
    Route::get('/laporan/generate-pdf', [LaporanController::class, 'generatePDFLaporanPenjualanOwner'])->name('laporan.generate-pdf');

    Route::get('laporanStokBahanBaku', [LaporanController::class, 'cetakLaporanStokBahanBakuOwner'])->name('laporanStokBahanBaku');
    Route::get('laporanStokBahanBaku-pdf', [LaporanController::class, 'generatePDFLaporanStokBahanBakuOwner'])->name('generatePDFLaporanStokBahanBaku');

    Route::get('laporan', [LaporanController::class, 'cetakForm'])->name('laporan');
    Route::get('laporan/cetakLaporanTabel/{tahun}', [LaporanController::class, 'cetakLaporanPenjualanPertahun'])->name('cetakLaporanPenjualanPertahun');
    Route::get('laporan/cetakLaporanForm', [LaporanController::class, 'cetakForm'])->name('cetakLaporanForm');

    Route::get('laporanBahanBaku', [LaporanController::class, 'cetakFormBahanBaku'])->name('laporanBahanBaku');
    Route::get('laporanBahanBaku/cetakLaporanBahanBakuTabel/{tglawal}/{tglakhir}', [LaporanController::class, 'cetakLaporanBahanBaku'])->name('cetakLaporanBahanBaku');
    Route::get('laporanBahanBaku/cetakLaporanBahanBakuForm', [LaporanController::class, 'cetakFormBahanBaku'])->name('cetakLaporanBahanBakuForm');
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

    Route::get('/orders', [PemesananController::class, 'index'])->name('orders.index');
    Route::put('/orders/{id}', [PemesananController::class, 'update'])->name('orders.update');
    Route::get('/orders/material-list', [PemesananController::class, 'showMaterialList'])->name('orders.material-list');

    Route::put('status/{id}', [CartController::class, 'updateStatus'])->name('status');

    Route::get('PresensiDanGaji', [LaporanController::class, 'PresensiDanGaji'])->name('PresensiDanGaji');
    Route::get('download-pdf', [LaporanController::class, 'downloadPdf'])->name('download_pdf');

    Route::get('PemasukanDanPengeluaran', [LaporanController::class, 'PemasukanDanPengeluaran'])->name('PemasukanDanPengeluaran');
    Route::get('download-pdf', [LaporanController::class, 'downloadPdf'])->name('download_pdf');

    Route::get('PenitipRecap', [LaporanController::class, 'PenitipRecap'])->name('PenitipRecap');

    Route::get('/accepted', [PemesananController::class, 'showAcceptedOrders'])->name('orders.accepted');
    Route::put('/accepted/{id}', [PemesananController::class, 'updateAcceptedOrders'])->name('orders.acceptedUpdate');

    Route::get('/material.usage', [PemesananController::class, 'showMaterialUsage'])->name('material.usage');

    Route::get('laporanMO', [LaporanController::class, 'cetakLaporanBulananMO'])->name('laporanMO');
    Route::get('/laporan/penjualan-bulananMO', [LaporanController::class, 'LaporanPenjualanBulananPerProdukMO'])->name('laporan.penjualan-bulananMO');
    Route::get('/laporan/generate-pdfMO', [LaporanController::class, 'generatePDFLaporanPenjualanMO'])->name('laporan.generate-pdfMO');

    Route::get('laporanStokBahanBakuMO', [LaporanController::class, 'cetakLaporanStokBahanBakuMO'])->name('laporanStokBahanBakuMO');
    Route::get('laporanStokBahanBaku-pdfMO', [LaporanController::class, 'generatePDFLaporanStokBahanBakuMO'])->name('generatePDFLaporanStokBahanBakuMO');

    Route::get('laporanMO', [LaporanController::class, 'cetakFormMO'])->name('laporanMO');
    Route::get('laporan/cetakLaporanTabelMO/{tahun}', [LaporanController::class, 'cetakLaporanPenjualanPertahunMO'])->name('cetakLaporanPenjualanPertahunMO');
    Route::get('laporan/cetakLaporanFormMO', [LaporanController::class, 'cetakFormMO'])->name('cetakLaporanFormMO');

    Route::get('laporanBahanBakuMO', [LaporanController::class, 'cetakFormBahanBakuMO'])->name('laporanBahanBakuMO');
    Route::get('laporanBahanBaku/cetakLaporanBahanBakuTabelMO/{tglawal}/{tglakhir}', [LaporanController::class, 'cetakLaporanBahanBakuMO'])->name('cetakLaporanBahanBakuMO');
    Route::get('laporanBahanBaku/cetakLaporanBahanBakuFormMO', [LaporanController::class, 'cetakFormBahanBakuMO'])->name('cetakLaporanBahanBakuFormMO');

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

    Route::get('detail_hampers.create/{id}', [DetailHampersController::class, 'create'])->name('detail_hampers.create');
    Route::post('detail_hampers.store/{id}', [DetailHampersController::class, 'store'])->name('detail_hampers.store');
    Route::get('detail_hampers.edit/{id}', [DetailHampersController::class, 'edit'])->name('detail_hampers.edit');
    Route::get('detail_hampers/{id}', [DetailHampersController::class, 'index'])->name('detail_hampers');
    Route::put('detail_hampers.update/{id}', [DetailHampersController::class, 'update'])->name('detail_hampers.update');
    Route::delete('detail_hampers.destroy/{id}', [DetailHampersController::class, 'destroy'])->name('detail_hampers.destroy');

    Route::get('detail_resep.create/{id}', [DetailResepController::class, 'create'])->name('detail_resep.create');
    Route::post('detail_resep.store/{id}', [DetailResepController::class, 'store'])->name('detail_resep.store');
    Route::get('detail_resep.edit/{id}', [DetailResepController::class, 'edit'])->name('detail_resep.edit');
    Route::get('detail_resep/{id}', [DetailResepController::class, 'index'])->name('detail_resep');
    Route::put('detail_resep.update/{id}', [DetailResepController::class, 'update'])->name('detail_resep.update');
    Route::delete('detail_resep.destroy/{id}', [DetailResepController::class, 'destroy'])->name('detail_resep.destroy');

    Route::get('searchCus', [SearchCustomerController::class, 'index'])->name('searchCus');
    Route::get('searchCus.show/{id}', [SearchCustomerController::class, 'show'])->name('searchCus.show');

    Route::get('pengiriman.create', [PengirimanController::class, 'create'])->name('pengiriman.create');
    Route::post('pengiriman.store', [PengirimanController::class, 'store'])->name('pengiriman.store');
    Route::get('pengiriman.edit/{id}', [PengirimanController::class, 'edit'])->name('pengiriman.edit');
    Route::get('pengiriman', [PengirimanController::class, 'index'])->name('pengiriman');
    Route::put('pengiriman.update/{id}', [PengirimanController::class, 'update'])->name('pengiriman.update');
    Route::delete('pengiriman.destroy/{id}', [PengirimanController::class, 'destroy'])->name('pengiriman.destroy');

    Route::get('tip.create', [TipController::class, 'create'])->name('tip.create');
    Route::post('tip.store', [TipController::class, 'store'])->name('tip.store');
    Route::get('tip', [TipController::class, 'index'])->name('tip');

    Route::get('PenarikanSaldo', [KonfirmasiSaldoController::class, 'PenarikanSaldo'])->name('PenarikanSaldo');
    Route::put('ConfirmTransfer/{id}', [KonfirmasiSaldoController::class, 'ConfirmTransfer'])->name('ConfirmTransfer');

    Route::get('status', [PemesananController::class, 'statusIndex'])->name('orders.status');
    Route::put('/status/{id}', [PemesananController::class, 'statusUpdate'])->name('orders.statusUpdate');

    Route::get('pembatalan', [PemesananController::class, 'latePaymentsIndex'])->name('orders.pembatalan');
    Route::put('/pembatalan/{id}', [PemesananController::class, 'latePaymentsUpdate'])->name('orders.latePaymentsUpdate');
});

Route::get('logout', [LoginController::class, 'actionLogout'])->name('actionLogout')->middleware('auth');
