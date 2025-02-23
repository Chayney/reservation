<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Shop;
use App\Models\Review;

class ReviewedShopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shops = Shop::all();
        foreach ($shops as $shop) {
            $averageRating = Review::where('shop_id', $shop->id)->avg('rating');
            if ($averageRating === null) {
                $averageRating = 0;
            }
            DB::table('shops')->where('id', $shop->id)->update(['avg_rating' => $averageRating]);
        }
    }
}
