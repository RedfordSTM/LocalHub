<?php

declare(strict_types=1);

$nomProjet = 'LocalHub';
$auteur = 'Redford S. St-M.';
$titrePage = 'Accueil';

function afficherAccueil(): void 
{
    global $nomProjet, $auteur, $titrePage;
  
    $messageErreur = null;

    try {

        ob_start();
        require __DIR__ . '/../Vues/accueil.php';
        $contenu = ob_get_clean();
        require __DIR__ . '/../Vues/gabarit.php';

    } catch (Throwable $exception) {

        error_log($exception->getMessage());
        
        $messageErreur = 'Impossible de charger cette page d\'accueil.';

        ob_start();
        require __DIR__ . '/../Vues/erreur.php';
        $contenu = ob_get_clean();
        require __DIR__ . '/../Vues/gabarit.php';
    }
}