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

function ajouterReservation(
    PDO $pdo,
    int $idPublication,
    int $idDemandeur,
    int $idProprietaire,
    string $dateDebut,
    string $dateFin,
    string $message = ''
): int {
    $requete = $pdo->prepare(
        'INSERT INTO reservation 
         (id_publication, id_demandeur, id_proprietaire, date_debut, date_fin, statut, message)
         VALUES (:id_publication, :id_demandeur, :id_proprietaire, :date_debut, :date_fin, :statut, :message)'
    );

    $requete->execute([
        'id_publication' => $idPublication,
        'id_demandeur' => $idDemandeur,
        'id_proprietaire' => $idProprietaire,
        'date_debut' => $dateDebut,
        'date_fin' => $dateFin,
        'statut' => 'en_attente',
        'message' => $message,
    ]);

    return (int) $pdo->lastInsertId();
}

function obtenirReservation(PDO $pdo, int $id): ?array
{
    $requete = $pdo->prepare(
        'SELECT
            reservation.id_reservation,
            reservation.id_publication,
            reservation.date_debut,
            reservation.date_fin,
            reservation.statut,
            reservation.message,
            publication.titre
         FROM reservation
         INNER JOIN publication
             ON reservation.id_publication = publication.id_publication
         WHERE reservation.id_reservation = :id'
    );

    $requete->execute(['id' => $id]);
    return $requete->fetch() ?: null;
}

function annulerReservation(PDO $pdo, int $id): bool
{
    $requete = $pdo->prepare(
        'UPDATE reservation SET statut = :statut WHERE id_reservation = :id'
    );

    $requete->execute([
        'id' => $id,
        'statut' => 'annulee',
    ]);

    return $requete->rowCount() === 1;
}