<?php

declare(strict_types=1);

/**
 * Lit une variable d'environnement ou lève une exception si elle est absente.
 */
function lireVariable(string $nom): string
{
    $valeur = getenv($nom);
    if ($valeur === false || $valeur === '') {
        throw new RuntimeException("La variable d'environnement '{$nom}' est manquante.");
    }
    return $valeur;
}

// Récupération des paramètres transmis par Apache
$host     = lireVariable('DB_HOST');
$port     = lireVariable('DB_PORT');
$database = lireVariable('DB_DATABASE');
$username = lireVariable('DB_USERNAME');
$password = lireVariable('DB_PASSWORD');

// Format DSN pour MySQL
$dsn = "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Instanciation de la connexion PDO accessible par les fichiers qui font `require`
$pdo = new PDO($dsn, $username, $password, $options);