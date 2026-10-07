<?php

declare(strict_types=1);

class ControleurUtilisateur
{
    private $courriel;
    private $authentification;
    private $vue;

    public function __construct(
        Utilisateur $utilisateurs,
        Authentification $authentification,
        Vue $vue
    ) {
        $this->utilisateurs = $utilisateurs;
        $this->authentification = $authentification;
        $this->vue = $vue;
    }

    public function connexion(?string $erreur = null, string $identifiant = ''): void
    {
        $this->vue->afficher(
            'utilisateurs/connexion',
            compact('erreur', 'identifiant'),
            'Connexion'
        );
    }

    public function authentifier(array $donnees): void
    {
        $identifiant = trim((string) ($donnees['identifiant'] ?? ''));
        $motDePasse = (string) ($donnees['mot_de_passe'] ?? '');
        $utilisateur = $this->utilisateurs->trouverParIdentifiant($identifiant);

        if ($utilisateur === null
            || !password_verify($motDePasse, $utilisateur['mot_de_passe'])) {
            $this->connexion('Identifiant ou mot de passe invalide.', $identifiant);
            return;
        }

        $this->authentification->connecter($utilisateur);
        header('Location: index.php?action=articles');
        exit;
    }

    public function deconnecter(): void
    {
        $this->authentification->deconnecter();
        header('Location: index.php?action=articles');
        exit;
    }
}
