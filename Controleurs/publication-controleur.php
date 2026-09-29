<?php

declare(strict_types=1);

$nomProjet = 'LocalHub';
$auteur = 'Redford S. St-M.';
$titrePage = 'Publications';

function afficherPublications(PDO $pdo):void{
    
    global $nomProjet, $auteur, $titrePage;
    
    $messageErreur = null;
    
    try {
    
        $publications = obtenirPublications($pdo);
    
        require __DIR__ . '/../Vues/publications/publication.php';
    } catch (Throwable $exception) {
        error_log($exception->getMessage());
        $messageErreur = 'Impossible de charger les publications.';
    
        require __DIR__ . '/../Vues/erreur.php';
    }
}
