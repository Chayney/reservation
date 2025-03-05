<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Review;
use App\Models\Shop;
use App\Models\User;
use Faker\Generator as Faker;

class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        do {
            $userId = User::whereNotIn('id', [1])->inRandomOrder()->first()->id;
            $shopId = Shop::inRandomOrder()->first()->id;
            $exists = Review::where('user_id', $userId)
                ->where('shop_id', $shopId)
                ->exists();
        } while ($exists);
        $faker = app(Faker::class);
        $reviews = [
            '素晴らしいサービスでした！また利用したいです。',
            '店内がとても綺麗で、スタッフも親切でした。',
            '料理が美味しく、価格もリーズナブルでした。',
            '少し待ち時間が長かったですが、全体的に満足です。',
            'また来たいと思えるお店でした。'
        ];
        return [
            'user_id' => $userId,
            'shop_id' => $shopId,
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $faker->randomElement($reviews),
            'image_url' => 'image/yakitori.jpeg'
        ];
    }
}
