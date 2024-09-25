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

// 店舗一覧
Route::get('/', [ShopController::class, 'index']);
Route::get('/search', [ShopController::class, 'search']);
Route::get('/detail/{shop_id}', [ShopController::class, 'detail']);

Route::middleware(['auth', 'verified'])->group(function () {
    // マイページ、店舗予約、予約変更
    Route::get('/mypage', [ReservationController::class, 'index']);
    Route::get('/mypage/edit', [ReservationController::class, 'edit']);
    Route::patch('/mypage', [ReservationController::class, 'update']);
    Route::delete('/mypage/destroy', [ReservationController::class, 'delete']);
    Route::post('/done', [ReservationController::class, 'store']);
    Route::delete('/favoriteshop/destroy', [ReservationController::class, 'destroy']);

    // 店舗一覧でのお気に入り追加と削除
    Route::post('/favorite/store', [FavoriteController::class, 'store']);
    Route::delete('/favorite/destroy{shop}', [FavoriteController::class, 'destroy']);

});