# myagri

Portail citoyen en **PHP** pour informer le grand public sur l'agriculture en Wallonie.

## Ce qui est inclus

- Portail multi-vues via `?page=accueil|filieres|ressources`.
- Contenu centralisé dans `includes/data.php` via `getPortalData()`.
- Helpers PHP dans `includes/functions.php` (`e()`, `currentPage()`).
- Recherche globale (`q=`) + filtre local des filières + FAQ interactive.
- API JSON de lecture via `api.php` (`?section=...`).
- Tracking Matomo intégré sur toutes les pages du portail (`siteId` 5).
- Chaque ressource utile dispose d’une page individuelle (`?page=ressource&resource=<id>`).
- Couche repository (`includes/portal_repository.php`) connectée en MySQL (source obligatoire).
- SEO renforcé : balises meta dynamiques, Open Graph/Twitter, canonical, JSON-LD, `robots.txt`, `sitemap.xml`.

## Exécution locale

```bash
php -S 127.0.0.1:8000
```

## Base de données MySQL (obligatoire)

Le portail charge son contenu depuis MySQL de façon obligatoire.
À chaque chargement, les données locales de `includes/data.php` sont synchronisées automatiquement dans la table MySQL.
Vous pouvez aussi forcer le transfert manuellement avec :

```bash
php scripts/sync_portal_to_mysql.php
```

Requête utilisée par défaut :

```sql
SELECT payload_json FROM portal_content WHERE code = 'main' LIMIT 1;
```

Le champ `payload_json` doit contenir un JSON compatible avec la structure attendue du portail.
Si MySQL est indisponible, le front renvoie une page HTTP 503 et l’API renvoie une erreur JSON HTTP 503.

## SEO

- Les balises SEO (`title`, `description`, `keywords`, Open Graph, Twitter et JSON-LD) sont générées dynamiquement selon la page.
- Définissez `SITE_URL` en production pour générer des URLs canoniques absolues correctes.
- Les fichiers `robots.txt` et `sitemap.xml` sont fournis à la racine.

Pages utiles :

- <https://myagri.be/?page=accueil>
- <https://myagri.be/?page=filieres>
- <https://myagri.be/?page=ressources>
- <https://myagri.be/api.php>
- <https://myagri.be/api.php?section=sectors>

## Vérification rapide

```bash
php tests/smoke.php
```
