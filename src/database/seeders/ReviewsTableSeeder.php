<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Shop;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shops = Shop::all();
        $reviewsToCreate = 10;
        for ($i = 0; $i < $reviewsToCreate; $i++) {
            $shop = $shops->random();
            Review::factory()->create([
                'shop_id' => $shop->id
            ]);
        }
    }
}
