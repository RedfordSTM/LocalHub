<?php

declare(strict_types=1);

function afficherEmprunts(PDO $pdo): void
{
    $outils = obtenirOutils($pdo);
    $titrePage = 'Emprunts et partage de matériel';
    
    require __DIR__ . '/../Vues/emprunts/index.php';
}

function afficherFormulaireEmprunt(PDO $pdo, int $id): void
{
    $outil = obtenirOutilParId($pdo, $id);
    
    if ($outil === null) {
        afficherErreur('Outil introuvable.', 404);
        return;
    }
    
    $titrePage = 'Demander un emprunt - ' . $outil['titre'];
    require __DIR__ . '/../Vues/emprunts/ajouter.php';
}