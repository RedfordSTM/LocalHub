<?php

declare(strict_types=1);

$nomProjet = 'LocalHub';
$auteur = 'Redford S. St-M.';
$titrePage = $nomProjet;

$messageErreur = null;
$publicationsRecentes = [];

try {
    // 1. Include database connection (ensure it initializes $pdo)
    require __DIR__ . '/../config/database.php';
    
    // 2. Include the correct publication model
    require __DIR__ . '/../Modeles/publication-modele.php';

    // 3. Fetch recent publications (adjust the function name if it differs in your model)
    $publicationsRecentes = obtenirPublications($pdo);

    require __DIR__ . '/../Vues/accueil.php';
} catch (Throwable $exception) {
    error_log($exception->getMessage());
    $messageErreur = 'Impossible de charger cette page daccueil.';

    require __DIR__ . '/../Vues/erreur.php';
}