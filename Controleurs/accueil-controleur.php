<?php

declare(strict_types=1);

$nomProjet = 'LocalHub';
$auteur = 'Redford S. St-M.';
$titrePage = $nomProjet;

$messageErreur = null;
$publicationsRecentes = [];

try {
    require __DIR__ . '/../config/database.php';
    require __DIR__ . '/../Modeles/ressource-modele.php';

    $publications = obtenirPublications($pdo);
    $publicationsRecentes = array_slice($publications, 0, 5);

    require __DIR__ . '/../Vues/accueil.php';
} catch (Throwable $exception) {
    error_log($exception->getMessage());
    $messageErreur = 'Impossible de charger les publications.';

    require __DIR__ . '/../Vues/erreur.php';
}
