<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;

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

Route::get('/', function () {
    return view('pages.dashboard.main_dashboard');
})->name('dashboard');

Route::prefix('/anggota')->group(function () {
    Route::get('/', [AnggotaController::class, 'index'])->name('anggota');
    Route::get('/form_tambah_anggota', [AnggotaController::class, 'formTambahAnggota'])->name('anggota.tambah');
    Route::get('/form_ubah_anggota/{anggota_id}', [AnggotaController::class, 'formUbahAnggota'])->name('anggota.ubah');

    // Proses
    Route::post('/proses_tambah_anggota/', [AnggotaController::class, 'prosesTambahData'])->name('anggota.proses_tambah');
    Route::post('/proses_ubah_anggota/', [AnggotaController::class, 'prosesUbahData'])->name('anggota.proses_ubah');
    Route::get('/proses_hapus_anggota/{anggota_id}', [AnggotaController::class, 'prosesHapusData'])->name('anggota.proses_hapus');
    Route::get('/proses_cetak_pdf', [AnggotaController::class, 'cetakDataPdf'])->name('anggota.proses_cetak_pdf');
    Route::get('/proses_cetak_excel', [AnggotaController::class, 'cetakDataExcel'])->name('anggota.proses_cetak_excel');

})->name('anggota');

Route::prefix('/buku')->group(function () {
    Route::get('/', [BukuController::class, 'index'])->name('buku');
    Route::get('/form_tambah_buku', [BukuController::class, 'formTambahBuku'])->name('buku.tambah');
    Route::get('/form_ubah_buku/{buku_id}', [BukuController::class, 'formUbahBuku'])->name('buku.ubah');
    Route::get('/form_detail_buku/{buku_id}', [BukuController::class, 'formDetailBuku'])->name('buku.detail');

    // Proses
    Route::post('/proses_tambah_buku/', [BukuController::class, 'prosesTambahData'])->name('buku.proses_tambah');
    Route::post('/proses_ubah_buku/', [BukuController::class, 'prosesUbahData'])->name('buku.proses_ubah');
    Route::get('/proses_hapus_buku/{buku_id}', [BukuController::class, 'prosesHapusData'])->name('buku.proses_hapus');
    Route::get('/proses_cetak_pdf', [BukuController::class, 'cetakDataPdf'])->name('buku.proses_cetak_pdf');
    Route::get('/proses_cetak_excel', [BukuController::class, 'cetakDataExcel'])->name('buku.proses_cetak_excel');

})->name('buku');

Route::prefix('/laporan')->group(function () {
    Route::get('/', [BukuController::class, 'laporanBuku'])->name('laporan');
    Route::get('/form_detail_laporan/{buku_id}', [BukuController::class, 'formDetailLaporan'])->name('laporan.detail');
})->name('laporan');

// Route::prefix('/anggota')->group(function () {
//     // Route API Handle form anggota
//     Route::get('/', [AnggotaController::class, 'index'])->name('anggota');
//     Route::get('/tambah', [AnggotaController::class, 'formTambah'])->name('anggota.tambah');
//     Route::get('/ubah/{mhs_id}', [AnggotaController::class, 'formUbah'])->name('anggota.ubah');

//     // Route API CRUD
//     Route::post('/api-tambah/', [AnggotaController::class, 'tambahData'])->name('anggota.api-tambah');
//     Route::post('/api-ubah/', [AnggotaController::class, 'ubahData'])->name('anggota.api-ubah');
//     Route::get('/api-hapus/{mhs_id}', [AnggotaController::class, 'hapusData'])->name('anggota.api-hapus');
//     Route::get('/api-cetak-pdf', [AnggotaController::class, 'cetakDataPdf'])->name('anggota.api-cetak-pdf');
//     Route::get('/api-cetak-excel', [AnggotaController::class, 'cetakDataExcel'])->name('anggota.api-cetak-excel');
// });
