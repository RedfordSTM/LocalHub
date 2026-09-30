<?php

declare(strict_types=1);

class Vue
{
    /** @var array Données disponibles dans toutes les vues (nom du projet, auteur...) */
    private array $donneesPartagees;

    public function __construct(array $donneesPartagees = [])
    {
        $this->donneesPartagees = $donneesPartagees;
    }

    public function afficher(string $fichier, array $donnees = [], string $titrePage = ''): void
    {
        $chemin = __DIR__ . '/' . $fichier . '.php';

        if (!is_file($chemin)) {
            throw new RuntimeException('Vue introuvable.');
        }

        extract(array_merge($this->donneesPartagees, $donnees), EXTR_SKIP);

        // La vue produit seulement un fragment HTML ; le gabarit l'entoure ensuite.
        ob_start();
        try {
            require $chemin;
            $contenu = ob_get_clean();
        } catch (Throwable $exception) {
            ob_end_clean();
            throw $exception;
        }

        require __DIR__ . '/gabarit.php';
    }
}
