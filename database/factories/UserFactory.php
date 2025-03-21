<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $users = [
            ['name' => 'Администратор', 'email' => 'admin@example.com'],
            ['name' => 'Иван Иванов', 'email' => 'ivan@example.com'],
            ['name' => 'Мария Петрова', 'email' => 'maria@example.com'],
        ];

       // $user = array_shift($users);

        return [
            'name' =>  $users[rand(0,2)]['name'],
            'email' => $users[rand(0,2)]['email'],
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
