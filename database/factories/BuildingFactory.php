<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Building>
 */
class BuildingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $buildings = [
            ['title' => 'Анадырский', 'address' => 'Москва, Анадырский проезд, 79', 'floor' => 3],
            ['title' => 'Руставели', 'address' => 'Москва, улица Руставели, 10', 'floor' => 5],
            ['title' => 'Зеленый', 'address' => 'Москва, Зеленый проспект, 74', 'floor' => 4],
            ['title' => 'Плеханова', 'address' => 'Москва, улица Плеханова, 5', 'floor' => 3],
            ['title' => 'Парковая', 'address' => 'Москва, 12-я Парковая, 13', 'floor' => 3],
        ];

        $building = array_shift($buildings);

        return [
            'title' => $building['title'],
            'address' => $building['address'],
            'floor' => $building['floor'],
        ];
    }
}
