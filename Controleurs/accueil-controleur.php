<?php

declare(strict_types=1);

class ControleurAccueil
{
    private $vue;
    private $erreurs;

    public function __construct(Vue $vue, ControleurErreur $erreurs)
    {
        $this->vue = $vue;
        $this->erreurs = $erreurs;
    }

    public function afficherAccueil(): void
    {
        try {
            $this->vue->afficher('accueil', [], 'Accueil');
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            $this->erreurs->afficher('Impossible de charger cette page d\'accueil.', 500);
        }
    }
}
