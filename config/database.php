<?php

// Charger les variables d'environnement
$env = parse_ini_file(__DIR__ . '/../.env');

// Configuration des paramètres de connexion à la base de données
// Utilisation des valeurs par défaut si les variables d'environnement ne sont pas définies

$host = $env['DB_HOST'] ?? '127.0.0.1';
$db   = $env['DB_NAME'] ?? 'auth_db';
$user = $env['DB_USER'] ?? '';
$pass = $env['DB_PASSWORD'] ?? '';
$charset = 'utf8';

// Construction de la chaîne de connexion DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Configuration des options PDO pour une meilleure gestion des erreurs et des performances
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // display PDO errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Return data in array
    PDO::ATTR_EMULATE_PREPARES   => false,                   // prepare statement
];

try {
    // Tentative de connexion à la base de données
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // En cas d'échec de connexion, renvoie une erreur 500 avec le message d'erreur
    http_response_code(500);
    echo json_encode([
        'error' => 'La connexion à la base de donnée a échoué: ' . $e->getMessage()
    ]);
    exit;
}
