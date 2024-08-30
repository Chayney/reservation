<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;
use App\Models\Reservation;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $shops = Shop::with('area', 'genre')->get();

        $areas = Area::all();

        $genres = Genre::all();

        $favorites = $user->favorite()->pluck('shop_id')->toArray();

        return view('index', compact('shops', 'areas', 'genres', 'favorites'));
    }

    public function search(Request $request)
    {
        $user = Auth::user();
        
        $shops = Shop::with('area', 'genre')
               ->AreaSearch($request->area_id)
               ->GenreSearch($request->genre_id)
               ->KeywordSearch($request->keyword)->get();
        
        $areas = Area::all();

        $genres = Genre::all();

        $favorites = $user->favorite()->pluck('shop_id')->toArray();

        return view('index', compact('shops', 'areas', 'genres', 'favorites'));
    }

    public function detail(Request $request)
    {
        $shops = Shop::with('area', 'genre')->where('shop', $request->shop)->get();

        $reserve = $request->only(['shop', 'date', 'time', 'number']);

        return view('shop', compact('shops', 'reserve'));
    }
}
