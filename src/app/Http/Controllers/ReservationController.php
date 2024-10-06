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
use App\Http\Requests\ReservationRequest;

class ReservationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $reservates = Reservation::where('user_id', $user->id)->with('reserveShop')->get();
        $favorites = $user->userFavorites()->pluck('shop_id')->toArray();
        $favoriteShops = Shop::whereIn('id', $favorites)->get();
        
        return view('mypage', compact('reservates', 'favoriteShops'));
    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        $shop_id = ($request->id);
        $reserve = Reservation::where('user_id', $user->id)->where('shop_id', $shop_id)->delete();
        
        return redirect()->back();
    }

    public function store(ReservationRequest $request)
    {
        $user = Auth::user();
        $shop_id = $request->shop_id;
        $reserve = Reservation::where('user_id', $user->id)->where('shop_id', $shop_id)->first();
        if (empty($reserve)) {
            $reserve = Reservation::create([
                'user_id' => $user->id,
                'shop_id' => $request->shop_id,
                'date' => $request->input('date'),
                'time' => $request->input('time'),
                'person' => $request->input('person')
            ]);
    
            return view('done');
        } else {
            $message = '既に予約があります\nマイページから予約の変更を行ってください';
            return redirect()->back()->with('alert', nl2br(e($message)));
        }
    }

    public function edit(Request $request)
    {
        $user = Auth::user();
        $reservate = Reservation::find($request->id);
        $shops = Shop::where('id', $reservate->shop_id)->get();
        $reservates = Reservation::where('id', $request->id)->get();
    
        return view('edit', compact('reservates', 'shops'));
    }

    public function update(ReservationRequest $request)
    {
        $user = Auth::user();
        $shop_id = $request->shop_id;
        $reservates = Reservation::where('user_id', $user->id)->where('shop_id', $shop_id)->first();
        $reservates->update([
            'date' => $request->input('date'),
            'time' => $request->input('time'),
            'person' => $request->input('person')
        ]);
    
        return redirect('/mypage');
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        $shop_id = $request->shop_id;
        Favorite::where('user_id', $user->id)->where('shop_id', $shop_id)->delete();

        return redirect()->back();
    }

    public function confirm(Request $request)
    {
        $reservation = Reservation::find($request->id);
        $reservation->save();

        return redirect('/reservation/confirm');
    }
}
