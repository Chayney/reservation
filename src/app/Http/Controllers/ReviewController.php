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
        $shops = Shop::where('shop', $request->shop)->get();

        return view('review.index', compact('shops'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:200',
            'shop_id' => 'required|exists:shops,id',
        ]);
        $review = Review::where('user_id', $user->id)->where('shop_id', $shop_id)->first();
        if (empty($review)) {
            Review::create([
                'user_id' => $user->id,
                'shop_id' => $request->shop_id,
                'rating' => $request->rating,
                'comment' => $request->comment
            ]);

            return view('review.thanks');
        }

        return redirect()->back();
    }
}
