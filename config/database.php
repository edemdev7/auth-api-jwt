<?php

// Charger les variables d'environnement
$env = parse_ini_file(__DIR__ . '/../.env');

$host = isset($env['DB_HOST']) ? $env['DB_HOST'] : '127.0.0.1';
$db   = isset($env['DB_NAME']) ? $env['DB_NAME'] : 'auth_db';
$user = isset($env['DB_USER']) ? $env['DB_USER'] : 'root';
$pass = isset($env['DB_PASSWORD']) ? $env['DB_PASSWORD'] : '';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Afficher les erreurs PDO
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Retourner les résultats en tableaux associatifs
    PDO::ATTR_EMULATE_PREPARES   => false,                   // Préparer les requêtes nativement
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Database connection failed: ' . $e->getMessage()
    ]);
    exit;
}
