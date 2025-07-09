<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerenangController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\PrediksiController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('beranda');
});

// Rute yang membutuhkan autentikasi
Route::middleware('auth')->group(function () {
    // Halaman beranda
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');

    // Form tambah data perenang
    Route::get('/perenang/tambah', [PerenangController::class, 'create'])->name('perenang.create');

    // Proses simpan data perenang
    Route::post('/perenang/simpan', [PerenangController::class, 'store'])->name('perenang.store');

    // Logout juga bisa ditaruh di sini jika mau
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/perenang/{id}/prediksi', [PerenangController::class, 'prediksi'])->name('perenang.prediksi');

    // Route untuk MENAMPILKAN halaman prediksi berdasarkan ID atlet yang diklik dari beranda
    // URL yang dihasilkan: /prediksi/1, /prediksi/2, dst.
    Route::get('/prediksi/{id}', [PrediksiController::class, 'show'])->name('prediksi.show');

    // Route untuk MEMPROSES hasil form prediksi
    Route::post('/prediksi/calculate', [PrediksiController::class, 'calculate'])->name('prediksi.calculate');

    // Route untuk history
    Route::get('/perenang/{id}/historyprediksi', [PrediksiController::class, 'showPredictionHistory'])->name('perenang.prediksi.history');
});

//post
Route::post('/login', [AuthController::class, 'login'])->name('login.post'); 

Route::get('/login', [AuthController::class, 'index'])->name('login');
// Rute untuk logout (harus POST request, bisa dari form atau AJAX)

// Route::get('/', function () {
//     // Arahkan halaman utama ke form tambah untuk sementara
//     return redirect()->route('perenang.create');
// });


