# Sprint 02 — Données de démonstration

**Objectif** : Peupler la base avec des données réalistes pour tester l'interface.

**Dépendance** : Sprint 01 terminé (`php artisan migrate` OK)

**Durée estimée** : 1 session

---

## Tâches

### 2.1 Factories
- [ ] Créer `AgentFactory` (`php artisan make:factory AgentFactory --model=Agent`)
  - Champs : `name` (faker), `email` (unique), `phone` (nullable), `status` (active/inactive aléatoire)
- [ ] Créer `SiteFactory` (`php artisan make:factory SiteFactory --model=Site`)
  - Champs : `name`, `address`, `city`
- [ ] Créer `AssignmentFactory` (`php artisan make:factory AssignmentFactory --model=Assignment`)
  - Champs : `agent_id`, `site_id`, `starts_at`, `ends_at`, `role`

### 2.2 Seeder principal
- [ ] Créer `DemoSeeder` (`php artisan make:seeder DemoSeeder`)
- [ ] Implémenter le seeder :
  - 20 agents (mix actifs/inactifs)
  - 10 sites
  - 30 assignments (relations variées)
- [ ] Enregistrer `DemoSeeder` dans `DatabaseSeeder::run()`

### 2.3 Exécution et vérification
- [ ] Exécuter `php artisan db:seed --class=DemoSeeder`
- [ ] Vérifier les données via `php artisan tinker` :
  ```php
  App\Models\Agent::count();   // 20
  App\Models\Site::count();    // 10
  App\Models\Assignment::count(); // ~30
  ```
- [ ] Vérifier qu'un agent peut avoir plusieurs assignments : `Agent::first()->assignments`

---

## Exemple de factory Agent

```php
public function definition(): array
{
    return [
        'name'   => $this->faker->name(),
        'email'  => $this->faker->unique()->safeEmail(),
        'phone'  => $this->faker->optional()->phoneNumber(),
        'status' => $this->faker->randomElement(['active', 'inactive']),
    ];
}
```

---

## Critères de validation

- `Agent::count()` retourne 20
- `Assignment::with('agent', 'site')->first()` charge les relations sans erreur
- `php artisan migrate:fresh --seed` repart de zéro sans erreur
