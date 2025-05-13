<?php

namespace App\controllers;

use AllowDynamicProperties;
use App\core\JWT;
use PDOException;
use App\models\User;

#[AllowDynamicProperties] class AuthController {

    public function __construct() {
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
                echo json_encode(['message' => 'Votre compte a été créé avec succès']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Erreur lors de  de l\'inscription']);
            }
        } catch (PDOException $e) {
            http_response_code(400);
            echo json_encode(['error' => 'Email déjà utilisé' . ' ' .$e->getMessage()]);
        }
    }

    /**
     * Authentifie un utilisateur en vérifiant ses identifiants (email et mot de passe).
     *
     * @return void
     */
    public function login(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['email']) || !isset($data['password'])) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'L\'adresse email et le mot de passe sont requis'
            ]);
            return;
        }
        // recherchez si un utilisateur existe avec cette adresse email
        $user = $this->userModel->findByEmail($data['email']);
        // renvoyez une erreur si l'utilisateur n'existe pas
        if (!$user) {
            http_response_code(401);
            echo json_encode([
                'status' => 'error',
                'message' => 'Cette adresse email n\'existe pas'
            ]);
            return;
        }
        // renvoyez une erreur si le mot de passe est incorrect
        if (!password_verify($data['password'], $user['password'])) {
            http_response_code(401);
            echo json_encode([
                'status' => 'error',
                'message' => 'Le mot de passe est incorrect'
            ]);
            return;
        }

        // envoyez un jeton JWT avec les informations de l'utilisateur'
        $token = JWT::encode([
            'user_id' => $user['id'],
            'email' => $user['email']
        ]);

        http_response_code(200);
        // retourner les informations de l'utilisateur et le jeton JWT'
        echo json_encode([
            'status' => 'success',
            'message' => 'Connexion réussie',
            'data' => [
                'token' => $token,
                'user' => [
                    'id' => $user['id'],
                    'email' => $user['email']
                ]
            ]
        ]);
    }
}