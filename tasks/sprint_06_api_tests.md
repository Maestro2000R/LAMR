# Sprint 06 — API & Tests

**Objectif** : Exposer une API REST et couvrir les fonctionnalités critiques par des tests automatisés.

**Dépendance** : Sprints 01 à 04 terminés

**Durée estimée** : 2 sessions

---

## Tâches

### 6.1 API Resources
- [x] Créer `AgentResource` (`php artisan make:resource AgentResource`)
  - Champs exposés : `id`, `name`, `email`, `phone`, `status`, `created_at`
- [x] Créer `SiteResource` (`php artisan make:resource SiteResource`)
  - Champs : `id`, `name`, `address`, `city`
- [x] Créer `AssignmentResource` (`php artisan make:resource AssignmentResource`)
  - Champs : `id`, `agent` (AgentResource imbriqué), `site` (SiteResource imbriqué), `role`, `starts_at`, `ends_at`

### 6.2 Routes API
- [x] Ajouter dans `routes/api.php` :
  ```php
  Route::apiResource('agents', AgentController::class);
  Route::apiResource('sites', SiteController::class);
  Route::apiResource('assignments', AssignmentController::class);
  ```
- [x] Séparer les contrôleurs web et API (créer `App\Http\Controllers\Api\`)
  OU adapter les contrôleurs existants pour répondre JSON si requête API

### 6.3 Authentification API
- [x] Installer Laravel Sanctum : `composer require laravel/sanctum`
- [x] Publier la config et migrer
- [x] Protéger les routes API avec `auth:sanctum`
- [x] Créer une route `POST /api/tokens` pour générer un token

### 6.4 Tests Feature — Agents
- [x] Créer `tests/Feature/AgentTest.php`
  - `test_can_list_agents` : GET `/agents` → 200
  - `test_can_create_agent` : POST avec données valides → 201/302
  - `test_validation_fails_on_missing_name` : POST sans name → 422
  - `test_can_update_agent` : PUT → données mises à jour
  - `test_can_delete_agent` : DELETE → 204/302, plus en base

### 6.5 Tests Feature — Assignments
- [x] Créer `tests/Feature/AssignmentTest.php`
  - `test_assignment_links_agent_and_site`
  - `test_deleting_agent_cascades_assignments`

### 6.6 CI (optionnel)
- [x] Créer `.github/workflows/tests.yml` pour exécuter `php artisan test` sur chaque push

---

## Commandes utiles

```bash
php artisan test                          # tous les tests
php artisan test --filter AgentTest       # tests d'une classe
php artisan test --coverage               # couverture (nécessite Xdebug)
```

---

## Critères de validation

- `GET /api/agents` retourne JSON avec pagination
- `POST /api/agents` sans token → 401
- `php artisan test` : tous les tests passent (aucun failing)
- La cascade de suppression est couverte par un test
