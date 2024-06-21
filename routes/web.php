<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RTController;
use App\Http\Controllers\LingkunganController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\PembayaranPerBulanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembayaranPerOrangController;
use App\Http\Controllers\LaporanPembayaranController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserPembayaranPerBulanController;
use App\Http\Controllers\UserPembayaranPerOrangController;
use App\Http\Controllers\UserTagihanController;
use App\Http\Controllers\StatusController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    // Kode controller untuk admin
})->middleware('role:admin');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('rts', RTController::class);
Route::resource('lingkungans', LingkunganController::class);
Route::resource('wargas', WargaController::class);


Route::get('/tagihans', [TagihanController::class, 'index'])->name('tagihans.index');
Route::get('/tagihans/create', [TagihanController::class, 'create'])->name('tagihans.create');
Route::post('/tagihans', [TagihanController::class, 'store'])->name('tagihans.store');
Route::get('/tagihans/{tagihan}/edit', [TagihanController::class, 'edit'])->name('tagihans.edit');
Route::put('/tagihans/{tagihan}', [TagihanController::class, 'update'])->name('tagihans.update');
Route::delete('/tagihans/{tagihan}', [TagihanController::class, 'destroy'])->name('tagihans.destroy');

Route::get('/tagihans/export', [TagihanController::class, 'export'])->name('tagihans.export');


// Hapus penggunaan resource untuk PembayaranController dan definisikan rute secara manual
Route::get('/pembayarans', [PembayaranPerBulanController::class, 'index'])->name('pembayarans.perbulan');
Route::get('/pembayarans/create', [PembayaranPerBulanController::class, 'create'])->name('pembayarans.create');
Route::post('/pembayarans', [PembayaranPerBulanController::class, 'store'])->name('pembayarans.store');
Route::get('/pembayarans/{pembayaran}/edit', [PembayaranPerBulanController::class, 'edit'])->name('pembayarans.edit');
Route::put('/pembayarans/{pembayaran}', [PembayaranPerBulanController::class, 'update'])->name('pembayarans.update');
Route::delete('/pembayarans/{pembayaran}', [PembayaranPerBulanController::class, 'destroy'])->name('pembayarans.destroy');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/pembayarans/get-wargas', [PembayaranPerBulanController::class, 'getWargas'])->name('pembayarans.get-wargas');
Route::get('/pembayarans/success', [PembayaranPerBulanController::class, 'success'])->name('pembayarans.success');
Route::get('/laporan_pembayaran', [LaporanPembayaranController::class, 'index'])->name('laporan_pembayaran.index');
Route::get('/pembayarans/perorang', [PembayaranPerOrangController::class, 'index'])->name('pembayarans.perorang');

Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user');
Route::get('/user', [App\Http\Controllers\UserController::class, 'dataUser'])->name('user_-_data');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard')->middleware('auth');

// Rute untuk dashboard user
Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard')->middleware('auth');

// Tambahkan route user.tagihans.index di sini
Route::get('/usertagihans/index', [TagihanController::class, 'indexUserTagihan'])->name('usertagihans.index')->middleware('auth');

// Rute untuk logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/usertagihans', [UserTagihanController::class, 'index'])->name('usertagihans.index');

Route::get('/userpembayaran/perbulan', [UserPembayaranPerBulanController::class, 'index'])->name('userpembayarans.perbulan');
Route::get('/userpembayaran/perorang', [UserPembayaranPerOrangController::class, 'index'])->name('userpembayarans.perorang');

Route::middleware('auth')->group(function () {
    Route::get('/users.index', [App\Http\Controllers\UserController::class, 'dataUser'])->name('datauser');
    Route::get('/users.edit', [App\Http\Controllers\UserController::class, 'edit'])->name('edit_datauser');
    Route::put('/users/update', [App\Http\Controllers\UserController::class, 'update'])->name('update_datauser');
    Route::delete('/users/delete', [App\Http\Controllers\UserController::class, 'delete'])->name('delete_datauser');
    });

Route::get('/pembayarans/export', [PembayaranPerBulanController::class, 'export'])->name('pembayarans.export');
Route::get('/pembayarans/perorang/export', [PembayaranPerOrangController::class, 'export'])->name('pembayarans.perorang.export');
