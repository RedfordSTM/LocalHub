<?php

declare(strict_types=1);

function obtenirPublications(PDO $pdo): array
{
    $requete = $pdo->prepare(
        'SELECT
            publication.id_publication,
            publication.titre,
            publication.description,
            publication.type,
            publication.prix,
            publication.ville,
            publication.date_creation,
            utilisateur.prenom,
            utilisateur.nom,
            categorie.nom AS categorie
         FROM publication
         INNER JOIN utilisateur
             ON publication.id_utilisateur = utilisateur.id_utilisateur
         INNER JOIN categorie
             ON publication.id_categorie = categorie.id_categorie
         WHERE publication.statut = "active"
         ORDER BY publication.date_creation DESC'
    );

    $requete->execute();

    return $requete->fetchAll(PDO::FETCH_ASSOC);
}