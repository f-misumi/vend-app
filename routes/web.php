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
    //ダッシュボード画面表示
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    //商品リソース（一覧・新規作成・保存・削除など）を一括定義
    Route::resource('products', ProductController::class);
    //商品一覧画面表示
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    //商品編集画面表示
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    //商品編集処理
    Route::post('/products/{id}/update', [ProductController::class, 'update'])->name('products.update');
});
