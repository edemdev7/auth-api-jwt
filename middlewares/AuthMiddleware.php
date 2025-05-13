<?php

namespace App\middlewares;

use App\core\JWT;

class AuthMiddleware {
    /**
     * Authentifie un utilisateur en validant le jeton JWT fourni dans les en-têtes de la requête.
     *Si le jeton est manquant, invalide ou expiré, la méthode envoie une réponse HTTP 401 et termine
     * l'exécution du script.
     * @return object Jeton JWT décodé si l'authentification réussit.
     */
    public static function authenticate() {
        $headers = getallheaders();
        $token = $headers['X-Auth-Token'] ?? null;

        if (!$token) {
            http_response_code(401);
            echo json_encode(['error' => 'Token d\'authentification manquant']);
            exit;
        }

        try {
            return JWT::decode($token);
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode(['error' => 'Token invalide ou expiré']);
            exit;
        }
    }
}