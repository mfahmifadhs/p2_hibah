<?php

use App\Http\Controllers\AadbController;
use App\Http\Controllers\AlokasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\DonorUkerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\JenisHibahController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PencairanController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\RealisasiController;
use App\Http\Controllers\TimkerController;
use App\Http\Controllers\UkerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtamaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('login', [AuthController::class, 'post'])->name('login.post');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');


Route::group(['middleware' => 'auth'], function () {
    Route::get('home',                  [HomeController::class, 'index'])->name('home');
    Route::get('dashboard',             [DashboardController::class, 'index'])->name('dashboard');
    Route::get('users/select',          [UserController::class, 'select'])->name('users.select');
    Route::get('users/detail/{id}',     [UserController::class, 'detail'])->name('users.detail');
    Route::get('users/create',          [UserController::class, 'create'])->name('users.create');
    Route::get('users/edit/{id}',       [UserController::class, 'edit'])->name('users.edit');
    Route::get('users/delete/{id}',     [UserController::class, 'delete'])->name('users.delete');

    Route::post('users/store',          [UserController::class, 'store'])->name('users.store');
    Route::post('users/update/{id}',    [UserController::class, 'update'])->name('users.update');

    Route::get('pegawai/json',          [PegawaiController::class, 'json'])->name('pegawai.json');
    Route::get('pegawai/select',        [PegawaiController::class, 'select'])->name('pegawai.select');
    Route::get('pegawai/create',        [PegawaiController::class, 'create'])->name('pegawai.create');
    Route::get('pegawai/detail/{id}',   [PegawaiController::class, 'detail'])->name('pegawai.detail');
    Route::get('pegawai/delete/{id}',   [PegawaiController::class, 'delete'])->name('pegawai.delete');
    Route::get('pegawai/json/{id}',     [PegawaiController::class, 'get'])->name('pegawai.get');
    Route::get('pegawai/edit/{id}',     [PegawaiController::class, 'edit'])->name('pegawai.edit');

    Route::post('pegawai/store',        [PegawaiController::class, 'store'])->name('pegawai.store');
    Route::put('pegawai/update/{id}',   [PegawaiController::class, 'update'])->name('pegawai.update');

    Route::group(['prefix' => 'proyek', 'as' => 'proyek.'], function () {
        Route::get('show',              [ProyekController::class, 'show'])->name('show');
        Route::get('select',            [ProyekController::class, 'select'])->name('select');
        Route::get('create',            [ProyekController::class, 'create'])->name('create');
        Route::get('verif/{id}',        [ProyekController::class, 'verif'])->name('verif');
        Route::get('detail/{id}',       [ProyekController::class, 'detail'])->name('detail');
        Route::get('edit/{id}',         [ProyekController::class, 'edit'])->name('edit');
        Route::post('update/{id}',      [ProyekController::class, 'update'])->name('update');
        Route::post('store',            [ProyekController::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'kegiatan', 'as' => 'kegiatan.'], function () {
        Route::get('show',         [KegiatanController::class, 'show'])->name('show');
        Route::get('select',       [KegiatanController::class, 'select'])->name('select');
        Route::get('create/{id}',  [KegiatanController::class, 'create'])->name('create');
        Route::get('detail/{id}',  [KegiatanController::class, 'detail'])->name('detail');
        Route::get('review/{id}',  [KegiatanController::class, 'review'])->name('review');
        Route::get('edit/{id}',    [KegiatanController::class, 'edit'])->name('edit');
        Route::get('delete/{id}',  [KegiatanController::class, 'delete'])->name('delete');
        Route::get('verif/{id}',   [KegiatanController::class, 'verif'])->name('verif');
        Route::post('update/{id}', [KegiatanController::class, 'update'])->name('update');
        Route::post('store',       [KegiatanController::class, 'store'])->name('store');
        Route::post('upload',      [KegiatanController::class, 'upload'])->name('upload');
    });

    Route::group(['prefix' => 'realisasi', 'as' => 'realisasi.'], function () {
        Route::get('create/{id}',  [RealisasiController::class, 'create'])->name('create');
        Route::get('detail/{id}',  [RealisasiController::class, 'detail'])->name('detail');
        Route::get('edit/{id}',    [RealisasiController::class, 'edit'])->name('edit');
        Route::post('store',       [RealisasiController::class, 'store'])->name('store');
        Route::post('update/{id}', [RealisasiController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'pencairan', 'as' => 'pencairan.'], function () {
        Route::get('show',          [PencairanController::class, 'show'])->name('show');
        Route::get('select',        [PencairanController::class, 'select'])->name('select');
        Route::get('create/{id}',   [PencairanController::class, 'create'])->name('create');
        Route::get('detail/{id}',   [PencairanController::class, 'detail'])->name('detail');
        Route::get('edit/{id}',     [PencairanController::class, 'edit'])->name('edit');
        Route::get('delete/{id}',   [PencairanController::class, 'delete'])->name('delete');
        Route::get('lampiran/{id}', [PencairanController::class, 'lampiran'])->name('lampiran');
        Route::get('verif/{id}',    [PencairanController::class, 'verif'])->name('verif');
        Route::post('store',        [PencairanController::class, 'store'])->name('store');
        Route::post('update/{id}',  [PencairanController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'pengadaan', 'as' => 'pengadaan.'], function () {
        Route::get('show',              [PengadaanController::class, 'show'])->name('show');
        Route::get('matriks',           [PengadaanController::class, 'matriks'])->name('matriks');
        Route::get('select',            [PengadaanController::class, 'select'])->name('select');
        Route::get('create',            [PengadaanController::class, 'create'])->name('create');
        Route::get('edit/{id}',         [PengadaanController::class, 'edit'])->name('edit');
        Route::get('detail/{id}',       [PengadaanController::class, 'detail'])->name('detail');
        Route::get('delete/{id}',       [PengadaanController::class, 'delete'])->name('delete');
        Route::post('store',            [PengadaanController::class, 'store'])->name('store');
        Route::post('update/{id}',      [PengadaanController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'alokasi', 'as' => 'alokasi.'], function () {
        Route::get('show',              [AlokasiController::class, 'show'])->name('show');
        Route::post('store/{id}',       [AlokasiController::class, 'store'])->name('store');
        Route::post('update/{id}',      [AlokasiController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'donor-uker', 'as' => 'donor-uker.'], function () {
        Route::get('show',              [DonorUkerController::class, 'show'])->name('show');
        Route::get('delete/{id}',       [DonorUkerController::class, 'delete'])->name('delete');
        Route::post('store',            [DonorUkerController::class, 'store'])->name('store');
        Route::post('update/{id}',      [DonorUkerController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'donor', 'as' => 'donor.'], function () {
        Route::get('show',              [DonorController::class, 'show'])->name('show');
        Route::post('store',            [DonorController::class, 'store'])->name('store');
        Route::post('update/{id}',      [DonorController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'jenisHibah', 'as' => 'jenisHibah.'], function () {
        Route::get('show',              [JenisHibahController::class, 'show'])->name('show');
        Route::post('store',            [JenisHibahController::class, 'store'])->name('store');
        Route::post('update/{id}',      [JenisHibahController::class, 'update'])->name('update');
    });

    Route::group(['middleware' => ['access:master']], function () {
        Route::get('users',   [UserController::class, 'show'])->name('users');
        Route::get('pegawai', [PegawaiController::class, 'show'])->name('pegawai');
    });
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('jabatan',              [JabatanController::class, 'show'])->name('jabatan');
    Route::post('jabatan/update/{id}', [JabatanController::class, 'update'])->name('jabatan.update');

    Route::get('utama',                [UtamaController::class, 'show'])->name('utama');
    Route::post('utama/update/{id}',   [UtamaController::class, 'update'])->name('utama.update');

    Route::get('uker',                 [UkerController::class, 'show'])->name('uker');
    Route::get('uker/timker/{id}',     [UkerController::class, 'timker'])->name('uker.timker');
    Route::post('uker/update/{id}',    [UkerController::class, 'update'])->name('uker.update');

    Route::get('timker',               [TimkerController::class, 'show'])->name('timker');
    Route::post('timker/store',        [TimkerController::class, 'store'])->name('timker.store');
    Route::post('timker/update/{id}',  [TimkerController::class, 'update'])->name('timker.update');
});
