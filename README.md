# Auth API JWT – Projet d’authentification en PHP 8.3

Une API REST d’authentification simple et sécurisée basée sur JSON Web Tokens (JWT), développée sans framework (ni Laravel, ni Symfony), en suivant l'architecture MVC.

## 🔧 Stack technique

- **Langage :** PHP 8.3 (Programmation orientée objet)
- **Base de données :** MySQL 8.0
- **Autoloader :** Composer
- **Norme API :** JSON only
- **Architecture :** MVC
- **Authentification :** JWT (valide 5 minutes)

---

## 🚀 Installation

### 1. Cloner le projet
```bash
git clone https://github.com/ton-utilisateur/auth-api-jwt.git
cd auth-api-jwt
````

### 2. Copier le fichier `.env`

```bash
cp .env.example .env
```

Remplir les informations de connexion à la base de données dans le fichier `.env`.

### 3. Installer les dépendances

Assurez-vous que [Composer](https://getcomposer.org/) est installé.

```bash
composer install
```

### 4. Créer la base de données MySQL

Connecte-toi à MySQL et exécute :

```sql
CREATE DATABASE auth_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```

### 5. Lancer la migration

```bash
composer migrate
```

---

## 📦 Structure du projet

```
auth-api-jwt/
├── config/              # Configuration (base de données, etc.)
├── controllers/         # Contrôleurs (AuthController, etc.)
├── core/                # Classes système (Router, Request, JWT, etc.)
├── middlewares/         # Middlewares personnalisés (AuthMiddleware, etc.)
├── migrations/          # Fichier SQL (schema.sql)
├── models/              # Modèles (User.php)
├── public/              # Point d’entrée (index.php)
├── .env                 # Variables d’environnement
├── composer.json        # Autoloading & dépendances
├── migrate.php          # Script de migration
└── README.md            # Documentation
```

---

## 🔐 Endpoints de l’API

Toutes les requêtes et réponses sont en **JSON**.

### ✅ Inscription

`POST /register`

```json
{
  "email": "test@example.com",
  "password": "password123"
}
```

---

### ✅ Connexion

`POST /login`

```json
{
  "email": "test@example.com",
  "password": "password123"
}
```

**Réponse :**

```json
{
  "token": "eyJ0eXAiOiJKV1QiLCJh..."
}
```

---

### ✅ Mettre à jour le nom et prénom

`PUT /me`

**Header requis :**

```
X-AUTH-TOKEN: <jwt_token>
```

**Corps JSON :**

```json
{
  "first_name": "Jean",
  "last_name": "Dupont"
}
```

---

### ✅ Voir les informations de l’utilisateur

`GET /me`

**Header requis :**

```
X-AUTH-TOKEN: <jwt_token>
```

**Réponse :**

```json
{
  "email": "test@example.com",
  "first_name": "Jean",
  "last_name": "Dupont"
}
```

---

## 🛠 Développement local

Tu peux démarrer le serveur local avec PHP :

```bash
php -S localhost:8000 -t public
```

