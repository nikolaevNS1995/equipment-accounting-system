<?php

namespace Tests\Feature;

use App\Models\Cabinet;
use App\Models\CabinetType;
use App\Models\Role;
use App\Models\User;
use App\Models\Building;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class CabinetTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_cabinets_read_to_index(): void
    {
        $this->withoutExceptionHandling();

        $this->create_cabinet_type();
        $this->create_building();

        $cabinets = Cabinet::factory(10)->create();

        $user = $this->authenticate();

        $response = $this->actingAs($user)->get('/api/cabinets');

        $response->assertStatus(200);

        $json = $cabinets->map(function (Cabinet $cabinet) {
            return [
                'id' => $cabinet->id,
                'cabinet_type' => $cabinet->cabinetType->title,
                'building' => $cabinet->building->title,
                'title' => $cabinet->title,
                'cabinet_number' => $cabinet->cabinet_number,
                'floor' => $cabinet->floor,
            ];
        })->toArray();

        $response->assertJson([
            'data' => $json,
        ]);
    }

    public function test_cabinet_read_to_show(): void
    {
        $this->withoutExceptionHandling();

        $this->create_cabinet_type();
        $this->create_building();

        $cabinet = Cabinet::factory()->create();

        $user = $this->authenticate();

        $response = $this->actingAs($user)->get('/api/cabinets/' . $cabinet->id);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $cabinet->id,
                'cabinet_type' => $cabinet->cabinetType->title,
                'building' => $cabinet->building->title,
                'title' => $cabinet->title,
                'cabinet_number' => $cabinet->cabinet_number,
                'floor' => $cabinet->floor,
            ]
        ]);
    }

    public function test_cabinet_create_to_store(): void
    {
        $this->withoutExceptionHandling();

        $user = $this->authenticate();
        $cabinetType = $this->create_cabinet_type();
        $building = $this->create_building();

        $data = [
            'cabinet_type_id' => $cabinetType->id,
            'building_id' => $building->id,
            'title' => 'Кабинет информатики',
            'cabinet_number' => 321,
            'floor' => 3,
        ];

        $response = $this->actingAs($user)->post('/api/cabinets', $data);

        $response->assertStatus(201);
        $this->assertDatabaseCount('cabinets', 1);

        $cabinet = Cabinet::query()->first();
        $this->assertEquals($data['cabinet_type_id'], $cabinet->cabinet_type_id);
        $this->assertEquals($data['building_id'], $cabinet->building_id);
        $this->assertEquals($data['title'], $cabinet->title);
        $this->assertEquals($data['cabinet_number'], $cabinet->cabinet_number);
        $this->assertEquals($data['floor'], $cabinet->floor);

        $response->assertJson([
            'data' => [
                'id' => $cabinet->id,
                'cabinet_type' => $cabinet->cabinetType->title,
                'building' => $cabinet->building->title,
                'title' => $cabinet->title,
                'cabinet_number' => $cabinet->cabinet_number,
                'floor' => $cabinet->floor,
            ]
        ]);
    }

    public function test_cabinet_edit_to_update(): void
    {
        $this->withoutExceptionHandling();

        $user = $this->authenticate();
        $cabinetType = $this->create_cabinet_type();
        $building = $this->create_building();

        $cabinet = Cabinet::factory()->create([
            'cabinet_type_id' => $cabinetType->id,
            'building_id' => $building->id,
            'title' => 'Кабинет информатики',
            'cabinet_number' => 321,
            'floor' => 3,
        ]);

        $data = [
            'cabinet_type_id' => $cabinetType->id,
            'building_id' => $building->id,
            'title' => 'Кабинет информатики обновленный',
            'cabinet_number' => 210,
            'floor' => 2,
        ];

        $response = $this->actingAs($user)->patch('/api/cabinets/' . $cabinet->id, $data);
        $response->assertOk();

        $updatedCabinet = Cabinet::query()->find($cabinet->id);

        $this->assertEquals($cabinet->id, $updatedCabinet->id);
        $this->assertEquals($data['cabinet_type_id'], $updatedCabinet->cabinet_type_id);
        $this->assertEquals($data['building_id'], $updatedCabinet->building_id);
        $this->assertEquals($data['title'], $updatedCabinet->title);
        $this->assertEquals($data['cabinet_number'], $updatedCabinet->cabinet_number);
        $this->assertEquals($data['floor'], $updatedCabinet->floor);

        $response->assertJson([
            'data' => [
                'id' => $updatedCabinet->id,
                'cabinet_type' => $updatedCabinet->cabinetType->title,
                'building' => $updatedCabinet->building->title,
                'title' => $updatedCabinet->title,
                'cabinet_number' => $updatedCabinet->cabinet_number,
                'floor' => $updatedCabinet->floor,
            ]
        ]);

    }

    public function test_cabinet_delete_to_delete(): void
    {
        $user = $this->authenticate();
        $cabinetType = $this->create_cabinet_type();
        $building = $this->create_building();
        $cabinet = Cabinet::factory()->create();

        $this->assertDatabaseCount('cabinets', 1);

        $response = $this->actingAs($user)->delete('/api/cabinets/' . $cabinet->id);
        $response->assertNoContent();
        $this->assertSoftDeleted($cabinet);

    }

    protected function authenticate(): User
    {
        $user = User::factory()->create(
            [
                'name' => 'admin',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]
        );
        $role = Role::factory()->create(['title' => 'Админ']);
        $user->role()->attach($role);
        return $user;
    }

    protected function create_cabinet_type(): CabinetType
    {
        return CabinetType::factory()->create([
            'title' => 'Лаборатория'
        ]);

    }

    protected function create_building(): Building
    {
         return Building::factory()->create([
            'title' => 'Анадырский',
            'address' => 'Москва, Анадырский 79',
            'floor' => 3,
        ]);
    }
}
