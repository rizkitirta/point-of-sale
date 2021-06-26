<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;

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

//Route::get('/dashboard-1', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/', fn () => redirect()->route('login'));
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
    //Kategori
    Route::get('kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
    Route::resource('kategori', KategoriController::class)->except(['create', 'edit']);

    //Produk
    Route::get('produk/data', [ProdukController::class, 'data'])->name('produk.data');
    Route::post('produk/cetak-barcode', [ProdukController::class, 'cetakBarcode'])->name('produk.cetakBarcode');
    Route::post('produk/delete-selected', [ProdukController::class, 'deleteSelected'])->name('produk.deleteSelected');
    Route::resource('produk', ProdukController::class)->except(['create', 'edit']);
});

// Route::get('user', function(){
//     User::create([
//         'name' => 'User',
//         'email' => 'user@gmail.com',
//         'password' => bcrypt('useraja123'),
//         'level' => 0,
//     ]);
// });
