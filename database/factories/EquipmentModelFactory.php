<?php

namespace Database\Factories;

use App\Models\EquipmentBrand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EquipmentModel>
 */
class EquipmentModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $models = ['Inspiron 15', 'Pavilion 14', 'ThinkPad X1', 'ZenBook Pro', 'MacBook Air'];

        return [
            'equipment_brand_id' => EquipmentBrand::inRandomOrder()->first()->id,
            'title' => array_shift($models),
        ];
    }
}
