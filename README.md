# Mini-CRM de démonstration (Suivi des agents par site)

Ceci est un guide rapide pour créer et exécuter une version de démonstration d'un mini-CRM basé sur Laravel, utilisant MySQL.

## Objectif
- Suivre des `Agent` affectés à des `Site` via des `Assignment`.

## Prérequis
- PHP 8.1+ (ou version compatible Laravel actuelle)
- Composer
- MySQL
- Node.js + npm (optionnel pour assets frontend)

## Installation rapide

1. Créer le projet Laravel (si vous ne l'avez pas déjà):

```bash
composer create-project laravel/laravel laravel-crm-demo
cd laravel-crm-demo
```

2. Configurer la base de données MySQL dans le fichier `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_demo
DB_USERNAME=root
DB_PASSWORD=
```

3. Créer la base de données MySQL (exemple):

```bash
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS laravel_demo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

4. Installer les dépendances JS (optionnel pour UI):

```bash
npm install
npm run build   # ou npm run dev pour développement
```

## Génération des modèles & migrations (exemples)

Vous pouvez générer les modèles et migrations suivants:

```bash
php artisan make:model Agent -m
php artisan make:model Site -m
php artisan make:model Assignment -m
```

Exemples de champs (à adapter dans les fichiers de migration):

- `agents` : `id`, `name`, `email`, `phone`, `status`, `timestamps`
- `sites` : `id`, `name`, `address`, `city`, `timestamps`
- `assignments` : `id`, `agent_id` (FK), `site_id` (FK), `starts_at`, `ends_at`, `role`, `timestamps`

Pensez à ajouter les clés étrangères et les index dans les migrations.

## Migrations & seeders

Après avoir édité les migrations, exécutez:

```bash
php artisan migrate
```

Pour remplir des données de démonstration, créez un seeder et lancez:

```bash
php artisan make:seeder DemoSeeder
php artisan db:seed --class=DemoSeeder
```

## Contrôleurs & routes (CRUD)

Générez rapidement des contrôleurs ressources:

```bash
php artisan make:controller AgentController --resource
php artisan make:controller SiteController --resource
php artisan make:controller AssignmentController --resource
```

Ajoutez les routes dans `routes/web.php` :

```php
Route::resource('agents', AgentController::class);
Route::resource('sites', SiteController::class);
Route::resource('assignments', AssignmentController::class);
```

## Lancer l'application

```bash
php artisan serve
# puis ouvrir http://127.0.0.1:8000
```

## Suggestions pour la démonstration

- Ajouter une authentification rapide : `composer require laravel/breeze --dev` puis `php artisan breeze:install` pour des pages d'auth par défaut.
- UI minimale : utiliser Blade + Tailwind (déjà inclus avec Breeze) pour créer des vues CRUD simples.
- Endpoint API : créer des routes `api.php` pour une démonstration sans UI.

## Authentification (optionnel - Breeze)

Pour ajouter une authentification de démonstration avec Blade + Tailwind via Breeze :

```bash
# installer le package Breeze
composer require laravel/breeze --dev

# générer les scaffolds Blade
php artisan breeze:install blade

# installer les dépendances JS et builder
npm install
npm run dev    # ou `npm run build` pour production

# exécuter les migrations et seeders
php artisan migrate
php artisan db:seed

# lancer le serveur
php artisan serve
```

Après `breeze:install`, tu auras des routes et vues pour `login`, `register`, `logout`.

Si tu veux, je peux exécuter ces commandes localement pour toi (mais il faudra que Composer et npm soient disponibles sur ta machine). Autre option : je peux simplement générer des instructions et adapter les vues comme je l'ai fait.

## Ce que je peux faire ensuite
- Implémenter les migrations et modèles complets.
- Ajouter les contrôleurs CRUD et vues Blade.
- Préparer des seeders avec données réalistes.
- Ajouter l'authentification de démo.

Si tu veux, je peux maintenant générer les migrations, modèles et contrôleurs directement dans ce dépôt. Dis-moi si tu veux l'authentification et si tu veux des champs spécifiques pour `Agent` ou `Site`.

---
Fichier créé automatiquement pour la démonstration.
