<?php

declare(strict_types=1);

class ControleurEmprunt extends Modele{

    private $publication;
    private $commentaires;
    private $vue;
    private $erreurs;

    public function afficherEmprunts(PDO $pdo): void
    {
        $outils = obtenirOutils($pdo);
        $titrePage = 'Emprunts et partage de matériel';
        
        require __DIR__ . '/../Vues/emprunts/emprunts.php';
    }
    
    function afficherFormulaireEmprunt(
        PDO $pdo,
        int $id,
        array $erreurs = [],
        array $valeurs = []
    ): void {
        $outil = obtenirOutilParId($pdo, $id);
        
        if ($outil === null) {
            afficherErreur('Outil introuvable.', 404);
            return;
        }
        
        $titrePage = 'Demander un emprunt - ' . $outil['titre'];
        require __DIR__ . '/../Vues/emprunts/ajouter.php';
    }
    
    function ajouterEmpruntAction(PDO $pdo): void
    {
        $idPublication = filter_input(INPUT_POST, 'id_publication', FILTER_VALIDATE_INT);
        $dateDebut = trim((string) ($_POST['date_debut'] ?? ''));
        $dateFin = trim((string) ($_POST['date_fin'] ?? ''));
        $message = trim((string) ($_POST['message'] ?? ''));
        $erreurs = [];
        $valeurs = [
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'message' => $message,
        ];
    
        // Valider l'identifiant de la publication
        if ($idPublication === false || $idPublication === null) {
            afficherErreur('Identifiant invalide.', 400);
            return;
        }
    
        // Vérifier que l'outil existe
        $outil = obtenirOutilParId($pdo, $idPublication);
        if ($outil === null) {
            afficherErreur('Outil introuvable.', 404);
            return;
        }
    
        // Valider les dates
        if (empty($dateDebut)) {
            $erreurs['date_debut'] = 'La date de début est obligatoire.';
        } elseif (!validerDate($dateDebut)) {
            $erreurs['date_debut'] = 'Format de date invalide (YYYY-MM-DD).';
        } elseif (strtotime($dateDebut) < strtotime('today')) {
            $erreurs['date_debut'] = 'La date de début doit être aujourd\'hui ou dans le futur.';
        }
    
        if (empty($dateFin)) {
            $erreurs['date_fin'] = 'La date de fin est obligatoire.';
        } elseif (!validerDate($dateFin)) {
            $erreurs['date_fin'] = 'Format de date invalide (YYYY-MM-DD).';
        } elseif (!empty($dateDebut) && strtotime($dateFin) <= strtotime($dateDebut)) {
            $erreurs['date_fin'] = 'La date de fin doit être après la date de début.';
        }
    
        // Valider le message optionnel
        if (mb_strlen($message) > 500) {
            $erreurs['message'] = 'Le message ne doit pas dépasser 500 caractères.';
        }
    
        // S'il y a des erreurs, recharger le formulaire
        if (!empty($erreurs)) {
            afficherFormulaireEmprunt($pdo, $idPublication, $erreurs, $valeurs);
            return;
        }
    
        // Ajouter la réservation
        $idReservation = ajouterReservation(
            $pdo,
            $idPublication,
            1, // À remplacer par l'ID de l'utilisateur connecté (chapitre 4)
            (int) $outil['id_utilisateur'],
            $dateDebut,
            $dateFin,
            $message
        );
    
        // Rediriger vers la liste
        header('Location: index.php?action=emprunts');
        exit;
    }
    
    function afficherConfirmationAnnulationEmprunt(PDO $pdo, int $idReservation): void
    {
        $emprunt = obtenirReservation($pdo, $idReservation);
    
        if ($emprunt === null) {
            afficherErreur('Demande d\'emprunt introuvable.', 404);
            return;
        }
    
        $titrePage = 'Annuler la demande d\'emprunt';
        require __DIR__ . '/../Vues/emprunts/confirmer-suppression.php';
    }
    
    function annulerEmpruntAction(PDO $pdo): void
    {
        $idReservation = filter_input(INPUT_POST, 'id_reservation', FILTER_VALIDATE_INT);
    
        if ($idReservation === false || $idReservation === null) {
            afficherErreur('Identifiant invalide.', 400);
            return;
        }
    
        $emprunt = obtenirReservation($pdo, $idReservation);
    
        if ($emprunt === null) {
            afficherErreur('Demande d\'emprunt introuvable.', 404);
            return;
        }
    
        // Annuler la réservation
        annulerReservation($pdo, $idReservation);
    
        // Rediriger vers la liste des emprunts
        header('Location: index.php?action=emprunts');
        exit;
    }
    
    /**
     * Valider le format d'une date YYYY-MM-DD
     */
    function validerDate(string $date): bool
    {
        $pattern = '/^\d{4}-\d{2}-\d{2}$/';
        if (!preg_match($pattern, $date)) {
            return false;
        }
        
        [$annee, $mois, $jour] = explode('-', $date);
        return checkdate((int) $mois, (int) $jour, (int) $annee);
    }
}