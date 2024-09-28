<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Reservation;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $shop = Shop::with('area', 'genre')->where('id', $request->shop_id)->first();
        return view('review.index', compact('shop'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        Review::create([
            'user_id' => $user->id,
            'restaurant_id' => $request->restaurant_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'レビューが投稿されました！');
    }
}
