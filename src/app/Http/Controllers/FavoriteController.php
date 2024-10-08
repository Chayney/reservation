<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $shop_id = $request->shop_id;        
        $favoritemark = Favorite::where('user_id', $user->id)->where('shop_id', $shop_id)->first();        
        if (!$favoritemark) {
            Favorite::create([
                'user_id' => $user->id,
                'shop_id' => $shop_id
            ]);

            return redirect()->back();
        }  
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        $shop_id = $request->shop_id;
        Favorite::where('user_id', $user->id)->where('shop_id', $shop_id)->delete();

        return redirect()->back();
    }
}
