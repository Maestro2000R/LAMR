# Sprint 01 — Infrastructure & Installation

**Objectif** : Avoir un projet Laravel fonctionnel, connecté à MySQL, avec l'authentification en place.

**Durée estimée** : 1 session

---

## Tâches

### 1.1 Initialisation du projet Laravel
- [x] Créer les modèles (`Agent`, `Site`, `Assignment`)
- [x] Créer les migrations (tables `agents`, `sites`, `assignments`)
- [x] Créer les contrôleurs resource (`AgentController`, `SiteController`, `AssignmentController`)
- [x] Définir les routes dans `routes/web.php`
- [ ] Exécuter `composer create-project laravel/laravel .` à la racine du projet Laravel réel
- [ ] Copier/intégrer les fichiers existants dans le projet Laravel installé

### 1.2 Configuration de l'environnement
- [ ] Configurer `.env` avec les paramètres MySQL :
  ```
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=lamr_crm
  DB_USERNAME=root
  DB_PASSWORD=
  ```
- [ ] Créer la base de données : `CREATE DATABASE lamr_crm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;`

### 1.3 Migrations
- [ ] Exécuter `php artisan migrate`
- [ ] Vérifier les 3 tables créées en base

### 1.4 Authentification (Laravel Breeze)
- [ ] Installer Breeze : `composer require laravel/breeze --dev`
- [ ] Publier les vues auth : `php artisan breeze:install blade`
- [ ] Installer les assets : `npm install && npm run build`
- [ ] Exécuter les migrations Breeze : `php artisan migrate`
- [ ] Tester la page `/login` et `/register`

### 1.5 Vérification finale
- [ ] Lancer le serveur : `php artisan serve`
- [ ] Vérifier que `/` redirige vers `/agents` (ou la page de login)
- [ ] Vérifier l'absence d'erreurs dans les logs (`storage/logs/laravel.log`)

---

## Commandes utiles

```bash
php artisan migrate:status   # état des migrations
php artisan route:list       # liste des routes enregistrées
php artisan config:clear     # vider le cache de config
```

---

## Critères de validation

- `php artisan migrate:status` affiche toutes les migrations comme `Ran`
- La page `/login` s'affiche sans erreur
- Après login, `/agents` répond 200 (même si la vue n'existe pas encore, pas d'erreur 500)
