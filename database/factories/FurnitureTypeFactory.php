<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FurnitureType>
 */
class FurnitureTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $types = ['Стол', 'Стул', 'Шкаф', 'Тумбочка', 'Полка'];

        return [
            'title' => array_shift($types),
        ];
    }
}
