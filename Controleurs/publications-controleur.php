<?php

declare(strict_types=1);

function afficherPublications(PDO $pdo): void
{
    $publications = obtenirPublications($pdo);
    $titrePage = 'Publications';

    require __DIR__ . '/../Vues/publications/index.php';
}