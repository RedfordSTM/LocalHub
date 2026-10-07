<?php

declare(strict_types=1);


require_once __DIR__ . '/config/securite.php';
require_once __DIR__ . '/Modeles/Modele.php';
require_once __DIR__ . '/Modeles/emprunt.php';
require_once __DIR__ . '/Modeles/publication.php';
require_once __DIR__ . '/Vues/Vue.php';
require_once __DIR__ . '/Controleurs/controleurErreur.php';
require_once __DIR__ . '/Controleurs/controleurAccueil.php';
require_once __DIR__ . '/Controleurs/controleurEmprunt.php';
require_once __DIR__ . '/Controleurs/controleurPublication.php';
require_once __DIR__ . '/Routage/Routeur.php';

demarrerSession();

$vue = new Vue([
    'nomProjet' => 'LocalHub',
    'auteur' => 'Redford S. St-M.',
]);
$controleurErreur = new ControleurErreur($vue);

try {
    require __DIR__ . '/config/database.php'; // définit $pdo

    $publication = new Publication($pdo);
    $emprunt = new Emprunt($pdo);

    $controleurAccueil = new ControleurAccueil($vue, $controleurErreur);
    $controleurPublication = new ControleurPublication($publication, $vue, $controleurErreur);
    $controleurEmprunt = new ControleurEmprunt($emprunt, $vue, $controleurErreur);

    $routeur = new Routeur(
        $controleurAccueil,
        $controleurPublication,
        $controleurEmprunt,
        $controleurErreur
    );
    $routeur->router();
} catch (Throwable $exception) {
    error_log($exception->getMessage());
    $controleurErreur->afficher('Une erreur empêche le traitement de la demande.', 500);
}
