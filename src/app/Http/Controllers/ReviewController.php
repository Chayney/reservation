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
        $lists = Review::where('id', $request->id)->get();
        
        return view('review.index', compact('shops', 'lists'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'rating' => 'required',
            'comment' => 'max:400',
            'image_url' => 'file|mimes:jpeg,png'
        ], [
            'rating.required' => '評価を指定してください。',
            'comment.max' => 'コメントは400文字以内で入力してください。',
            'image_url.file' => '有効なファイルをアップロードしてください',
            'image_url.mimes' => 'アップロード可能なファイル形式は、jpeg,png のみです'
        ]);
        $shop_id = $request->shop_id;
        $review = Review::where('user_id', $user->id)->where('shop_id', $shop_id)->first();
        if (empty($review)) {
            $image = $request->file('image_url');
            if ($request->hasFile('image_url')) {
                $path = \Storage::put('/public', $image);
                $path = explode('/', $path);
            } else {
                $path = null;
            }
            Review::create([
                'user_id' => $user->id,
                'shop_id' => $request->shop_id,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'image_url' => $path[1]
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

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'rating' => 'required',
            'comment' => 'max:400',
            'image_url' => 'file|mimes:jpeg,png'
        ], [
            'rating.required' => '評価を指定してください。',
            'comment.max' => 'コメントは400文字以内で入力してください。',
            'image_url.file' => '有効なファイルをアップロードしてください',
            'image_url.mimes' => 'アップロード可能なファイル形式は、jpeg,png のみです'
        ]);
        $shop_id = $request->shop_id;
        $review = Review::where('id', $request->id)->first();
        $image = $request->file('image_url');
        if ($request->hasFile('image_url')) {
            $path = \Storage::put('/public', $image);
            $path = explode('/', $path);
        } else {
            $path = null;
        }
        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'image_url' => $path[1]
        ]);

        return redirect()->back()->with('success', '口コミを更新しました');
    }
}
