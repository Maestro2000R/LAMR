# LAMR CRM — Suivi des agents par site & suivi des moteurs

Application Laravel qui héberge deux modules distincts sous une authentification commune :

- **CRM LAMR** : suivi d'`Agent`s affectés à des `Site`s via des `Assignment`s (affectations).
- **Maintenance moteurs (Les Ateliers MR)** : suivi de l'entretien des moteurs électriques à courant continu — parc moteurs, mesures d'isolement (DAR/PI), usure des balais à charbon.

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
php artisan storage:link   # requis pour les photos (moteurs, balais)
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
- 20 agents (statuts actif/inactif mélangés), 10 sites, 30 affectations (module CRM)
- 2 clients, 2 sites, 3 emplacements, 2 instruments, 2 références de balais et 3 moteurs avec un historique
  de mesures d'isolement et de relevés de balais (module maintenance moteurs)

## Fonctionnalités — CRM LAMR

- **Authentification** : login / inscription / mot de passe oublié (Breeze)
- **Dashboard** (`/dashboard`) : compteurs (agents actifs, sites, affectations en cours) + 5 dernières affectations
- **Agents** (`/agents`) : liste paginée, création, édition, fiche détail avec ses affectations
- **Sites** (`/sites`) : liste avec nombre d'agents affectés, CRUD complet, fiche détail
- **Affectations** (`/assignments`) : CRUD complet, filtres par agent/site, sélection dynamique agent/site
- **API REST** (`/api/*`) : protégée par Sanctum, ressources `agents`, `sites`, `assignments`

## Fonctionnalités — Maintenance moteurs (`/maintenance/*`)

Première itération ("noyau minimal") du cahier des charges *Application de suivi de l'entretien des moteurs
électriques à courant continu* : référentiel moteurs, mesures d'isolement, suivi des balais à charbon.
Hors périmètre de cette itération : workflow d'intervention complet, alertes automatiques, tableaux de bord
dédiés, rapports PDF, mode hors connexion, API, rôles/habilitations différenciés.

- **Référentiel** : `Client` → `Site` → `Emplacement`, `Instrument` (mégohmmètres, avec suivi de validité
  d'étalonnage), catalogue de `Balai` (dimensions, limites, stock)
- **Moteurs** (`/maintenance/moteurs`) : fiche de vie complète (identité, plaque signalétique, construction,
  criticité, documentation photo), QR code généré à la volée renvoyant vers la fiche
- **Mesures d'isolement** : saisie MΩ/GΩ normalisée, calcul automatique du DAR et du PI, classification
  paramétrable (Normal / À surveiller / Critique / Non interprétable) fondée sur le seuil du moteur et la
  tendance par rapport à la dernière mesure comparable (même circuit, même état thermique)
- **Balais à charbon** : positions par moteur, relevés chronologiques, calcul de l'usure cumulée, du
  pourcentage consommé, de la vitesse d'usure, de l'autonomie estimée et du déséquilibre entre balais

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

60 tests couvrant les CRUD web, les relations agent/site/affectation (cascade de suppression), l'API, et pour
le module maintenance : le calcul DAR/PI/classification (`IsolationAnalyzer`), les calculs d'usure des balais
et les cascades de suppression.

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
