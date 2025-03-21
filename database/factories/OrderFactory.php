<?php

namespace Database\Factories;

use App\Models\Equipment;
use App\Models\Furniture;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'order_type' => $this->faker->randomElement(['установка', 'перемещение', 'ремонт', 'списание']),
            'status' => $this->faker->randomElement(['в ожидании', 'одобрено', 'отклонено', 'завершено']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function withItems(int $count = 3): OrderFactory|Factory
    {
        return $this->afterCreating(function (Order $order) use ($count) {

            $equipments = Equipment::inRandomOrder($count)->get();
            $furnitures = Furniture::inRandomOrder($count)->get();


            $order->equipments()->attach($equipments);
            $order->furnitures()->attach($furnitures);
        });
    }
}
