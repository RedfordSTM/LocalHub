<?php

declare(strict_types=1);

class Routeur
{
    private $controleurPublication;
    private $controleurEmprunt;
    private $controleurErreur;

    public function __construct(
        ControleurPublication $controleurPublication,
        ControleurEmprunt $controleurEmprunt,
        ControleurErreur $controleurErreur
    ) {
        $this->controleurPublication = $controleurPublication;
        $this->controleurEmprunt = $controleurEmprunt;
        $this->controleurErreur = $controleurErreur;
    }

    public function router(): void
    {
        // Par défaut, on affiche la liste des publications (ou de l'accueil)
        $action = $_GET['action'] ?? 'publications';

        try {
            switch ($action) {
                case 'publications':
                    $this->controleurPublication->afficherPublications();
                    break;

                case 'publication':
                    // On récupère l'ID propre à la publication cliquée
                    $this->controleurPublication->afficherDetail($this->lireIdGet());
                    break;

                case 'emprunt-ajouter':
                    $this->exigerEcriture($_POST['jeton_csrf'] ?? null);
                    $this->controleurEmprunt->ajouter($_POST);
                    break;

                default:
                    $this->controleurErreur->afficher('Page introuvable.', 404);
            }
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            // Si une exception non interceptée remonte jusqu'ici (ex: ID invalide)
            $this->controleurErreur->afficher($exception->getMessage(), $exception->getCode() ?: 500);
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