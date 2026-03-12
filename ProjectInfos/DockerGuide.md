# Docker & Project Commands Guide - EJoutiya

Ce guide contient toutes les commandes essentielles pour gérer votre environnement de développement Docker.

## 1. Gestion de l'environnement (Root)

| Action | Commande |
| :--- | :--- |
| **Lancer le projet** | `docker-compose up -d` |
| **Arrêter le projet** | `docker-compose down` |
| **Reconstruire les images** | `docker-compose up -d --build` |
| **Voir les logs** | `docker-compose logs -f` |
| **Statut des containers** | `docker-compose ps` |

---

## 2. Accès aux Terminaux (Bash/Shell)

Pour entrer à l'intérieur d'un container et exécuter des commandes :

- **Backend (PHP/Laravel):**
  ```bash
  docker-compose exec backend bash
  ```
- **Frontend (Node/React):**
  ```bash
  docker-compose exec frontend sh
  ```
- **Base de données (PostgreSQL):**
  ```bash
  docker-compose exec postgres psql -U reddcs -d ejoutiya_db
  ```

---

## 3. Commandes Laravel (via Docker)

Vous pouvez exécuter ces commandes depuis votre machine hôte sans entrer dans le container :

| Action | Commande |
| :--- | :--- |
| **Migrations** | `docker-compose exec backend php artisan migrate` |
| **Seeders** | `docker-compose exec backend php artisan db:seed` |
| **Générer Clé** | `docker-compose exec backend php artisan key:generate` |
| **Installer Packages** | `docker-compose exec backend composer install` |
| **Créer Contrôleur** | `docker-compose exec backend php artisan make:controller NameController` |
| **Nettoyer Cache** | `docker-compose exec backend php artisan optimize:clear` |

---

## 4. Ports et Accès Services

| Service | URL / Port | Credentials (si applicable) |
| :--- | :--- | :--- |
| **Frontend (React)** | [http://localhost:5173](http://localhost:5173) | - |
| **Backend (API)** | [http://localhost:3535](http://localhost:3535) | - |
| **pgAdmin (DB GUI)** | [http://localhost:5050](http://localhost:5050) | `reddcs@gmail.com` / `reddcs` |
| **PostgreSQL** | `localhost:2004` | User: `reddcs` / Pass: `reddcs` |
| **PlantUML** | [http://localhost:4040](http://localhost:4040) | - |

---

## 5. Résolution des problèmes fréquents

- **Erreurs de permissions :**
  Si vous créez des fichiers manuellement et qu'ils sont verrouillés, lancez :
  ```bash
  docker run --rm -v $(pwd):/app -w /app alpine chown -R 1000:1000 .
  ```
- **Nettoyage complet :**
  Pour supprimer les volumes (attention: supprime la base de données) :
  ```bash
  docker-compose down -v
  ```
