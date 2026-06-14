# Prompt d'exemple pour le mini-CRM Laravel

Rôle: Assistant développeur Laravel.
But: Générer une migration et un seeder pour le mini-CRM de gestion d'agents par site.
Contraintes:
- Utiliser les modèles `Agent`, `Site`, `Assignment`.
- `Agent` doit avoir `name`, `email` (unique), `phone` (nullable), `status` (enum: active,inactive).
- `Site` doit avoir `name`, `address`, `city`.
- `Assignment` doit contenir `agent_id`, `site_id`, `starts_at`, `ends_at`, `role`.
Format de sortie: Markdown ou code PHP prêt à copier dans les fichiers de migration et seeder.

Exemple de sortie attendue:
- Fichier de migration pour `agents`
- Fichier de migration pour `sites`
- Fichier de migration pour `assignments`
- Fichier de seeder `DemoSeeder`
