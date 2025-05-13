<?php

namespace App\core;

use Exception;
use Firebase\JWT\JWT as FirebaseJWT;
use Firebase\JWT\Key;

class JWT {
    /**
     * Récupère la clé secrète JWT du fichier d'environnement.
     *
     * @return string La clé secrète JWT ou une valeur par défaut si elle n'est pas définie.
     */
    private static function getKey(): string {
        $env = parse_ini_file(__DIR__ . '/../.env');
        return $env['JWT_SECRET'] ?? 'clé_par_défaut';
    }

    /**
     * Encode les données du payload en un jeton JWT signé.
     *
     * @param array $payload Les données à encoder dans le jeton.
     * @return string Le jeton JWT signé.
     */
    public static function encode(array $payload): string {
        $expireTime = parse_ini_file(__DIR__ . '/../.env')['JWT_EXPIRE'] ?? 300;
        $payload['exp'] = time() + (int)$expireTime;
        return FirebaseJWT::encode($payload, self::getKey(), 'HS256');
    }

    /**
     * Decode un token JWT en utilisant la clé secrète et l'algorithme spécifiés.
     *
     * @param string $token Le token JWT à décoder.
     * @return object Les données décodées du token JWT.
     * @throws Exception Si le token est invalide ou en cas d'erreur de décodage.
     */
    public static function decode(string $token): object {
        try {
            return FirebaseJWT::decode($token, new Key(self::getKey(), 'HS256'));
        } catch (Exception $e) {
            throw new Exception('Token invalide' . ' ' . $e->getMessage(), 401, $e);;
        }
    }
}