<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;

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
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    // ダッシュボード画面表示
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 商品一覧画面表示
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    // 商品新規作成画面表示
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    // 商品新規登録処理
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    // 商品詳細画面表示
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    // 商品編集画面表示
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    // 商品更新処理
    Route::post('/products/{id}/update', [ProductController::class, 'update'])->name('products.update');
    // 商品削除処理（指定商品の削除）
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});
