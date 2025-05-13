<?php

namespace App\controllers;

use AllowDynamicProperties;
use App\core\JWT;
use PDOException;
use App\models\User;

#[AllowDynamicProperties] class AuthController {

    public function __construct() {
        require_once __DIR__ . '/../config/database.php';
        global $pdo;
        $this->userModel = new User($pdo);
    }

    /**
     * Gère l'inscription d'un nouvel utilisateur
     */
    public function register(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['email']) || !isset($data['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Email et mot de passe requis']);
            return;
        }

        $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
        if (!$email) {
            http_response_code(400);
            echo json_encode(['error' => 'Format d\'email invalide']);
            return;
        }

        try {
            if ($this->userModel->create($email, $data['password'])) {
                http_response_code(201);
                echo json_encode(['message' => 'Utilisateur créé avec succès']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Erreur lors de la création de l\'utilisateur']);
            }
        } catch (PDOException $e) {
            http_response_code(400);
            echo json_encode(['error' => 'Email déjà utilisé' . ' ' .$e->getMessage()]);
        }
    }

    /**
     * Gère la connexion d'un utilisateur
     */
    public function login(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['email']) || !isset($data['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Email et mot de passe requis']);
            return;
        }

        $user = $this->userModel->findByEmail($data['email']);

        if (!$user || !password_verify($data['password'], $user['password'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Identifiants invalides']);
            return;
        }

        $token = JWT::encode([
            'user_id' => $user['id'],
            'email' => $user['email']
        ]);

        echo json_encode(['token' => $token]);
    }
}