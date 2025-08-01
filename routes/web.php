<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\MasukController;
use App\Http\Controllers\KeluarController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeadaanController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;

// Login Page
Route::get('/', fn() => view('login'));
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login');

// Group routes that require authentication
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // Logout
    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');


    // Users (Permissions: users.view/create/update/delete)
    Route::middleware('permission:users.view')->group(function () {
        Route::resource('/users', UserController::class);
    });

    // Barang (Assuming these are used internally by Masuk/Keluar/Peminjaman actions)
    Route::prefix('barang')->name('barang.')->group(function () {
        Route::post('/', [BarangController::class, 'store'])->name('store');
        Route::put('/{id}', [BarangController::class, 'update'])->name('update');
        Route::delete('/{id}', [BarangController::class, 'destroy'])->name('destroy');
    });

    // Masuk
    Route::prefix('masuk')->name('masuk.')->middleware('permission:masuk.view')->group(function () {
        Route::get('/', [MasukController::class, 'index'])->name('index');
        Route::get('/create', [MasukController::class, 'create'])->name('create')->middleware('permission:masuk.create');
        Route::get('/edit/{barang}', [MasukController::class, 'edit'])->middleware('permission:masuk.update');
        Route::post('/import-excel', [MasukController::class, 'importFromExcel'])->name('import.excel')->middleware('permission:masuk.create');
        Route::post('/multi-edit', [MasukController::class, 'multiEdit'])->name('multi-edit');
    });

    // Keluar
    Route::prefix('keluar')->name('keluar.')->middleware('permission:keluar.view')->group(function () {
    Route::get('/', [KeluarController::class, 'index'])->name('index');
    Route::get('/{barang}/edit', [KeluarController::class, 'edit'])->name('edit')->middleware('permission:keluar.update');
    Route::post('/upload-bukti/{keluar}', [KeluarController::class, 'uploadBukti'])->name('upload-bukti')->middleware('permission:keluar.upload');
    Route::get('/download-bukti/{keluar}', [KeluarController::class, 'downloadBukti'])->name('download-bukti');
    Route::delete('/delete-bukti/{keluar}', [KeluarController::class, 'deleteBukti'])->name('delete-bukti');
    });

    // Peminjaman
    Route::prefix('peminjaman')->name('peminjaman.')->middleware('permission:peminjaman.view')->group(function () {
        Route::get('/', [PeminjamanController::class, 'index'])->name('index');
        Route::get('/edit/{barang}', [PeminjamanController::class, 'edit'])->middleware('permission:peminjaman.update');
        Route::post('/multi-edit', [PeminjamanController::class, 'multiEdit'])->name('multi-edit');
    });
    Route::get('/exportpeminjaman', [PeminjamanController::class, 'peminjamanexport'])->name('exportpeminjaman')->middleware('permission:peminjaman.view');

    // Pengaturan
    Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
        Route::get("/", [PengaturanController::class, 'index'])->name("index")->middleware('permission:pengaturan.view');

        // Merk
        Route::prefix('merk')->name("merk.")->group(function () {
            Route::get("/", [MerkController::class, 'index']);
            Route::post("/", [MerkController::class, 'store'])->name('store')->middleware('permission:pengaturan.create');
            Route::post("/update/{merk}", [MerkController::class, 'update'])->name('update')->middleware('permission:pengaturan.update');
            Route::delete("/delete/{merk}", [MerkController::class, 'destroy'])->name('delete')->middleware('permission:pengaturan.delete');
        });

        // Kategori
        Route::prefix('kategori')->name("kategori.")->group(function () {
            Route::get("/", [KategoriController::class, 'index']);
            Route::post("/", [KategoriController::class, 'store'])->name('store')->middleware('permission:pengaturan.create');
            Route::post("/update/{kategori}", [KategoriController::class, 'update'])->name('update')->middleware('permission:pengaturan.update');
            Route::delete("/delete/{kategori}", [KategoriController::class, 'destroy'])->name('delete')->middleware('permission:pengaturan.delete');
        });

        // Keadaan
        Route::prefix('keadaan')->name("keadaan.")->group(function () {
            Route::get("/", [KeadaanController::class, 'index']);
            Route::post("/", [KeadaanController::class, 'store'])->name('store')->middleware('permission:pengaturan.create');
            Route::post("/update/{keadaan}", [KeadaanController::class, 'update'])->name('update')->middleware('permission:pengaturan.update');
            Route::delete("/delete/{keadaan}", [KeadaanController::class, 'destroy'])->name('delete')->middleware('permission:pengaturan.delete');
        });

        // Status
        Route::prefix('status')->name("status.")->group(function () {
            Route::get("/", [StatusController::class, 'index']);
            Route::post("/", [StatusController::class, 'store'])->name('store')->middleware('permission:pengaturan.create');
            Route::post("/update/{status}", [StatusController::class, 'update'])->name('update')->middleware('permission:pengaturan.update');
            Route::delete("/delete/{status}", [StatusController::class, 'destroy'])->name('delete')->middleware('permission:pengaturan.delete');
        });

        // Lokasi
        Route::prefix('lokasi')->name("lokasi.")->group(function () {
            Route::get("/", [LokasiController::class, 'index']);
            Route::post("/", [LokasiController::class, 'store'])->name('store')->middleware('permission:pengaturan.create');
            Route::post("/update/{lokasi}", [LokasiController::class, 'update'])->name('update')->middleware('permission:pengaturan.update');
            Route::delete("/delete/{lokasi}", [LokasiController::class, 'destroy'])->name('delete')->middleware('permission:pengaturan.delete');
        });

        // Roles (you may want to control this more tightly)
        Route::prefix('role')->name("role.")->middleware('permission:pengaturan.update')->group(function () {
            Route::get("/", [RoleController::class, 'index'])->name('index');
            Route::post("/", [RoleController::class, 'store'])->name('store');
            Route::post("/update/{id}", [RoleController::class, 'update'])->name('update');
            Route::delete("/delete/{id}", [RoleController::class, 'destroy'])->name('delete');
            Route::post('/keluar/upload-bukti/{keluar}', [KeluarController::class, 'uploadBukti'])
    ->name('keluar.upload-bukti')
    ->middleware('permission:keluar.upload');

Route::get('/keluar/{barang}/edit', [KeluarController::class, 'edit'])
    ->name('keluar.edit')
    ->middleware('permission:keluar.update');

        });
    });

    // Report
    Route::prefix("report")->name("report.")->middleware('permission:report.view')->group(function () {
        Route::get("/", [ReportController::class, 'index']);
        Route::get("/download-report-masuk/{type}", [ReportController::class, 'downloadReportMasuk'])->name("download.masuk");
        Route::get("/download-report-keluar/{type}", [ReportController::class, 'downloadReportKeluar'])->name("download.keluar");
        Route::get("/download-report-peminjaman/{type}", [ReportController::class, 'downloadReportPeminjaman'])->name("download.peminjaman");
    });
});
