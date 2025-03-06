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
use App\Http\Requests\ReviewRequest;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $shops = Shop::where('shop', $request->shop)->get();
        $lists = Review::where('id', $request->id)->get();
        
        return view('review.index', compact('shops', 'lists'));
    }

    public function store(ReviewRequest $request)
    {
        $user = Auth::user();
        $shop_id = $request->shop_id;
        $review = Review::where('user_id', $user->id)->where('shop_id', $shop_id)->first();
        if (empty($review)) {
            $image = $request->file('image_url');
            if ($request->hasFile('image_url')) {
                $path = \Storage::put('/public', $image);
                $path = explode('/', $path);
                $image_url = $path[1];
            } else {
                $image_url = null;
            }
            Review::create([
                'user_id' => $user->id,
                'shop_id' => $request->shop_id,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'image_url' => $image_url
            ]);

            return view('review.thanks');
        } else {
            return redirect()->back()->with('alert', '既に投稿した口コミがあります');
        }
    }

    public function show(Request $request)
    {
        $shops = Shop::where('shop', $request->shop)->get();
        $lists = Review::with('reviewUser')->where('shop_id', $request->shop_id)->get();
        
        return view('review.list', compact('shops', 'lists'));
    }

    public function update(ReviewRequest $request)
    {
        $user = Auth::user();
        $shop_id = $request->shop_id;
        $review = Review::where('id', $request->id)->first();
        $shop = Shop::where('id', $review->shop_id)->first();
        $image = $request->file('image_url');
        if ($request->hasFile('image_url')) {
            $path = \Storage::put('/public', $image);
            $path = explode('/', $path);
            $image_url = $path[1];
        } else {
            $image_url = $review->image_url;
        }
        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment ?? $review->comment,
            'image_url' => $image_url
        ]);

        return redirect("/review/list/{$shop_id}?shop_id={$shop_id}&shop={$shop->shop}")->with('success', '口コミを更新しました');
    }

    public function destroy(Request $request)
    {
        Review::where('id', $request->id)->delete();

        return redirect()->back()->with('success', '口コミを削除しました');
    }
}
