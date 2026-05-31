# myagri

Portail citoyen en **PHP** pour informer le grand public sur l'agriculture en Wallonie.

## Ce qui est inclus

- Portail multi-vues via `?page=accueil|filieres|ressources`.
- Contenu centralisé dans `includes/data.php` via `getPortalData()`.
- Helpers PHP dans `includes/functions.php` (`e()`, `currentPage()`).
- Recherche globale (`q=`), filtre local des filières et FAQ interactive.
- API JSON de lecture via `api.php` (`?section=...`).
- Tracking Matomo intégré sur toutes les pages du portail (`siteId` 5).
- Chaque ressource utile dispose d'une page individuelle (`?page=ressource&resource=<id>`).
- Couche repository (`includes/portal_repository.php`) connectée en MySQL.
- SEO/GSO renforcé : balises meta dynamiques, Open Graph/Twitter, canonical, JSON-LD enrichi, `robots.txt`, `sitemap.xml`, `llms.txt`.

## Accès local

Lancer le serveur PHP :

```bash
php -S 127.0.0.1:8000
```

Puis ouvrir :

- <http://127.0.0.1:8000/?page=accueil>
- <http://127.0.0.1:8000/?page=filieres>
- <http://127.0.0.1:8000/?page=ressources>

Le portail charge son contenu depuis MySQL. Si la base n'est pas joignable depuis votre poste (accès réseau, pare-feu, identifiants ou serveur indisponible), le front renvoie une page HTTP 503 et l'API renvoie une erreur JSON HTTP 503. Dans ce cas, vérifiez d'abord l'accès MySQL avant de diagnostiquer le rendu HTML.

## Base de données MySQL

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

## SEO et GSO

- Les balises SEO (`title`, `description`, `keywords`, Open Graph, Twitter et JSON-LD) sont générées dynamiquement selon la page.
- Le JSON-LD expose `Organization`, `WebSite`, `BreadcrumbList`, `CollectionPage`, `FAQPage`, `ItemList`, `DefinedTermSet` et `Article` selon le contexte.
- Le fichier `llms.txt` fournit un résumé canonique du portail et des URLs clés pour les moteurs génératifs.
- Définissez `SITE_URL` en production pour générer des URLs canoniques absolues correctes.
- Les fichiers `robots.txt`, `sitemap.xml` et `llms.txt` sont fournis à la racine.

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
