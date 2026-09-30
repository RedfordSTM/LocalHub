<?php

declare(strict_types=1);

require_once __DIR__ . '/Modele.php';

class Emprunt extends Modele
{
    public function obtenirTous(?string $ville = null): array
    {
        $filtreVille = $ville !== null ? ' AND publication.ville LIKE :ville' : '';
        $parametres = $ville !== null ? ['ville' => '%' . $ville . '%'] : [];

        return $this->executer(
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
             WHERE publication.type = "outil" AND publication.statut = "active"' . $filtreVille . '
             ORDER BY publication.date_creation DESC',
            $parametres
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenirParId(int $id): ?array
    {
        $requete = $this->executer(
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
             WHERE publication.id_publication = :id AND publication.type = "outil"',
            ['id' => $id]
        );

        $article = $requete->fetch();
        return $article ?: null;
    }

    public function ajouterReservation(
        int $idPublication,
        int $idDemandeur,
        int $idProprietaire,
        string $dateDebut,
        string $dateFin,
        string $message = ''
    ): int {
        $this->executer(
            'INSERT INTO reservation 
             (id_publication, id_demandeur, id_proprietaire, date_debut, date_fin, statut, message)
             VALUES (:id_publication, :id_demandeur, :id_proprietaire, :date_debut, :date_fin, :statut, :message)',
            [
                'id_publication' => $idPublication,
                'id_demandeur' => $idDemandeur,
                'id_proprietaire' => $idProprietaire,
                'date_debut' => $dateDebut,
                'date_fin' => $dateFin,
                'statut' => 'en_attente',
                'message' => $message,
            ]
        );

        // $this->pdo est accessible car hérité de la classe Modele
        return (int) $this->pdo->lastInsertId();
    }

    public function obtenirReservation(int $id): ?array
    {
        $requete = $this->executer(
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
             WHERE reservation.id_reservation = :id',
            ['id' => $id]
        );

        $reservation = $requete->fetch();
        return $reservation ?: null;
    }

    public function annulerReservation(int $id): bool
    {
        $requete = $this->executer(
            'UPDATE reservation SET statut = :statut WHERE id_reservation = :id',
            [
                'id' => $id,
                'statut' => 'annulee',
            ]
        );

        return $requete->rowCount() === 1;
    }
}