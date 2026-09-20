# LAMR CRM — Suivi des agents par site

Mini-CRM Laravel pour gérer des `Agent`s affectés à des `Site`s via des `Assignment`s (affectations). Application complète : authentification, CRUD web, dashboard, API REST et tests automatisés.

## Stack

- Laravel 13 / PHP 8.3+
- Blade + Tailwind CSS (Laravel Breeze pour l'authentification)
- SQLite par défaut (zéro configuration pour la démo — voir plus bas pour passer sur MySQL)
- Laravel Sanctum pour l'API

## Installation

```bash
composer install
npm install && npm run build

cp .env.example .env   # si .env n'existe pas déjà
php artisan key:generate

php artisan migrate --seed
```

## Lancer l'application

```bash
php artisan serve
# puis ouvrir http://127.0.0.1:8000
```

Compte de démonstration créé par le seeder :

- Email : `admin@lamr.test`
- Mot de passe : `password`

## Données de démonstration

`php artisan migrate:fresh --seed` régénère la base avec :
- 20 agents (statuts actif/inactif mélangés)
- 10 sites
- 30 affectations (agent ↔ site, avec rôle et période)

## Fonctionnalités

- **Authentification** : login / inscription / mot de passe oublié (Breeze)
- **Dashboard** (`/dashboard`) : compteurs (agents actifs, sites, affectations en cours) + 5 dernières affectations
- **Agents** (`/agents`) : liste paginée, création, édition, fiche détail avec ses affectations
- **Sites** (`/sites`) : liste avec nombre d'agents affectés, CRUD complet, fiche détail
- **Affectations** (`/assignments`) : CRUD complet, filtres par agent/site, sélection dynamique agent/site
- **API REST** (`/api/*`) : protégée par Sanctum, ressources `agents`, `sites`, `assignments`

## API

Obtenir un token :

```bash
curl -X POST http://127.0.0.1:8000/api/tokens \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@lamr.test","password":"password","device_name":"cli"}'
```

Puis appeler l'API avec le header `Authorization: Bearer <token>` :

```bash
curl http://127.0.0.1:8000/api/agents -H "Authorization: Bearer <token>"
```

## Tests

```bash
php artisan test
```

39 tests couvrant les CRUD web, les relations agent/site/affectation (cascade de suppression) et l'API.

## Passer sur MySQL

Par défaut le projet utilise SQLite (`database/database.sqlite`) pour ne nécessiter aucune installation. Pour utiliser MySQL, éditer `.env` :

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lamr_crm
DB_USERNAME=root
DB_PASSWORD=
```

Puis créer la base et relancer les migrations :

```bash
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS lamr_crm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
php artisan migrate:fresh --seed
```

## Structure du projet

Le cahier des charges détaillé (sprints, tâches, critères de validation) se trouve dans [`tasks/`](tasks/README.md).
