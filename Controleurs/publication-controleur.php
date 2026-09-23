<?php

declare(strict_types=1);

function afficherPublications(PDO $pdo): void
{
    $publications = obtenirPublications($pdo);
    $titrePage = 'Publications';

    require __DIR__ . '/../Vues/publications/publication.php';
}

$nomProjet = 'LocalHub';
$auteur = 'Redford S. St-M.';
$titrePage = 'Publications - ' . $nomProjet;

$messageErreur = null;

try {
    require __DIR__ . '/../config/database.php';
    require __DIR__ . '/../Modeles/publication-modele.php';

    $publications = obtenirPublications($pdo);

    require __DIR__ . '/../Vues/publications/publication.php';
} catch (Throwable $exception) {
    error_log($exception->getMessage());
    $messageErreur = 'Impossible de charger les publications.';

    require __DIR__ . '/../Vues/erreur.php';
}
