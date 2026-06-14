# CLAUDE — Guide de bonnes pratiques

Ce fichier regroupe des recommandations pour travailler avec un grand modèle de langage (ex. Claude) dans ce dépôt : conception de prompts, sécurité, tests et intégration. Il est adapté au développement du mini-CRM Laravel pour la gestion d'agents, sites et affectations.

## Objectifs
- Obtenir des réponses utiles, sûres et reproductibles.
- Réduire les allers-retours et le coût en tokens.
- Faciliter l'intégration dans des pipelines CI/UX.

## Règles générales
- Soyez explicite : préciser le rôle, le format de sortie attendu et les contraintes.
- Fournir un contexte minimal mais suffisant (extraits de code, objectif, exemples d'entrée/sortie).
- Privilégier les instructions étape-par-étape pour tâches complexes.
- Demander une sortie structurée (JSON, CSV, bullet points) quand possible pour faciliter le parsing.

## Sécurité et confidentialité
- Ne pas inclure de secrets (clefs API, mots de passe, données personnelles sensibles) dans les prompts.
- Si une tâche nécessite des informations sensibles, chargez-les côté serveur et fournissez un identifiant non sensible au modèle.
- Validez toujours toute sortie qui peut être exécutée ou utilisée en production.

## Contrôle de qualité
- Demander au modèle d'expliquer sa démarche (1-2 lignes) pour faciliter la vérifiabilité.
- Utiliser des tests automatisés autour de prompts critiques : exemples d'entrée -> sortie attendue.
- Versionner les prompts importants dans le dépôt (ce fichier ou un dossier `prompts/`).

## Gestion des formats
- Pour JSON attendu : demander un schéma précis et valider côté serveur (ex. `jsonschema`).
- Pour le code : demander le langage, la norme de style (ex. PSR-12 pour PHP) et inclure une commande de test rapide.

## Optimisation coût / tokens
- Fournir le contexte externe via URLs ou identifiants plutôt que coller de longs fichiers.
- Préférer des instructions courtes et des exemples petits et représentatifs.
- Si besoin, utiliser une stratégie en deux étapes : résumé d'abord, puis génération basée sur le résumé.

## Exemple de prompt (général)
```
Rôle: Coach de développement PHP pour un mini-CRM Laravel.
But: Générer une migration Laravel pour une table `agents`.
Contraintes: Utiliser les champs `name` (string), `email` (unique), `phone` (nullable), `status` (enum: active,inactive), plus timestamps.
Format de sortie: code PHP complet de migration (uniquement le code), compatible Laravel 10+.
```

## Exemple de prompt spécifique au dépôt
```
Rôle: Assistant développeur Laravel.
But: Générer le code d'un seeder pour créer des agents, sites et assignments de démonstration.
Contraintes: utiliser les modèles `Agent`, `Site` et `Assignment`, créer au moins 2 agents, 2 sites et 2 assignations, et s'assurer que chaque assignment référence `agent_id` et `site_id`.
Format de sortie: code PHP complet de seeder, prêt à copier dans `database/seeders/DemoSeeder.php`.
```

## Exemple de prompt (pour vérification)
```
Rôle: Relecteur de sécurité.
Objet: Vérifier ce patch et lister 5 problèmes potentiels de sécurité ou d'accessibilité, avec une suggestion de correction pour chaque.
Format: Liste numérotée, chaque item doit contenir 'Problème:' et 'Correction:'
```

## Intégration CI
- Envisager des checks automatisés : tests unitaires sur les sorties critiques, validation JSON, exécution sandboxée du code généré.
- Garder une trace des versions de modèle et des paramètres de génération (température, top_p, max_tokens) pour la traçabilité.
- Pour les prompts relatifs au mini-CRM, ajouter des tests d'acceptation sur les sorties de migration et de seeder.

## Bonnes pratiques de collaboration
- Documenter les prompts réutilisables dans `prompts/` avec un petit README expliquant l'usage.
- Lors d'une PR contenant des modifications liées à des prompts, inclure des exemples d'entrée/sortie et tests.

## Ressources utiles
- Stocker ici les liens officiels, guides de style, et politiques internes si nécessaires.

## Comment utiliser ce guide
- Commencez par lire les sections `Règles générales` et `Sécurité et confidentialité` avant de rédiger un prompt.
- Pour chaque demande de code, fournissez le rôle, l'objectif, les contraintes et le format de sortie.
- Placez les prompts réutilisables dans `prompts/` et référencez-les dans une PR ou un ticket.
- Testez les sorties critiques en ajoutant des exemples d’entrée/sortie dans un fichier de tests ou un README.

## Style de prompt recommandé
- Préfixez avec un rôle clair : `Rôle: ...`.
- Décrivez l'objectif en une phrase simple : `But: ...`.
- Listez les contraintes techniques et métier.
- Indiquez le format de sortie précis : `Format de sortie: ...`.
- Si possible, fournissez un exemple d'entrée ou un contexte court.

## Checklist de revue de prompt
- Le prompt est-il suffisamment spécifique pour le cas d'usage ?
- Le format de sortie est-il explicitement demandé ?
- Les contraintes de sécurité ou de confidentialité sont-elles notées ?
- Les champs et le modèle de données sont-ils cohérents avec le mini-CRM ?
- Y a-t-il un exemple d'input attendu ou un modèle de sortie clair ?

---
Créez un dossier `prompts/` si vous souhaitez enregistrer des prompts partagés.
