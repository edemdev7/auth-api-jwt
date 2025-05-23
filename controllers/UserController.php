<?php

namespace App\controllers;

use App\middlewares\AuthMiddleware;
use Exception;
use App\models\User;

class UserController {
    private User $userModel;

    public function __construct() {
        global $pdo;
        $this->userModel = new User($pdo);
    }

    /**
     * Met à jour le profil de l'utilisateur avec les données fournies.
     *Cette méthode authentifie l'utilisateur et valide les données de saisie (firstname et lastname).
     * Si elles sont valides, elle tente de mettre à jour le profil de l'utilisateur dans la base de données.
     * Les réponses sont envoyées au format JSON, avec les codes de statut HTTP appropriés en fonction du résultat de l'opération.
     * @return void
     */
    public function updateProfile(): void
    {

        $payload = AuthMiddleware::authenticate();
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['firstname']) || !isset($data['lastname'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Prénom et nom requis']);
            return;
        }

        try {
            if ($this->userModel->updateNames($payload->user_id, $data['firstname'], $data['lastname'])) {
                echo json_encode(['message' => 'Profil mis à jour avec succès']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Erreur lors de la mise à jour du profil']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur lors de la mise à jour du profil' . ' ' .$e->getMessage()]);
        }
    }

    /**
     * Consultation des informations de l'utilisateur
     */
    public function getProfile(): void
    {
        $payload = AuthMiddleware::authenticate();

        try {
            $user = $this->userModel->findById($payload->user_id);
            if ($user) {
                echo json_encode([
                    'email' => $user['email'],
                    'firstname' => $user['firstname'],
                    'lastname' => $user['lastname']
                ]);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Utilisateur non trouvé']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur lors de la récupération du profil' . ' ' .$e->getMessage()]);
        }
    }
}