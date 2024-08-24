<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\RegisterController;

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

// 会員登録後に遷移する
Route::get('/thanks', [RegisterController::class, 'thanks']);

// Route::middleware('guest')->group(function () {
//     Route::get('/', [ShopController::class, 'index']);
// });

Route::middleware('auth')->group(function () {
    // ShopController
    // 店舗一覧
    Route::get('/', [ShopController::class, 'index']);
    Route::get('/search', [ShopController::class, 'search']);
    Route::get('/detail/{shop_id}', [ShopController::class, 'detail']);

    // ReservationController
    // 店舗詳細、マイページ
    Route::get('/mypage', [ReservationController::class, 'index']);
    Route::get('/confirm', [ReservationController::class, 'confirm']);
    Route::post('/done', [ReservationController::class, 'store']);

    // FavoriteController
    // 店舗一覧でのお気に入り追加と削除
    Route::post('/favorite/store', [FavoriteController::class, 'store']);
    Route::delete('/favorite/destroy{shop}', [FavoriteController::class, 'destroy']);
    
});


