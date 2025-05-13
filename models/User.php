<?php

namespace App\models;

use PDO;

class User
{
    private PDO $db;

    /**
     * Méthode constructeur.
     *
     * @param PDO $pdo L'instance PDO utilisée pour l'interaction avec la base de données.
     * @return void
     */

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    /**
     * Crée un nouveau enregistrement utilisateur dans la base de données.
     *
     * @param string $email L'adresse électronique de l'utilisateur.
     * @param string $password Le mot de passe en clair de l'utilisateur.
     * @return bool Retourne vrai en cas d'insertion réussie, faux sinon.
     */
    public function create(string $email, string $password): bool
    {
        $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
        ]);
    }

    /**
     * Récupère un enregistrement utilisateur dans la base de données en fonction de l'adresse électronique fournie.
     * @param string $email
     * @return array|null
     */
    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    /**
     * Met à jour les noms d'un enregistrement utilisateur dans la base de données.
     * @param int $id
     * @param string $firstName
     * @param string $lastName
     * @return bool
     */
    public function updateNames(int $id, string $firstName, string $lastName): bool
    {
        $sql = "UPDATE users SET firstname = :firstName, lastname = :lastName WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'id' => $id,
        ]);
    }

    /**
     * Récupère un enregistrement utilisateur de la base de données en fonction de l'ID fourni.
     * @param int $id L'ID de l'utilisateur à trouver.
     * @return array|null Un tableau associatif contenant les détails de l'utilisateur s'il est trouvé, ou null si aucun utilisateur n'est trouvé.
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT id, email, firstname, lastname FROM users WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();

        return $user ?: null;
    }
}
