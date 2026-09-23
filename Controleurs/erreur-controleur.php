<?php

declare(strict_types=1);

function afficherErreur(string $message, int $statut = 500): void
{
    http_response_code($statut);
    $titrePage = 'Erreur';
    $messageErreur = $message;

    require __DIR__ . '/../Vues/erreur.php';
}