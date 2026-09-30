<?php

declare(strict_types=1);

// 1. Les inclusions (chemins de tes fichiers de classes)
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/securite.php';
require_once __DIR__ . '/Modeles/Modele.php';
require_once __DIR__ . '/Modeles/emprunt-modele.php';
require_once __DIR__ . '/Modeles/publication-modele.php';
require_once __DIR__ . '/Controleurs/accueil-controleur.php';
require_once __DIR__ . '/Controleurs/erreur-controleur.php';
require_once __DIR__ . '/Controleurs/emprunt-controleur.php';
require_once __DIR__ . '/Controleurs/publication-controleur.php';
require_once __DIR__ . '/Routage/Routeur.php';
require_once __DIR__ . '/Vues/vue.php';

demarrerSession();

// 2. Initialisation des objets (Injection de dépendances)
$publication = new Publication($pdo);
$emprunt = new Emprunt($pdo); // (Assure-toi d'avoir cette classe ou ton équivalent)
$vue = new Vue();
$controleurErreur = new ControleurErreur($vue);
$controleurPublication = new ControleurPublication($publication, $vue, $controleurErreur);
$controleurEmprunt = new ControleurEmprunt($emprunt, $vue, $controleurErreur);
$routeur = new Routeur($controleurPublication, $controleurEmprunt, $controleurErreur);

// 3. Lancement de l'application avec filet de sécurité global
try { 
    $routeur->router();
} catch (Throwable $exception) {
    $statut = in_array($exception->getCode(), [400, 403, 404, 405], true)
        ? $exception->getCode()
        : 500;
    
    $message = $statut === 500
        ? 'Une erreur empêche le traitement de la demande.'
        : $exception->getMessage();

    if ($statut === 500) {
        error_log($exception->getMessage());
    }

    $controleurErreur->afficher($message, $statut);
}