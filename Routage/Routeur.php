<?php

declare(strict_types=1);

class Routeur
{
    private $controleurAccueil;
    private $controleurPublication;
    private $controleurEmprunt;
    private $controleurErreur;

    public function __construct(
        ControleurAccueil $controleurAccueil,
        ControleurPublication $controleurPublication,
        ControleurEmprunt $controleurEmprunt,
        ControleurErreur $controleurErreur
    ) {
        $this->controleurAccueil = $controleurAccueil;
        $this->controleurPublication = $controleurPublication;
        $this->controleurEmprunt = $controleurEmprunt;
        $this->controleurErreur = $controleurErreur;
    }

    public function router(): void
    {
        $action = $_GET['action'] ?? 'accueil';

        try {
            switch ($action) {
                case 'accueil':
                    $this->controleurAccueil->afficherAccueil();
                    break;

                case 'publications':
                    $this->controleurPublication->afficherPublications();
                    break;

                case 'emprunts':
                    $this->controleurEmprunt->afficherEmprunts();
                    break;

                case 'demander-emprunt':
                    $this->controleurEmprunt->afficherFormulaire($this->lireIdGet());
                    break;

                case 'ajouter-emprunt':
                    $this->exigerEcriture($_POST['jeton_csrf'] ?? null);
                    $this->controleurEmprunt->ajouter($_POST);
                    break;

                case 'confirmer-suppression':
                    $this->controleurEmprunt->afficherConfirmationAnnulation($this->lireIdGet());
                    break;

                case 'annuler-emprunt':
                    $this->exigerEcriture($_POST['jeton_csrf'] ?? null);
                    $this->controleurEmprunt->annuler($_POST);
                    break;

                default:
                    $this->controleurErreur->afficher('Page introuvable.', 404);
            }
        } catch (Throwable $exception) {
            // Les codes HTTP sont des entiers ; un PDOException, lui, a un code texte (ex. '42S22').
            $code = $exception->getCode();
            $statut = in_array($code, [400, 403, 404, 405], true) ? $code : 500;

            $message = $statut === 500
                ? 'Une erreur empêche le traitement de la demande.'
                : $exception->getMessage();

            if ($statut === 500) {
                error_log($exception->getMessage());
            }

            $this->controleurErreur->afficher($message, $statut);
        }
    }

    private function lireIdGet(): int
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id === false || $id === null) {
            throw new InvalidArgumentException('Identifiant invalide.', 400);
        }

        return $id;
    }

    private function exigerEcriture($jeton): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new RuntimeException('Méthode non permise.', 405);
        }

        if (!verifierJetonCsrf($jeton)) {
            throw new RuntimeException('Requête refusée.', 403);
        }
    }
}
