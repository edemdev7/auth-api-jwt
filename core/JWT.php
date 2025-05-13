<?php

namespace App\core;

use Firebase\JWT\JWT as FirebaseJWT;
use Firebase\JWT\Key;

class JWT {
    private static string $key = 'votre_clé_secrète'; // À mettre dans le .env en production

    public static function encode(array $payload): string {
        $payload['exp'] = time() + 300; // 5 minutes
        return FirebaseJWT::encode($payload, self::$key, 'HS256');
    }

    public static function decode(string $token): object {
        try {
            return FirebaseJWT::decode($token, new Key(self::$key, 'HS256'));
        } catch (\Exception $e) {
            throw new \Exception('Token invalide');
        }
    }
}