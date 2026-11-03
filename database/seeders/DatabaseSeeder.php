<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Publication;
use App\Models\Reservation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\CategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * This replaces the default Laravel seeder, which targeted the `users`
     * table (name/email/password). That table does not exist in
     * database/init/01-localhubScript.sql, so the old User::factory() call
     * would fail. We seed the `utilisateur` table instead.
     *
     * updateOrCreate() keeps this idempotent: it will also REPAIR the demo
     * rows if 01-localhubScript.sql already inserted them with the plaintext
     * password 'TEMPORAIRE', replacing it with a proper bcrypt hash.
     */
    public function run(): void
    {
        $this->call(CategorySeeder::class);

        User::updateOrCreate(
            ['courriel' => config('admin.email')],
            [
                'nom' => config('admin.nom'),
                'prenom' => config('admin.prenom'),
                'ville' => config('admin.ville'),
                'mot_de_passe' => Hash::make(config('admin.password')),
                'role' => User::ROLE_MANAGER,
            ],
        );

        $utilisateurs = [
            ['nom' => 'Tremblay', 'prenom' => 'Alex', 'courriel' => 'alex.tremblay@localhub.test', 'ville' => 'Montréal'],
            ['nom' => 'Gagnon', 'prenom' => 'Sarah', 'courriel' => 'sarah.gagnon@localhub.test', 'ville' => 'Montréal'],
            ['nom' => 'Roy', 'prenom' => 'Thomas', 'courriel' => 'thomas.roy@localhub.test', 'ville' => 'Laval'],
            ['nom' => 'Bouchard', 'prenom' => 'Emma', 'courriel' => 'emma.bouchard@localhub.test', 'ville' => 'Longueuil'],
            ['nom' => 'Côté', 'prenom' => 'Maxime', 'courriel' => 'maxime.cote@localhub.test', 'ville' => 'Montréal'],
        ];

        foreach ($utilisateurs as $utilisateurData) {
            $utilisateur = User::updateOrCreate(
                ['courriel' => $utilisateurData['courriel']],
                [
                    'nom' => $utilisateurData['nom'],
                    'prenom' => $utilisateurData['prenom'],
                    'ville' => $utilisateurData['ville'],
                    'mot_de_passe' => Hash::make('password'),
                ],
            );

            Publication::factory()
                ->count(3)
                ->has(Reservation::factory()->count(2), 'reservations')
                ->create(['id_utilisateur' => $utilisateur->id_utilisateur]);

            Publication::factory()
                ->nonPublie()
                ->create(['id_utilisateur' => $utilisateur->id_utilisateur]);
        }
    }
}
