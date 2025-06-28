<?php

use App\Http\Controllers\PembayaranController as ControllersPembayaranController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\LapanganController;
use App\Http\Controllers\User\PesananController;
use App\Http\Controllers\User\PembayaranController;
use App\Http\Controllers\User\BookingController;

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

//halaman pertama kali di baca
Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


//halaman dashboard user muncul setelah login di bagian ini , begitu pula jika ingin tambahkan halaman lain
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/lapangan', [LapanganController::class, 'index'])->name('user.lapangan');
    Route::get('/pesanan', [PesananController::class, 'index'])->name('user.pesanan');
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('user.pembayaran');
Route::post('/pembayaran', [PembayaranController::class, 'store']);

});

Route::middleware(['auth'])->group(function () {
    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
});


//tidak perlu di apa apakan
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
