<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EquipmentType>
 */
class EquipmentTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $types = ['Компьютер', 'Принтер', 'Сканер', 'Монитор'];

        return [
            'title' => array_shift($types),
        ];
    }
}
