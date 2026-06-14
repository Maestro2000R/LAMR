# Sprint 05 — Dashboard & UX

**Objectif** : Page d'accueil avec statistiques, navigation soignée et expérience utilisateur fluide.

**Dépendance** : Sprints 03 et 04 terminés

**Durée estimée** : 1 session

---

## Tâches

### 5.1 Dashboard
- [ ] Créer `resources/views/dashboard.blade.php`
  - Carte "Agents actifs" (count)
  - Carte "Sites" (count)
  - Carte "Assignments en cours" (ends_at IS NULL ou ends_at >= today)
  - Tableau des 5 derniers assignments créés
- [ ] Créer `DashboardController` avec une méthode `index()`
- [ ] Ajouter la route `/dashboard` et rediriger `/` vers dashboard

### 5.2 Navigation
- [ ] Mettre à jour `layouts/app.blade.php` :
  - Lien actif mis en évidence (`request()->routeIs('agents.*')`)
  - Nom de l'utilisateur connecté + bouton déconnexion
  - Responsive (menu hamburger mobile si Tailwind)

### 5.3 Messages flash & feedback utilisateur
- [ ] Composant Blade `@include('partials.flash')` réutilisable
  - Succès (vert), Erreur (rouge), Info (bleu)
  - Fermeture automatique après 3s (JS minimal)
- [ ] Vérifier que tous les contrôleurs utilisent `->with('success', '...')`

### 5.4 UX — Listes
- [ ] Pagination sur toutes les listes (15 items par page)
- [ ] Message "Aucun résultat" quand la liste est vide
- [ ] Confirmation JavaScript sur les boutons "Supprimer"
  ```html
  onclick="return confirm('Supprimer cet élément ?')"
  ```

### 5.5 UX — Formulaires
- [ ] Affichage des erreurs de validation inline sous chaque champ
- [ ] `old()` pour conserver les valeurs saisies en cas d'erreur
- [ ] Bouton de soumission désactivé pendant l'envoi (optionnel)

---

## Critères de validation

- `/dashboard` affiche les 3 compteurs corrects
- Le menu indique la section active
- Un message flash apparaît après chaque création/modification/suppression
- La confirmation s'affiche avant toute suppression
- Les formulaires conservent les valeurs après une erreur de validation
