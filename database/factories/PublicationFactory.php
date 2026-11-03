<?php

namespace Database\Factories;

use App\Enums\PublicationType;
use App\Models\User;
use App\Models\Publication;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Publication>
 */
class PublicationFactory extends Factory
{

    protected $model = Publication::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_utilisateur' => User::factory(), // Automatically creates a user or links one
            'id_categorie' => Category::query()->inRandomOrder()->value('id_categorie')
                ?? Category::factory(),
            'titre' => fake()->text(100), // Respects the VARCHAR(150) limit (in characters)
            'description' => fake()->paragraph(), // Perfect for TEXT columns
            'type' => fake()->randomElement(PublicationType::cases()),
            'prix' => fake()->optional()->randomFloat(2, 10, 150), // Nullable decimal for tools/help, priced for items/services
            'ville' => fake()->city(), 
            'date_creation' => now(), 
            'statut' => 'active',

        ];
    }

    public function nonPublie(): static
    {
        return $this->state(fn () => [
            'statut' => 'inactif', 
        ]);
    }
}
