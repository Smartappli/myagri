# myagri

Portail citoyen en **PHP** pour informer le grand public sur l'agriculture en Wallonie.

## Ce qui a été amélioré

- Structure éditoriale centralisée via `getPortalData()`.
- Helpers dédiés (`includes/functions.php`) pour l’échappement HTML et la gestion de page.
- Navigation multi-vues via `?page=accueil|filieres|ressources`.
- Filtrage dynamique des filières et FAQ interactive accessible.

## Exécution locale

```bash
php -S 127.0.0.1:8000
```

Pages utiles :

- <http://127.0.0.1:8000/?page=accueil>
- <http://127.0.0.1:8000/?page=filieres>
- <http://127.0.0.1:8000/?page=ressources>
