<?php

declare(strict_types=1);

// Charger les configurations et les modèles
require_once __DIR__ . '/config/securite.php';
require_once __DIR__ . '/Modeles/publication-modele.php';
require_once __DIR__ . '/Modeles/emprunt-modele.php';

// Charger les contrôleurs
require_once __DIR__ . '/Controleurs/erreur-controleur.php';
require_once __DIR__ . '/Controleurs/emprunt-controleur.php';

// Démarrer la session avant tout affichage
demarrerSession();

// Récupérer l'action demandée (par défaut 'emprunts')
$action = $_GET['action'] ?? 'emprunts';

try {
    // Charger la connexion PDO
    require_once __DIR__ . '/config/database.php';

    // Router explicite - énumère les actions permises
    switch ($action) {
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