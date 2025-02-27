<?php

namespace Database\Factories;

use App\Models\CabinetType;
use App\Models\Building;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cabinet>
 */
class CabinetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $cabinetNumbers = [101, 102, 103, 201, 202, 203, 301, 302, 310, 404];

        return [
            'building_id' => Building::inRandomOrder()->first()->id,
            'cabinet_type_id' => CabinetType::inRandomOrder()->first()->id,
            'title' => $this->faker->title,
            'cabinet_number' => array_shift($cabinetNumbers),
            'floor' => rand(1, 5),
        ];
    }
}
