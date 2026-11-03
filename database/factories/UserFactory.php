<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'nom' => fake()->lastName(),
            'prenom' => fake()->firstName(),
            'courriel' => fake()->unique()->safeEmail(),
            'mot_de_passe' => 'password',
            'ville' => fake()->city(),
        ];
    }
}
