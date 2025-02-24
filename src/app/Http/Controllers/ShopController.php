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
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $favorites = $user->userFavorites()->pluck('shop_id')->toArray();
            $avgs = Shop::with('area', 'genre')->get();
            foreach ($avgs as $shop) {
                $avgRating = $shop->reviews()->avg('rating') ?? 0;
                $shop->avg_rating = $avgRating;
                $shop->save();
            }
            $shops = Shop::with('area', 'genre')->get();
            $areas = Area::all();
            $genres = Genre::all();

            return view('index', compact('shops', 'areas', 'genres', 'favorites'));
        } else {
            $avgs = Shop::with('area', 'genre')->get();
            foreach ($avgs as $shop) {
                $avgRating = $shop->reviews()->avg('rating') ?? 0;
                $shop->avg_rating = $avgRating;
                $shop->save();
            }
            $shops = Shop::with('area', 'genre')->get();
            $areas = Area::all();
            $genres = Genre::all();

            return view('index', compact('shops', 'areas', 'genres'));
        }
    }

    public function search(Request $request)
    {
        if (Auth::check()) {
            $shopsQuery = Shop::with('area', 'genre')
                    ->AreaSearch($request->area)
                    ->GenreSearch($request->genre)
                    ->KeywordSearch($request->keyword);
            if ($request->has('sort')) {
                switch ($request->input('sort')) {
                    case 'high_rating':
                        $shopsQuery = $shopsQuery->HighRating();
                        break;
                    case 'low_rating':
                        $shopsQuery = $shopsQuery->orderByRaw('avg_rating = 0, avg_rating ASC');
                        break;
                    case 'random':
                        $shopsQuery = $shopsQuery->RandomOrder();
                        break;
                }
            } else {
                $shopsQuery->orderByRaw('avg_rating = 0');
            }
            $shops = $shopsQuery->get();
            $areas = Area::all();
            $genres = Genre::all();

            return view('index', compact('shops', 'areas', 'genres'));
        } else {
            $shopsQuery = Shop::with('area', 'genre')
                    ->AreaSearch($request->area)
                    ->GenreSearch($request->genre)
                    ->KeywordSearch($request->keyword);
            $shopsQuery->orderByRaw('avg_rating = 0');
            if ($request->has('sort')) {
                switch ($request->input('sort')) {
                    case 'high_rating':
                        $shopsQuery = $shopsQuery->HighRating();
                        break;
                    case 'low_rating':
                        $shopsQuery = $shopsQuery->LowRating();
                        break;
                    case 'random':
                        $shopsQuery = $shopsQuery->RandomOrder();
                        break;
                }
            }
            $shops = $shopsQuery->get();
            $areas = Area::all();
            $genres = Genre::all();

            return view('index', compact('shops', 'areas', 'genres'));
        }
    }

    public function detail(Request $request)
    {
        $shops = Shop::where('shop', $request->shop)->get();

        return view('shop', compact('shops'));
    }
}
