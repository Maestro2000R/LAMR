# Sprint 04 — Vues Blade — Sites & Assignments

**Objectif** : CRUD complet pour les sites et les assignments.

**Dépendance** : Sprint 03 terminé (layout et patterns Blade en place)

**Durée estimée** : 1-2 sessions

---

## Tâches

### 4.1 Vues Sites
- [ ] Créer `resources/views/sites/index.blade.php`
  - Tableau : nom, adresse, ville, nombre d'agents affectés, actions
  - Bouton "Nouveau site"
- [ ] Créer `resources/views/sites/create.blade.php`
  - Champs : name, address, city
- [ ] Créer `resources/views/sites/edit.blade.php`
  - Pré-remplissage des champs
- [ ] Créer `resources/views/sites/show.blade.php`
  - Informations du site
  - Liste des assignments actifs (agents affectés)

### 4.2 Vues Assignments
- [ ] Créer `resources/views/assignments/index.blade.php`
  - Tableau : agent, site, rôle, date début, date fin, actions
  - Filtres optionnels : par agent, par site, par date
- [ ] Créer `resources/views/assignments/create.blade.php`
  - Champs : agent (select), site (select), role, starts_at, ends_at
  - Les selects chargent les données depuis la base
- [ ] Créer `resources/views/assignments/edit.blade.php`
  - Pré-remplissage, avec `@method('PUT')`
- [ ] Créer `resources/views/assignments/show.blade.php`
  - Détail de l'assignment avec liens vers l'agent et le site

### 4.3 Mise à jour des contrôleurs
- [ ] `SiteController::index()` : ajouter `withCount('assignments')`
- [ ] `SiteController::show()` : charger `assignments.agent`
- [ ] `AssignmentController::create()` : passer `$agents` et `$sites` à la vue
- [ ] `AssignmentController::edit()` : idem

---

## Exemple — Contrôleur AssignmentController::create()

```php
public function create()
{
    $agents = \App\Models\Agent::where('status', 'active')->orderBy('name')->get();
    $sites  = \App\Models\Site::orderBy('name')->get();
    return view('assignments.create', compact('agents', 'sites'));
}
```

---

## Critères de validation

- `/sites` affiche le nombre d'agents par site
- Créer un assignment depuis le formulaire avec des selects dynamiques
- `/assignments` liste toutes les affectations avec noms d'agent et de site
- La suppression d'un agent cascade sur ses assignments (vérifier en base)
