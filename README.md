# Auth API JWT – API d’authentification en PHP 8.3

Une API REST d’authentification simple et sécurisée basée sur JWT, développée sans framework , en suivant l'architecture MVC.

##  Stack technique

- **Langage :** PHP 8.3 (Programmation orientée objet)
- **Base de données :** MySQL 8.0
- **Autoloader :** Composer
- **Norme API :** JSON only
- **Architecture :** MVC
- **Authentification :** JWT (valide 5 minutes)

---

##  Installation

### 1. Cloner le projet
```bash
git clone https://github.com/edemdev7/auth-api-jwt.git
cd auth-api-jwt
````

### 2. Copier le fichier `.env`

```bash
cp .env.example .env
```

Remplir les informations de connexion à la base de données dans le fichier `.env`.
```bash
DB_HOST=localhost
DB_NAME=auth_db 
DB_USER=votre_user
DB_PASS=votre_password
JWT_SECRET=votre_secret_key
JWT_EXPIRE=300 # 5 minutes en secondes
```



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

##  Structure du projet

```
auth-api-jwt/
├── config/              # Configuration (base de données, etc.)
├── controllers/         # Contrôleurs (AuthController, etc.)
├── core/                # Classes système (Router, Request, JWT, etc.)
├── middlewares/         # Middlewares personnalisés (AuthMiddleware, etc.)
├── sql/          # Fichier SQL (schema.sql)
├── models/              # Modèles (User.php)
├── public/              # Point d’entrée (index.php)
├── .env                 # Variables d’environnement
├── composer.json        # Autoloading & dépendances
├── migrate.php          # Script de migration
└── README.md            # Documentation
```

---

##  Endpoints de l’API

Toutes les requêtes et réponses sont en **JSON**.

###  Inscription

`POST /register`

```json
{
  "email": "test@example.com",
  "password": "password123"
}
```
**Responses :**
- `201 Created`
```json
{
  "message": "Votre compte a été créé avec succès"
}
```
- `400 Bad Request`
```json
{
  "status": "error",
  "message": "Email et mot de passe requis"
}
```

---

###  Connexion

`POST /login`

```json
{
  "email": "test@example.com",
  "password": "password123"
}
```

**Réponse :**
- `200 OK`


```json
{ "status": "success", 
  "message": "Connexion réussie",
  "data": { "token": "eyJhbGciOiJIUzI1NiIs...",
          "user": { "id": 1, 
                  "email": "user@example.com"
          }
  }
}
```
- `401 Unauthorized`
```json
{ "status": "error",
  "message": "Le mot de passe ou mail incorrect"
}

```
---

###  Mettre à jour le nom et prénom

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
**Response :**
-`200 OK`
```json
{
    "message": "Profil mis à jour avec succès"
}
```
-`401 OK`
```json
{
    "message": "Toekn invalide ou expiré"
}
```

---

### Voir les informations de l’utilisateur

`GET /me`

**Header requis :**

```
X-AUTH-TOKEN: <jwt_token>
```

**Réponse :**
-`200 OK`

```json
{
  "email": "test@example.com",
  "first_name": "Jean",
  "last_name": "Dupont"
}
```
-`401 OK`
```json
{
    "message": "Toekn invalide ou expiré"
}
```
---

##  Développement local

Tu peux démarrer le serveur local avec PHP :

```bash
php -S localhost:8000 -t public
```

