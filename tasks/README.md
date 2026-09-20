# Workflow de développement — Tasks

Ce dossier contient les sprints et tâches du projet mini-CRM LAMR.

## Comment utiliser ce workflow

1. **Début de session** : ouvrir le sprint en cours, identifier la première tâche `[ ]`
2. **Démarrage d'une tâche** : passer le statut à `[~]` (en cours)
3. **Fin de tâche** : passer le statut à `[x]` (terminé), committer le fichier
4. **Fin de sprint** : toutes les tâches `[x]` → ouvrir le sprint suivant

## Statuts

| Symbole | Signification |
|---------|---------------|
| `[ ]`   | À faire       |
| `[~]`   | En cours      |
| `[x]`   | Terminé       |
| `[!]`   | Bloqué        |

## Sprints

| Sprint | Titre                        | Statut     |
|--------|------------------------------|------------|
| 01     | Infrastructure & Installation | Terminé   |
| 02     | Données de démonstration      | Terminé    |
| 03     | Vues Blade — Agents           | Terminé    |
| 04     | Vues Blade — Sites & Assignments | Terminé |
| 05     | Dashboard & UX                | Terminé    |
| 06     | API & Tests                   | Terminé    |

## État du projet (2026-09-20)

Application Laravel complète et fonctionnelle :
- Modèles : `Agent`, `Site`, `Assignment` avec relations Eloquent
- Migrations : 3 tables (`agents`, `sites`, `assignments`), exécutées sur SQLite (démo locale sans MySQL)
- Contrôleurs web : CRUD complet pour les 3 entités, avec pagination, filtres et eager loading
- Vues Blade : layout Breeze (`x-app-layout`), navigation, messages flash, formulaires avec validation inline
- Authentification : Laravel Breeze (login/register/mot de passe oublié), utilisateur de démo `admin@lamr.test` / `password`
- Dashboard : compteurs (agents actifs, sites, affectations en cours) + 5 dernières affectations
- Seeders/Factories : 20 agents, 10 sites, 30 affectations générés via Faker
- API REST : `routes/api.php` protégée par Sanctum (`agents`, `sites`, `assignments` + `POST /api/tokens`)
- Tests : 39 tests Feature (`php artisan test`), tous verts
- CI : `.github/workflows/tests.yml` exécute la suite de tests sur chaque push
