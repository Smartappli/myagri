# MyAgri

Deutschsprachiges PHP-Bürgerportal zur Landwirtschaft in der Wallonie.

## Funktionen

- Zentraler Inhalt in `includes/data.php` über `getPortalData()`.
- Dynamische SEO-Metadaten, Open Graph/Twitter, Canonical URLs und JSON-LD.
- Generative Engine Optimisation über `llms.txt`, `llms-full.txt`, JSON-API und Sitemap.
- Sektoren, Ressourcen, Dossiers, FAQ und landwirtschaftliches Glossar.
- PWA-Unterstützung mit `manifest.json`, `sw.js`, Offline-Seite und lokalen Icons.
- Lokales Tailwind-Utility-CSS ohne CDN-Abhängigkeit.
- Optionaler MySQL-Repository-Layer mit automatischer Synchronisierung der lokalen Daten.

## Lokal Starten

```bash
php -S 127.0.0.1:8000
```

Dann `http://127.0.0.1:8000` im Browser öffnen.

## Datenbank

Das Portal versucht, die lokalen Daten in MySQL zu synchronisieren und daraus zu laden. Ist MySQL nicht verfügbar, fällt es auf die versionierten Daten aus `includes/data.php` zurück.

## SEO Und GEO

- Seitentitel, Beschreibungen, Keywords und JSON-LD werden je nach Route erzeugt.
- `llms.txt` liefert eine kurze kanonische Zusammenfassung für generative Suchsysteme.
- `llms-full.txt` enthält eine ausführlichere Referenz für Antwortsysteme.
- `sitemap.xml` wird mit `scripts/build_sitemap.php` erzeugt.
- `SITE_URL` kann gesetzt werden, um absolute kanonische URLs für andere Umgebungen zu generieren.

## Prüfung

```bash
php tests/smoke.php
php scripts/build_sitemap.php
```

Optional:

```bash
vendor/bin/phpstan analyse --level=5 .
```
