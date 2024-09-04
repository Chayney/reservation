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

        $reservates = Reservation::where('user_id', $user->id)->with('reserve_shop')->get();

        // ログインユーザーのお気に入り店舗idを配列にする
        $favorites = $user->favorite()->pluck('shop_id')->toArray();

        $favoriteShops = Shop::whereIn('id', $favorites)->get();
        
        return view('mypage', compact('reservates', 'favoriteShops'));
    }

    public function delete(Request $request, Reservation $reservates)
    {
        $user = Auth::user();
        $shop_id = $reservates->pluck('shop_id');
        $reserve = Reservation::where('user_id', $user->id)->where('shop_id', $shop_id)->delete();
        
        return redirect()->back();
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        $reserve = Reservation::where('user_id', $user->id)->first();

        $reserve = Reservation::create([
            'user_id' => $user->id,
            'shop_id' => $request->shop_id,
            'date' => $request->input('date'),
            'bookTime' => $request->input('time'),
            'person' => $request->input('person')
        ]);

        return view('done');
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();

        $shop_id = $request->shop_id;

        Favorite::where('user_id', $user->id)->where('shop_id', $shop_id)->delete();

        return redirect()->back();
    }
}
