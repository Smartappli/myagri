# myagri

Portail citoyen en **PHP** pour informer le grand public sur l'agriculture en Wallonie.

## Ce qui est inclus

- Portail multi-vues via `?page=accueil|filieres|ressources`.
- Contenu centralisé dans `includes/data.php` via `getPortalData()`.
- Helpers PHP dans `includes/functions.php` (`e()`, `currentPage()`).
- Recherche globale (`q=`) + filtre local des filières + FAQ interactive.
- API JSON de lecture via `api.php` (`?section=...`).
- Tracking Matomo intégré sur toutes les pages du portail (`siteId` 5).

## Exécution locale

```bash
php -S 127.0.0.1:8000
```

Pages utiles :

- <http://127.0.0.1:8000/?page=accueil>
- <http://127.0.0.1:8000/?page=filieres>
- <http://127.0.0.1:8000/?page=ressources>
- <http://127.0.0.1:8000/api.php>
- <http://127.0.0.1:8000/api.php?section=sectors>

## Vérification rapide

```bash
php tests/smoke.php
```
