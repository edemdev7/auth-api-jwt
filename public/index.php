<?php

// Définition du type de contenu comme JSON avec encodage UTF-8
header('Content-Type: application/json; charset=utf-8');

// Chargement de l'autoloader de Composer et de la configuration de la base de données
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/database.php';

use App\core\Router;
use App\controllers\AuthController;
use App\controllers\UserController;

// Initialisation du routeur
$router = new Router();

// Routes d'authentification
$router->addRoute('POST', '/register', [AuthController::class, 'register']);
$router->addRoute('POST', '/login', [AuthController::class, 'login']);

// Routes utilisateur
$router->addRoute('PUT', '/profile', [UserController::class, 'updateProfile']);
$router->addRoute('GET', '/profile', [UserController::class, 'getProfile']);

// Traitement de la requête
$router->route();
