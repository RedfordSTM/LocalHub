<?php

declare(strict_types=1);

class ControleurEmprunt
{
    private $emprunt;
    private $vue;
    private $erreurs;

    public function __construct(Emprunt $emprunt, Vue $vue, ControleurErreur $erreurs)
    {
        $this->emprunt = $emprunt;
        $this->vue = $vue;
        $this->erreurs = $erreurs;
    }

    public function afficherEmprunts(): void
    {
        $ville = trim((string) ($_GET['ville'] ?? ''));

        $outils = $this->emprunt->obtenirTous($ville !== '' ? $ville : null);

        $this->vue->afficher(
            'emprunts/emprunts',
            ['outils' => $outils],
            'Emprunts et partage de matériel'
        );
    }

    public function afficherFormulaire(int $id, array $erreurs = [], array $valeurs = []): void
    {
        $outil = $this->emprunt->obtenirParId($id);

        if ($outil === null) {
            $this->erreurs->afficher('Outil introuvable.', 404);
            return;
        }

        $this->vue->afficher(
            'emprunts/ajouter',
            ['outil' => $outil, 'erreurs' => $erreurs, 'valeurs' => $valeurs],
            'Demander un emprunt - ' . $outil['titre']
        );
    }

    public function ajouter(array $donnees): void
    {
        $idPublication = filter_var($donnees['id_publication'] ?? null, FILTER_VALIDATE_INT);
        $dateDebut = trim((string) ($donnees['date_debut'] ?? ''));
        $dateFin = trim((string) ($donnees['date_fin'] ?? ''));
        $message = trim((string) ($donnees['message'] ?? ''));
        $erreurs = [];
        $valeurs = [
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'message' => $message,
        ];

        if ($idPublication === false) {
            $this->erreurs->afficher('Identifiant invalide.', 400);
            return;
        }

        $outil = $this->emprunt->obtenirParId($idPublication);
        if ($outil === null) {
            $this->erreurs->afficher('Outil introuvable.', 404);
            return;
        }

        if ($dateDebut === '') {
            $erreurs['date_debut'] = 'La date de début est obligatoire.';
        } elseif (!$this->validerDate($dateDebut)) {
            $erreurs['date_debut'] = 'Format de date invalide (YYYY-MM-DD).';
        } elseif (strtotime($dateDebut) < strtotime('today')) {
            $erreurs['date_debut'] = 'La date de début doit être aujourd\'hui ou dans le futur.';
        }

        if ($dateFin === '') {
            $erreurs['date_fin'] = 'La date de fin est obligatoire.';
        } elseif (!$this->validerDate($dateFin)) {
            $erreurs['date_fin'] = 'Format de date invalide (YYYY-MM-DD).';
        } elseif (!isset($erreurs['date_debut']) && strtotime($dateFin) <= strtotime($dateDebut)) {
            $erreurs['date_fin'] = 'La date de fin doit être après la date de début.';
        }

        if (mb_strlen($message) > 500) {
            $erreurs['message'] = 'Le message ne doit pas dépasser 500 caractères.';
        }

        if (!empty($erreurs)) {
            $this->afficherFormulaire($idPublication, $erreurs, $valeurs);
            return;
        }

        $this->emprunt->ajouterReservation(
            $idPublication,
            1, // À remplacer par l'ID de l'utilisateur connecté (chapitre 4)
            (int) $outil['id_utilisateur'],
            $dateDebut,
            $dateFin,
            $message
        );

        header('Location: index.php?action=emprunts');
        exit;
    }

    public function afficherConfirmationAnnulation(int $idReservation): void
    {
        $emprunt = $this->emprunt->obtenirReservation($idReservation);

        if ($emprunt === null) {
            $this->erreurs->afficher('Demande d\'emprunt introuvable.', 404);
            return;
        }

        $this->vue->afficher(
            'emprunts/confirmer-suppression',
            ['emprunt' => $emprunt],
            'Annuler la demande d\'emprunt'
        );
    }

    public function annuler(array $donnees): void
    {
        $idReservation = filter_var($donnees['id_reservation'] ?? null, FILTER_VALIDATE_INT);

        if ($idReservation === false) {
            $this->erreurs->afficher('Identifiant invalide.', 400);
            return;
        }

        if ($this->emprunt->obtenirReservation($idReservation) === null) {
            $this->erreurs->afficher('Demande d\'emprunt introuvable.', 404);
            return;
        }

        $this->emprunt->annulerReservation($idReservation);

        header('Location: index.php?action=emprunts');
        exit;
    }

    /**
     * Valider le format d'une date YYYY-MM-DD
     */
    private function validerDate(string $date): bool
    {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return false;
        }

        [$annee, $mois, $jour] = explode('-', $date);

        return checkdate((int) $mois, (int) $jour, (int) $annee);
    }
}
