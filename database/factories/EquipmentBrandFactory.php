<?php

namespace Database\Factories;

use App\Models\EquipmentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EquipmentBrand>
 */
class EquipmentBrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $brands = ['Dell', 'HP', 'Lenovo', 'Asus', 'Apple'];

        return [
            'equipment_type_id' => EquipmentType::inRandomOrder()->first()->id,
            'title' => array_shift($brands),
        ];
    }
}
