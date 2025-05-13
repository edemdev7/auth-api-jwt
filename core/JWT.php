<?php

namespace App\core;

use Exception;
use Firebase\JWT\JWT as FirebaseJWT;
use Firebase\JWT\Key;

class JWT {
    private static function getKey(): string {
        $env = parse_ini_file(__DIR__ . '/../.env');
        return $env['JWT_SECRET'] ?? 'clé_par_défaut';
    }

    public static function encode(array $payload): string {
        $expireTime = parse_ini_file(__DIR__ . '/../.env')['JWT_EXPIRE'] ?? 300;
        $payload['exp'] = time() + (int)$expireTime;
        return FirebaseJWT::encode($payload, self::getKey(), 'HS256');
    }

    /**
     * @throws Exception
     */
    public static function decode(string $token): object {
        try {
            return FirebaseJWT::decode($token, new Key(self::getKey(), 'HS256'));
        } catch (Exception $e) {
            throw new Exception('Token invalide' . ' ' . $e->getMessage(), 401, $e);;
        }
    }
}