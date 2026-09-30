<?php

declare(strict_types=1);

class ControleurAccueil 
{
    private $vue;
    private $publications;
    private $emprunts;
    private $erreurs;

    // On reçoit les outils nécessaires par le constructeur
    public function __construct(Vue $vue, Publication $publications, Emprunts $emprunts, ControleurErreur $erreurs) 
    {
        $this->vue = $vue;
        $this->publication = $publications;
        $this->emprunts = $emprunts;
        $this->erreurs = $erreurs;
    }

    public function afficherAccueil(): void
    {
        try {
            // La classe Vue s'occupe de tout (gabarit, inclusion, etc.)
            $this->vue->afficher('accueil', [], 'Accueil');

        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            
            // On délégue l'affichage de l'erreur au contrôleur d'erreurs
            $this->erreurs->afficher('Impossible de charger cette page d\'accueil.', 500);
        }
    }
}