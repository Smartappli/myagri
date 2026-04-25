<?php

declare(strict_types=1);

/**
 * @param scalar|null $value
 */
function e(string|int|float|bool|null $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function currentPage(): string
{
    $page = $_GET['page'] ?? 'accueil';
    if (!is_string($page)) {
        return 'accueil';
    }

    $allowed = ['accueil', 'filieres', 'ressources', 'ressource'];
    return in_array($page, $allowed, true) ? $page : 'accueil';
}

/**
 * @param array<string, mixed> $site
 * @param array<string, mixed>|null $resource
 * @return array{title:string,description:string,keywords:string}
 */
function pageSeo(string $page, array $site, ?array $resource = null): array
{
    $siteTitle = isset($site['title']) && is_string($site['title']) ? $site['title'] : 'MyAgri';

    if ($page === 'filieres') {
        return [
            'title' => 'Filières agricoles en Wallonie — ' . $siteTitle,
            'description' => 'Explorez les filières agricoles wallonnes : grandes cultures, élevage, maraîchage, diversification, enjeux et actions citoyennes.',
            'keywords' => 'filières agricoles, wallonie, élevage, cultures, maraîchage, diversification, agriculture durable',
        ];
    }

    if ($page === 'ressources') {
        return [
            'title' => 'Ressources agricoles pratiques — ' . $siteTitle,
            'description' => 'Retrouvez des ressources pratiques : aides, formations, marchés locaux, labels, consommation responsable et outils pédagogiques.',
            'keywords' => 'ressources agricoles, aides agricoles, marchés locaux, labels, formation agricole, consommation responsable',
        ];
    }

    if ($page === 'ressource' && is_array($resource)) {
        $resourceTitle = isset($resource['title']) && is_string($resource['title']) ? $resource['title'] : 'Ressource';
        $resourceDescription = isset($resource['description']) && is_string($resource['description'])
            ? $resource['description']
            : 'Ressource pratique du portail MyAgri.';

        return [
            'title' => $resourceTitle . ' — ' . $siteTitle,
            'description' => $resourceDescription,
            'keywords' => strtolower($resourceTitle) . ', agriculture wallonne, ressource pratique, myagri',
        ];
    }

    return [
        'title' => $siteTitle,
        'description' => 'Portail citoyen pour comprendre l’agriculture wallonne : alimentation, environnement, métiers, filières et ressources utiles.',
        'keywords' => 'agriculture wallonne, portail citoyen, alimentation locale, environnement, filières agricoles, ressources',
    ];
}

function canonicalPath(string $page, string $resourceId = ''): string
{
    if ($page === 'ressource' && $resourceId !== '') {
        return '/?page=ressource&resource=' . rawurlencode($resourceId);
    }

    if (in_array($page, ['accueil', 'filieres', 'ressources'], true)) {
        return '/?page=' . rawurlencode($page);
    }

    return '/?page=accueil';
}

function siteBaseUrl(): string
{
    $envBase = getenv('SITE_URL');
    if (is_string($envBase) && $envBase !== '') {
        return rtrim($envBase, '/');
    }

    return 'https://myagri.be';
}
