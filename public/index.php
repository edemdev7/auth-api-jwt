<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/database.php';

use App\core\Router;
use App\controllers\AuthController;
use App\controllers\UserController;

$router = new Router();

// Routes d'authentification
$router->addRoute('POST', '/register', [AuthController::class, 'register']);
$router->addRoute('POST', '/login', [AuthController::class, 'login']);

// Routes utilisateur
$router->addRoute('PUT', '/profile', [UserController::class, 'updateProfile']);
$router->addRoute('GET', '/profile', [UserController::class, 'getProfile']);

$router->route();
