<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Reservation;
use App\Models\Favorite;

class ReservationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ログインユーザーのお気に入り店舗idを配列にする
        $favorites = $user->favorite()->pluck('shop_id')->toArray();

        $favoriteShops = Shop::with(['area', 'genre'])->whereIn('id', $favorites)->get();
        
        return view('mypage', compact('favoriteShops'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        $reserve = Reservation::where('user_id', $user->id)->first();

        $reserve = Reservation::create([
            'user_id' => $user->id,
            'shop_id' => $request->shop_id,
            'date' => $request->input('date'),
            'booktime' => $request->input('time'),
            'person' => $request->input('person')
        ]);

        return view('done');
    }
}
