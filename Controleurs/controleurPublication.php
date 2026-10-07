<?php

declare(strict_types=1);

class ControleurPublication 
{
    private $publicationModele;
    private $vue;
    private $erreurs;

    // Injection des dépendances par le constructeur
    public function __construct(Publication $publicationModele, Vue $vue, ControleurErreur $erreurs) 
    {
        $this->publicationModele = $publicationModele;
        $this->vue = $vue;
        $this->erreurs = $erreurs;
    }

    public function afficherPublications(): void
    {
        try {
            // Appel de la méthode orientée objet du modèle (sans passer $pdo)
            $publications = $this->publicationModele->obtenirPublications();

            // Utilisation centralisée de la classe Vue
            $this->vue->afficher('publications/publication', [
                'publications' => $publications
            ], 'Publications');

        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            
            // Délégation de l'erreur au contrôleur d'erreurs
            $this->erreurs->afficher('Impossible de charger les publications.', 500);
        }
    }
}