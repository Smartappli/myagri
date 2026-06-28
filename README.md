# MyAgri

## Français

Portail citoyen multilingue d'information sur l'agriculture en Wallonie.

- Langue : `?lang=fr`
- Validation : `php tests\smoke.php`

## English

Multilingual citizen information portal about agriculture in Wallonia.

- Language: `?lang=en`
- Validation: `php tests\smoke.php`

## Deutsch

Mehrsprachiges Bürgerinformationsportal zur Landwirtschaft in der Wallonie.

- Sprache: `?lang=ge`
- Validierung: `php tests\smoke.php`

## Nederlands

Meertalig burgerinformatieportaal over landbouw in Wallonië.

- Taal: `?lang=nl`
- Validatie: `php tests\smoke.php`

## Notes / Hinweise / Notities

- FR : les contenus éditoriaux sont dans `includes/translations/` et les chaînes d’interface dans `includes/ui-translations/`. Le smoke test vérifie les deux ensembles.
- EN: editorial content lives in `includes/translations/` and interface strings in `includes/ui-translations/`. The smoke test verifies both sets.
- DE: redaktionelle Inhalte liegen in `includes/translations/`, Interface-Texte in `includes/ui-translations/`. Der Smoke-Test prüft beide Bereiche.
- NL: redactionele inhoud staat in `includes/translations/` en interfaceteksten in `includes/ui-translations/`. De smoke test controleert beide.

## Quality / Qualité / Qualität / Kwaliteit

- Smoke test: `composer smoke`
- Dependency audit: `composer security:audit`
- Generated sitemap check: `composer check:sitemap`
- Static analysis: `composer analyse`
- Selenium browser tests: `composer selenium` with `BASE_URL`, `APP_HEALTH_URL` and `SELENIUM_REMOTE_URL`
