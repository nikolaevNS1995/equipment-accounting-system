<?php

namespace Database\Seeders;

use App\Models\Cabinet;
use App\Models\CabinetType;
use App\Models\Equipment;
use App\Models\EquipmentBrand;
use App\Models\EquipmentModel;
use App\Models\EquipmentType;
use App\Models\Furniture;
use App\Models\FurnitureType;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use App\Models\Building;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Создаем роли
        Role::factory()->count(3)->create();

        // Создаем пользователей
        User::factory()->count(3)->create();

        // Создаем здания
        Building::factory(5)->create();

        // Создаем кабинеты
        CabinetType::factory(3)->create();
        Cabinet::factory(10)->create();

        // Создаем типы и бренды оборудования
        EquipmentType::factory(3)->create();
        EquipmentBrand::factory(3)->create();
        EquipmentModel::factory(3)->create();

        // Создаем оборудование
        Equipment::factory(5)->create();

        // Создаем типы мебели и мебель
        FurnitureType::factory(5)->create();
        Furniture::factory(5)->create();

        // Создаем наряды
        Order::factory()->count(3)->withItems(4)->create();
    }
}
