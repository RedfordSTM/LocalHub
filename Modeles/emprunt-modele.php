<?php

declare(strict_types=1);

function obtenirOutils(PDO $pdo): array
{
    $requete = $pdo->prepare(
        'SELECT
            publication.id_publication,
            publication.titre,
            publication.description,
            publication.ville,
            utilisateur.prenom,
            utilisateur.nom,
            categorie.nom AS categorie
         FROM publication
         INNER JOIN utilisateur
             ON publication.id_utilisateur = utilisateur.id_utilisateur
         INNER JOIN categorie
             ON publication.id_categorie = categorie.id_categorie
         WHERE publication.type = "outil" AND publication.statut = "active"
         ORDER BY publication.date_creation DESC'
    );

    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

function obtenirOutilParId(PDO $pdo, int $id): ?array
{
    $requete = $pdo->prepare(
        'SELECT
            publication.id_publication,
            publication.titre,
            publication.description,
            publication.ville,
            publication.id_utilisateur,
            utilisateur.prenom,
            utilisateur.nom
         FROM publication
         INNER JOIN utilisateur
             ON publication.id_utilisateur = utilisateur.id_utilisateur
         WHERE publication.id_publication = :id AND publication.type = "outil"'
    );

    $requete->execute(['id' => $id]);
    return $requete->fetch() ?: null;
}