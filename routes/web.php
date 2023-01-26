<?php

use App\Http\Controllers\ApproveKertasKerjaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisPengawasanController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PkptController;
use App\Http\Controllers\NonPkptController;
use App\Http\Controllers\ProgramKerjaController;
use App\Http\Controllers\SuratPerintahController;
use App\Http\Controllers\KertasKerjaController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PemeriksaanController;
use App\Http\Controllers\EvaluasiController;


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

Route::post('/logout', [LoginController::class, 'logout']);
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/Dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard-json', [DashboardController::class, 'json']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::prefix('master-data')->group(function () {
        Route::group(['prefix' => 'role'], function () {
            Route::get('/', [RoleController::class, 'index'])->name('role');
            Route::get('modal', [RoleController::class, 'modal']);
            Route::post('store', [RoleController::class, 'store']);
            Route::get('get-data', [RoleController::class, 'getdata']);
            Route::get('destroy', [RoleController::class, 'destroy']);
        });

        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [UserController::class, 'index']);
            Route::get('modal', [UserController::class, 'modal']);
            Route::post('store', [UserController::class, 'store']);
            Route::get('get-data', [UserController::class, 'getdata']);
            Route::get('destroy', [UserController::class, 'destroy']);
        });

        Route::group(['prefix' => 'jenis-pengawasan'], function () {
            Route::get('/', [JenisPengawasanController::class, 'index']);
            Route::get('/modal', [JenisPengawasanController::class, 'modal']);
            Route::post('/store', [JenisPengawasanController::class, 'store']);
            Route::get('/create', [JenisPengawasanController::class, 'create']);
            Route::get('/get-data', [JenisPengawasanController::class, 'getdata']);
            Route::get('/delete-data', [JenisPengawasanController::class, 'delete']);
        });

        Route::group(['prefix' => 'opd'], function () {
            Route::get('/', [OpdController::class, 'index']);
            Route::get('/modal', [OpdController::class, 'modal']);
            Route::post('/store', [OpdController::class, 'store']);
            Route::get('/create', [OpdController::class, 'create']);
            Route::get('/get-data', [OpdController::class, 'getdata']);
            Route::get('/delete-data', [OpdController::class, 'delete']);
        });
    });
});
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('perencanaan')->group(function () {
        Route::group(['prefix' => 'pkpt'], function () {
            Route::get('/', [PkptController::class, 'index']);
            Route::get('/modal', [PkptController::class, 'modal']);
            Route::post('import', [PkptController::class, 'import']);
            Route::get('/get-data', [PkptController::class, 'getdata']);
            Route::get('destroy', [PkptController::class, 'destroy']);
            Route::get('download', [PkptController::class, 'download']);
        });

        Route::group(['prefix' => 'non-pkpt'], function () {
            Route::get('create', [NonPkptController::class, 'create']);
            Route::get('edit', [NonPkptController::class, 'edit']);
            Route::post('store', [NonPkptController::class, 'store']);
        });

        Route::group(['prefix' => 'program-kerja-pengawasan'], function () {
            Route::get('/', [ProgramKerjaController::class, 'index']);
            Route::get('get-data', [ProgramKerjaController::class, 'getdata']);
            Route::get('create', [ProgramKerjaController::class, 'create']);
            Route::get('getTable', [ProgramKerjaController::class, 'getTable']);
            Route::get('tampil-table', [ProgramKerjaController::class, 'tampiltable']);
            Route::post('store', [ProgramKerjaController::class, 'store']);
            Route::get('destroy', [ProgramKerjaController::class, 'destroy']);
            Route::get('modal', [ProgramKerjaController::class, 'modal']);
            Route::get('modal-refused', [ProgramKerjaController::class, 'modalRefused']);
            Route::post('approved', [ProgramKerjaController::class, 'approved']);
            Route::post('refused', [ProgramKerjaController::class, 'refused']);
        });

        Route::group(['prefix' => 'surat-perintah'], function () {
            Route::get('/', [SuratPerintahController::class, 'index']);
            Route::get('get-data', [SuratPerintahController::class, 'getdata']);
            Route::get('create', [SuratPerintahController::class, 'create']);
            Route::get('download', [SuratPerintahController::class, 'download']);
            Route::get('tampil-table', [SuratPerintahController::class, 'tampiltable']);
            Route::post('store', [SuratPerintahController::class, 'store']);
            Route::post('update', [SuratPerintahController::class, 'update']);
            Route::get('tampil-sp', [SuratPerintahController::class, 'tampilSp']);
            Route::post('upload-sp', [SuratPerintahController::class, 'uploadSp']);
        });
    });
});

Route::group(['middleware' => 'auth'], function () {
    Route::prefix('pelaksanaan')->group(function () {
        Route::group(['prefix' => 'kertas-kerja-pemeriksaan'], function () {
            Route::get('/', [KertasKerjaController::class, 'index']);
            Route::get('get-data', [KertasKerjaController::class, 'getdata']);
            Route::get('detail', [KertasKerjaController::class, 'tampil_detail']);
            Route::get('get-jenis-pengawasan', [KertasKerjaController::class, 'getJenisPengawasan']);
            Route::get('modal', [KertasKerjaController::class, 'modal']);
            Route::get('modal-approve', [KertasKerjaController::class, 'modalApprove']);
            Route::get('modal-refused', [KertasKerjaController::class, 'modalRefused']);
            Route::post('store', [KertasKerjaController::class, 'store']);
            Route::get('destroy', [KertasKerjaController::class, 'destroy']);
            Route::post('approved', [KertasKerjaController::class, 'approved']);
            Route::post('refused', [KertasKerjaController::class, 'refused']);
        });

        Route::group(['prefix' => 'approve-kertas-kerja'], function () {
            Route::get('/', [ApproveKertasKerjaController::class, 'index']);
            Route::get('get-data', [ApproveKertasKerjaController::class, 'getdata']);
            Route::get('get-jenis-pengawasan', [ApproveKertasKerjaController::class, 'getJenisPengawasan']);
            Route::get('modal', [ApproveKertasKerjaController::class, 'modal']);
            Route::post('store', [ApproveKertasKerjaController::class, 'store']);
            Route::get('destroy', [ApproveKertasKerjaController::class, 'destroy']);
            Route::get('approved', [ApproveKertasKerjaController::class, 'approved']);
            Route::get('refused', [ApproveKertasKerjaController::class, 'refused']);
        });
    });
});

Route::group(['middleware' => 'auth'], function () {
    Route::prefix('pelaporan')->group(function () {
        Route::group(['prefix' => 'review'], function () {
            Route::get('/', [ReviewController::class, 'index']);
            Route::get('/get-data', [ReviewController::class, 'getdata']);
            Route::get('/get-table', [ReviewController::class, 'getTable']);
            Route::get('create', [ReviewController::class, 'create']);
            Route::get('/modal', [ReviewController::class, 'modal']);
            Route::get('/modal-rekomendasi', [ReviewController::class, 'modalrekom']);
            Route::post('/store', [ReviewController::class, 'store']);
            Route::post('/store-rekom', [ReviewController::class, 'storeRekom']);
            Route::get('modal-approved', [ReviewController::class, 'modalApprove']);
            Route::get('selesai', [ReviewController::class, 'selesai']);
            Route::get('modal-refused', [ReviewController::class, 'modalRefused']);
            Route::get('approved', [ReviewController::class, 'storeApprove']);
            Route::get('refused', [ReviewController::class, 'storeRefused']);
        });
        Route::group(['prefix' => 'tindak-lanjut'], function () {
            Route::get('/', [MonitoringController::class, 'index']);
            Route::get('/get-data', [MonitoringController::class, 'getdata']);
            Route::get('/modal', [MonitoringController::class, 'modal']);
            Route::post('store', [MonitoringController::class, 'store']);
        });
    });
});

Auth::routes();
