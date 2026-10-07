<?php

declare(strict_types=1);

require_once __DIR__ . '/Modele.php';

class Utilisateur extends Modele
{
    public function trouverParIdentifiant(string $identifiant): ?array
    {
        $utilisateur = $this->executer(
            'SELECT id_utilisateur, nom, prenom, courriel
             FROM utilisateur
             WHERE nom = :nom',
            ['nom' => $nom]
        )->fetch();

        return $utilisateur ?: null;
    }
}
