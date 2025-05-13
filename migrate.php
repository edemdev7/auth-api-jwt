<?php

global $pdo;
require_once __DIR__ . '/config/database.php';

$sql = file_get_contents(__DIR__ . '/sql/schema.sql');

if ($pdo->exec($sql) !== false) {
    echo " Migration réussie.\n";
} else {
    echo " Erreur de migration.\n";
}
