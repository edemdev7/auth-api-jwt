<?php

namespace App\middleware;

use App\core\JWT;

class AuthMiddleware {
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