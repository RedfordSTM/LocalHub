<?php

declare(strict_types=1);

class Authentification
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'secure' => !empty($_SERVER['HTTPS']),
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
            session_start();
        }
    }

    public function connecter(array $utilisateur): void
    {
        session_regenerate_id(true);
        $_SESSION['utilisateur'] = [
            'id_utilisateur' => (int) $utilisateur['id'],
            'nom' => $utilisateur['nom'],
        ];
    }

    public function utilisateur(): ?array
    {
        return $_SESSION['utilisateur'] ?? null;
    }

    public function deconnecter(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $parametres = session_get_cookie_params();
            setcookie(session_name(), '', [
                'expires' => time() - 3600,
                'path' => $parametres['path'],
                'domain' => $parametres['domain'],
                'secure' => $parametres['secure'],
                'httponly' => $parametres['httponly'],
                'samesite' => 'Lax',
            ]);
        }

        session_destroy();
    }
}
