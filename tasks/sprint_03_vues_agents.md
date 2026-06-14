# Sprint 03 — Vues Blade — Agents

**Objectif** : CRUD complet pour les agents avec interface Blade fonctionnelle.

**Dépendance** : Sprint 01 terminé, Sprint 02 recommandé (données de test)

**Durée estimée** : 1-2 sessions

---

## Tâches

### 3.1 Layout principal
- [ ] Créer `resources/views/layouts/app.blade.php`
  - Navigation : liens vers Agents, Sites, Assignments
  - Messages flash (succès / erreur)
  - Inclusion de Tailwind CSS (via CDN ou assets compilés)

### 3.2 Vue index — Liste des agents
- [ ] Créer `resources/views/agents/index.blade.php`
  - Tableau : nom, email, téléphone, statut, actions (Voir / Éditer / Supprimer)
  - Badge coloré pour le statut (vert = active, gris = inactive)
  - Bouton "Nouvel agent"
  - Pagination (`Agent::paginate(15)` dans le contrôleur)

### 3.3 Vue create — Formulaire de création
- [ ] Créer `resources/views/agents/create.blade.php`
  - Champs : name, email, phone, status (select)
  - Affichage des erreurs de validation
  - Bouton "Enregistrer" et lien "Annuler"

### 3.4 Vue edit — Formulaire d'édition
- [ ] Créer `resources/views/agents/edit.blade.php`
  - Même structure que `create`, avec valeurs pré-remplies
  - Méthode `@method('PUT')` dans le formulaire

### 3.5 Vue show — Détail d'un agent
- [ ] Créer `resources/views/agents/show.blade.php`
  - Informations de l'agent
  - Liste des assignments de cet agent (avec site et dates)
  - Liens Éditer / Retour à la liste

### 3.6 Mise à jour du contrôleur
- [ ] Ajouter la pagination dans `AgentController::index()` : `Agent::paginate(15)`
- [ ] Charger les assignments dans `AgentController::show()` : `$agent->load('assignments.site')`

---

## Critères de validation

- `/agents` affiche la liste avec pagination
- Créer un agent depuis le formulaire → redirige vers la liste avec message flash
- Éditer un agent → les données sont mises à jour en base
- Supprimer un agent → il disparaît de la liste
- `/agents/{id}` affiche les assignments de l'agent
