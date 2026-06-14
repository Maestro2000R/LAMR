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
| 01     | Infrastructure & Installation | En cours   |
| 02     | Données de démonstration      | À faire    |
| 03     | Vues Blade — Agents           | À faire    |
| 04     | Vues Blade — Sites & Assignments | À faire |
| 05     | Dashboard & UX                | À faire    |
| 06     | API & Tests                   | À faire    |

## État du projet au démarrage (2026-06-14)

Déjà en place :
- Modèles : `Agent`, `Site`, `Assignment` avec relations Eloquent
- Migrations : 3 tables (`agents`, `sites`, `assignments`)
- Contrôleurs : CRUD complet pour les 3 entités
- Routes : `web.php` avec `Route::resource` protégées par `auth`
