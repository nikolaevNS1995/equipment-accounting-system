<?php

namespace Database\Factories;

use App\Models\Cabinet;
use App\Models\EquipmentModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment>
 */
class EquipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $inventoryNumbers = [001, 002, 003, 004, 005];
        return [
            'equipment_model_id' => EquipmentModel::inRandomOrder()->first()->id,
            'cabinet_id' => Cabinet::inRandomOrder()->first()->id,
            'inventory_number' => array_shift($inventoryNumbers),
        ];
    }
}
