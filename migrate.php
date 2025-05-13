<?php

global $pdo;
require_once __DIR__ . '/config/database.php';
// Lecture du fichier SQL contenant le schéma de la base de données

$sql = file_get_contents(__DIR__ . '/sql/schema.sql');
// Exécution des migrations

if ($pdo->exec($sql) !== false) {
    echo " Les migrations ont été exécutées avec succès.\n";
} else {
    echo " Une erreur s'est produite lors de l'exécution des migrations.\n";
}

