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
        if (Auth::check()) {
            $user = Auth::user();
            $favorites = $user->favorite()->pluck('shop_id')->toArray();
            $areas = Shop::select('area')->distinct()->get();
            $selectedArea = $request->input('area');
            $area = Shop::when($selectedArea, function($query, $selectedArea) {
            return $query->where('area', $selectedArea);
            })->get();

            $genres = Shop::select('genre')->distinct()->get();
            $selectedGenre = $request->input('genre');
            $genre = Shop::when($selectedGenre, function($query, $selectedGenre) {
                return $query->where('genre', $selectedGenre);
            })->get();
            $shops = Shop::all();
            return view('index', compact('shops', 'favorites', 'areas', 'selectedArea', 'genres', 'selectedGenre'));
            
        } else {
            $areas = Shop::select('area')->distinct()->get();
            $selectedArea = $request->input('area');
            $area = Shop::when($selectedArea, function($query, $selectedArea) {
                return $query->where('area', $selectedArea);
            })->get();

            $genres = Shop::select('genre')->distinct()->get();
            $selectedGenre = $request->input('genre');
            $genre = Shop::when($selectedGenre, function($query, $selectedGenre) {
                return $query->where('genre', $selectedGenre);
            })->get();
            $shops = Shop::all();
        
            return view('index', compact('shops', 'areas', 'selectedArea', 'genres', 'selectedGenre'));
        }
    }

    public function search(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $favorites = $user->favorite()->pluck('shop_id')->toArray();
            $areas = Shop::select('area')->distinct()->get();
            $selectedArea = $request->input('area');
            $area = Shop::when($selectedArea, function($query, $selectedArea) {
                return $query->where('area', $selectedArea);
            })->get();

            $genres = Shop::select('genre')->distinct()->get();
            $selectedGenre = $request->input('genre');
            $genre = Shop::when($selectedGenre, function($query, $selectedGenre) {
                return $query->where('genre', $selectedGenre);
            })->get();
            
            $shops = Shop::AreaSearch($request->area)
                ->GenreSearch($request->genre)
                ->KeywordSearch($request->keyword)->get();

            return view('index', compact('shops', 'favorites', 'areas', 'selectedArea', 'genres', 'selectedGenre'));
        
        } else {
            $areas = Shop::select('area')->distinct()->get();
            $selectedArea = $request->input('area');
            $area = Shop::when($selectedArea, function($query, $selectedArea) {
                return $query->where('area', $selectedArea);
            })->get();

            $genres = Shop::select('genre')->distinct()->get();
            $selectedGenre = $request->input('genre');
            $genre = Shop::when($selectedGenre, function($query, $selectedGenre) {
                return $query->where('genre', $selectedGenre);
            })->get();
            
            $shops = Shop::AreaSearch($request->area)
                ->GenreSearch($request->genre)
                ->KeywordSearch($request->keyword)->get();

            return view('index', compact('shops', 'areas', 'selectedArea', 'genres', 'selectedGenre'));
        }
    }

    public function detail(Request $request)
    {
        $shops = Shop::where('shop', $request->shop)->get();

        $reserve = $request->only(['shop', 'date', 'time', 'number']);

        return view('shop', compact('shops', 'reserve'));
    }
}
