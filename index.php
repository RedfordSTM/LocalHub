<?php

declare(strict_types=1);


// 1. Charger les configurations et sécurités EN PREMIER (avant tout affichage ou sortie)
require_once __DIR__ . '/config/securite.php';

// 2. Charger les modèles
require_once __DIR__ . '/Modeles/emprunt-modele.php';
require_once __DIR__ . '/Modeles/publication-modele.php';

// 3. Charger les contrôleurs (seulement des définitions de fonctions !)
require_once __DIR__ . '/Controleurs/accueil-controleur.php';
require_once __DIR__ . '/Controleurs/erreur-controleur.php';
require_once __DIR__ . '/Controleurs/emprunt-controleur.php';
require_once __DIR__ . '/Controleurs/publication-controleur.php';

demarrerSession();

$action = $_GET['action'] ?? 'accueil';

try {
    // Charger la connexion PDO
    require_once __DIR__ . '/config/database.php';

    // Router unique
    switch ($action) {
        case 'accueil':
            afficherAccueil();
            break;

        case 'publications':
            afficherPublications($pdo); 
            break;

        case 'emprunts':
            afficherEmprunts($pdo);
            break;

        case 'demander-emprunt':
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if ($id === false || $id === null) {
                afficherErreur('Identifiant invalide.', 400);
                break;
            }
            afficherFormulaireEmprunt($pdo, $id);
            break;

        case 'ajouter-emprunt':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                afficherErreur('Méthode non permise.', 405);
                break;
            }
            if (!verifierJetonCsrf($_POST['jeton_csrf'] ?? null)) {
                afficherErreur('Requête refusée.', 403);
                break;
            }
            ajouterEmpruntAction($pdo);
            break;

        case 'confirmer-suppression':
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if ($id === false || $id === null) {
                afficherErreur('Identifiant invalide.', 400);
                break;
            }
            afficherConfirmationAnnulationEmprunt($pdo, $id);
            break;

        case 'annuler-emprunt':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                afficherErreur('Méthode non permise.', 405);
                break;
            }
            if (!verifierJetonCsrf($_POST['jeton_csrf'] ?? null)) {
                afficherErreur('Requête refusée.', 403);
                break;
            }
            annulerEmpruntAction($pdo);
            break;

        default:
            afficherErreur('Page introuvable.', 404);
    }

} catch (Throwable $exception) {
    error_log($exception->getMessage());
    afficherErreur('Une erreur empêche le traitement de la demande.', 500);
}