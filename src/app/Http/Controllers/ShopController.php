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
        $shops = Shop::with('area', 'genre')->get();

        $areas = Area::all();

        $genres = Genre::all();

        return view('index', compact('shops', 'areas', 'genres'));
    }

    public function search(Request $request)
    {
        $shops = Shop::with('area', 'genre')
               ->AreaSearch($request->area_id)
               ->GenreSearch($request->genre_id)
               ->KeywordSearch($request->keyword)->get();
        
        $areas = Area::all();

        $genres = Genre::all();

        return view('index', compact('shops', 'areas', 'genres'));
    }

    public function detail(Request $request)
    {
        $shops = Shop::with('area', 'genre')->where('shop', $request->shop)->get();

        $reserve = $request->only(['shop', 'date', 'time', 'number']);

        return view('shop', compact('shops', 'reserve'));
    }

    public function store(Request $request)
    {
        $reserve = $request->only(['shop', 'date', 'time', 'number']);

        $shopName = $request->input('shop');

        Reservation::create($reserve);

        return view('done');
    }

    public function doneview()
    {
        return view('done');
    }

}
