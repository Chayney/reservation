<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Reservation;
use App\Models\Shop;
use Illuminate\Support\Carbon;

class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $randomDate = Carbon::now()->subWeek(2)->addDays(rand(0, 16))->toDateString();

        return [
            'user_id' => 2,
            'shop_id' => function () {
                return Shop::inRandomOrder()->first()->id;
            },
            'date' => $randomDate,
            'time' => $this->faker->randomElement(['20:00', '20:30', '21:00', '21:30', '22:00']),
            'person' => $this->faker->randomElement(['1人', '2人', '3人', '4人', '5人以上']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
