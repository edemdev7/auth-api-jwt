<?php

require_once __DIR__ . '/../config/database.php';

class User
{
    private PDO $db;

    /**
     * Constructor method.
     *
     * @param PDO $pdo The PDO instance used for database interaction.
     * @return void
     */

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    /**
     * Creates a new user record in the database.
     *
     * @param string $email The email address of the user.
     * @param string $password The plain text password of the user.
     * @return bool Returns true on successful insertion, false otherwise.
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
     * Retrieves a user record from the database based on the given email address.
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
     * Updates the names of a user record in the database.
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
     * Retrieves a user record from the database based on the given ID.
     * @param int $id The ID of the user to find.
     * @return array|null An associative array containing user details if found, or null if no user is found.
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
