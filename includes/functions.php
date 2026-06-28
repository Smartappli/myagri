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

    $allowed = ['accueil', 'filieres', 'ressources', 'faq', 'glossaire', 'ressource', 'dossiers', 'dossier'];
    return in_array($page, $allowed, true) ? $page : 'accueil';
}

function siteLanguage(): string
{
    return portalLanguageConfig()['html_lang'];
}

function siteLocale(): string
{
    return portalLanguageConfig()['locale'];
}

/**
 * @param array<string, mixed> $site
 * @return array<string, string>
 */
function siteGeoConfig(array $site): array
{
    $geo = $site['geo'] ?? null;
    if (!is_array($geo)) {
        $geo = [];
    }

    $name = isset($geo['name']) && is_string($geo['name']) ? trim($geo['name']) : t('geo.name');
    $region = isset($geo['region']) && is_string($geo['region']) ? trim($geo['region']) : t('geo.region');
    $regionCode = isset($geo['region_code']) && is_string($geo['region_code']) ? trim($geo['region_code']) : 'BE-WAL';
    $country = isset($geo['country']) && is_string($geo['country']) ? trim($geo['country']) : t('geo.country');
    $countryCode = isset($geo['country_code']) && is_string($geo['country_code']) ? trim($geo['country_code']) : 'BE';
    $locality = isset($geo['locality']) && is_string($geo['locality']) ? trim($geo['locality']) : t('geo.locality');
    $latitude = isset($geo['latitude']) && is_scalar($geo['latitude']) ? trim((string) $geo['latitude']) : '50.5039';
    $longitude = isset($geo['longitude']) && is_scalar($geo['longitude']) ? trim((string) $geo['longitude']) : '4.4699';

    if (!is_numeric($latitude)) {
        $latitude = '50.5039';
    }
    if (!is_numeric($longitude)) {
        $longitude = '4.4699';
    }

    return [
        'name' => $name,
        'region' => $region,
        'region_code' => $regionCode,
        'country' => $country,
        'country_code' => $countryCode,
        'locality' => $locality,
        'latitude' => $latitude,
        'longitude' => $longitude,
    ];
}

/**
 * @param array<string, mixed> $site
 * @param array<string, mixed>|null $resource
 * @param array<string, mixed>|null $glossaryTerm
 * @return array{title:string,description:string,keywords:string}
 */
function pageSeo(string $page, array $site, ?array $resource = null, ?array $glossaryTerm = null, ?array $dossier = null, ?array $dossierChapter = null): array
{
    $siteTitle = isset($site['title']) && is_string($site['title']) ? $site['title'] : 'MyAgri';
    $siteDescription = isset($site['subtitle']) && is_string($site['subtitle']) ? $site['subtitle'] : '';
    $baseKeywords = t('seo.keywords_base');

    if ($page === 'filieres') {
        return [
            'title' => t('sectors.title') . ' | MyAgri',
            'description' => t('sectors.intro'),
            'keywords' => $baseKeywords . ', ' . t('seo.keywords_sectors'),
        ];
    }

    if ($page === 'ressources') {
        return [
            'title' => t('resources.title') . ' | MyAgri',
            'description' => t('resources.intro'),
            'keywords' => $baseKeywords . ', ' . t('seo.keywords_resources'),
        ];
    }

    if ($page === 'faq') {
        return [
            'title' => t('faq.title') . ' | MyAgri',
            'description' => t('faq.intro'),
            'keywords' => $baseKeywords . ', ' . t('seo.keywords_faq'),
        ];
    }

    if ($page === 'glossaire' && is_array($glossaryTerm) && isset($glossaryTerm['term']) && is_string($glossaryTerm['term'])) {
        $termTitle = $glossaryTerm['term'];
        $termDescription = isset($glossaryTerm['definition']) && is_string($glossaryTerm['definition'])
            ? $glossaryTerm['definition']
            : t('glossary.extended_definition');

        return [
            'title' => $termTitle . ' | ' . t('glossary.title') . ' | MyAgri',
            'description' => $termDescription,
            'keywords' => strtolower($termTitle) . ', ' . $baseKeywords . ', ' . t('seo.keywords_glossary'),
        ];
    }

    if ($page === 'glossaire') {
        return [
            'title' => t('glossary.title') . ' | MyAgri',
            'description' => t('glossary.intro', ['count' => '80+']),
            'keywords' => $baseKeywords . ', ' . t('seo.keywords_glossary'),
        ];
    }

    if ($page === 'dossiers') {
        return [
            'title' => t('dossiers.title') . ' | MyAgri',
            'description' => t('dossiers.intro'),
            'keywords' => $baseKeywords . ', ' . t('seo.keywords_dossiers'),
        ];
    }

    if ($page === 'dossier' && is_array($dossier)) {
        $dossierTitle = isset($dossier['title']) && is_string($dossier['title']) ? $dossier['title'] : t('dossiers.eyebrow');
        $chapterTitle = isset($dossierChapter['title']) && is_string($dossierChapter['title']) ? $dossierChapter['title'] : '';
        $description = isset($dossierChapter['summary']) && is_string($dossierChapter['summary'])
            ? $dossierChapter['summary']
            : (isset($dossier['subtitle']) && is_string($dossier['subtitle']) ? $dossier['subtitle'] : t('dossiers.intro'));

        return [
            'title' => ($chapterTitle !== '' ? $chapterTitle . ' | ' : '') . $dossierTitle . ' | MyAgri',
            'description' => $description,
            'keywords' => strtolower($dossierTitle) . ', ' . $baseKeywords . ', ' . t('seo.keywords_dossiers'),
        ];
    }

    if ($page === 'dossier') {
        return [
            'title' => t('dossiers.not_found_title') . ' | MyAgri',
            'description' => t('dossiers.not_found_text'),
            'keywords' => $baseKeywords . ', ' . t('seo.keywords_not_found'),
        ];
    }

    if ($page === 'ressource' && is_array($resource)) {
        $resourceTitle = isset($resource['title']) && is_string($resource['title']) ? $resource['title'] : t('resources.default_resource');
        $resourceDescription = isset($resource['description']) && is_string($resource['description'])
            ? $resource['description']
            : t('resources.intro');

        return [
            'title' => $resourceTitle . ' | MyAgri',
            'description' => $resourceDescription,
            'keywords' => strtolower($resourceTitle) . ', ' . $baseKeywords . ', ' . t('seo.keywords_resource'),
        ];
    }

    if ($page === 'ressource') {
        return [
            'title' => t('resources.not_found_title') . ' | MyAgri',
            'description' => t('resources.not_found_text'),
            'keywords' => $baseKeywords . ', ' . t('seo.keywords_not_found'),
        ];
    }

    return [
        'title' => $siteTitle,
        'description' => $siteDescription,
        'keywords' => $baseKeywords,
    ];
}

/**
 * @param array<string, mixed> $site
 * @param array<int, array<string, mixed>> $sectors
 * @param array<int, array<string, mixed>> $resources
 * @param array<int, array<string, mixed>> $faq
 * @param array<int, array<string, mixed>> $glossary
 * @param array<string, mixed>|null $resource
 * @param array<string, mixed>|null $glossaryTerm
 * @param array<int, array<string, mixed>> $dossiers
 * @param array<string, mixed>|null $dossier
 * @param array<string, mixed>|null $dossierChapter
 * @return array<string, mixed>
 */
function pageStructuredData(
    string $page,
    array $site,
    array $sectors,
    array $resources,
    array $faq,
    array $glossary,
    ?array $resource = null,
    ?array $glossaryTerm = null,
    array $dossiers = [],
    ?array $dossier = null,
    ?array $dossierChapter = null
): array {
    $baseUrl = siteBaseUrl();
    $siteTitle = isset($site['title']) && is_string($site['title']) ? $site['title'] : 'MyAgri';
    $siteSubtitle = isset($site['subtitle']) && is_string($site['subtitle']) ? $site['subtitle'] : '';
    $dateModified = updatedAtIsoDate(isset($site['updated_at']) && is_string($site['updated_at']) ? $site['updated_at'] : '');
    $resourceId = isset($resource['id']) && is_string($resource['id']) ? $resource['id'] : '';
    $glossaryTermSlug = is_array($glossaryTerm) ? glossaryEntrySlug($glossaryTerm) : '';
    $dossierId = isset($dossier['id']) && is_string($dossier['id']) ? $dossier['id'] : '';
    $chapterId = isset($dossierChapter['id']) && is_string($dossierChapter['id']) ? $dossierChapter['id'] : '';
    $seo = pageSeo($page, $site, $resource, $glossaryTerm, $dossier, $dossierChapter);
    $canonicalUrl = $baseUrl . canonicalPath($page, $resourceId, $glossaryTermSlug, $dossierId, $chapterId);
    $siteGeo = siteGeoConfig($site);
    $geoLocation = [
        '@type' => 'Place',
        'name' => $siteGeo['name'],
        'address' => [
            '@type' => 'PostalAddress',
            'addressCountry' => $siteGeo['country_code'],
            'addressRegion' => $siteGeo['region'],
            'addressLocality' => $siteGeo['locality'],
        ],
        'geo' => [
            '@type' => 'GeoCoordinates',
            'latitude' => $siteGeo['latitude'],
            'longitude' => $siteGeo['longitude'],
        ],
    ];

    $graph = [
        [
            '@type' => 'Organization',
            '@id' => $baseUrl . '/#organization',
            'name' => 'MyAgri',
            'url' => $baseUrl,
            'logo' => $baseUrl . '/assets/img/logo-myagri.svg',
            'areaServed' => [
                '@type' => 'AdministrativeArea',
                'name' => $siteGeo['region'],
                'identifier' => $siteGeo['region_code'],
                'geo' => $geoLocation['geo'],
                'containedInPlace' => [
                    '@type' => 'Country',
                    'name' => $siteGeo['country'],
                    'sameAs' => 'https://en.wikipedia.org/wiki/Belgium',
                ],
            ],
            'location' => $geoLocation,
        ],
        [
            '@type' => 'WebSite',
            '@id' => $baseUrl . '/#website',
            'name' => $siteTitle,
            'alternateName' => 'MyAgri',
            'url' => $baseUrl,
            'description' => $siteSubtitle,
            'inLanguage' => siteLanguage(),
            'keywords' => pageKeywordList($seo['keywords']),
            'publisher' => ['@id' => $baseUrl . '/#organization'],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => $baseUrl . '/?lang=' . rawurlencode(currentLanguage()) . '&page=accueil&q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ],
        [
            '@type' => pageSchemaType($page, is_array($glossaryTerm)),
            '@id' => $canonicalUrl . '#webpage',
            'url' => $canonicalUrl,
            'headline' => $seo['title'],
            'name' => $seo['title'],
            'description' => $seo['description'],
            'contentLocation' => $geoLocation,
            'isPartOf' => ['@id' => $baseUrl . '/#website'],
            'primaryImageOfPage' => [
                '@type' => 'ImageObject',
                'url' => $baseUrl . '/assets/img/hero.png',
                'caption' => t('head.image_alt'),
            ],
            'keywords' => pageKeywordList($seo['keywords']),
            'about' => [
                $siteTitle,
                t('nav.sectors'),
                t('nav.resources'),
                t('nav.glossary'),
            ],
            'knowsAbout' => [
                t('structured.knows_agriculture'),
                t('structured.knows_region'),
                t('structured.knows_food_systems'),
                t('structured.knows_biodiversity'),
                t('structured.knows_soil_water'),
                t('structured.knows_local_supply_chains'),
            ],
            'audience' => [
                '@type' => 'Audience',
                'audienceType' => t('footer.description'),
            ],
            'inLanguage' => siteLanguage(),
            'datePublished' => $dateModified,
            'dateModified' => $dateModified,
            'publisher' => ['@id' => $baseUrl . '/#organization'],
            'speakable' => [
                '@type' => 'SpeakableSpecification',
                'cssSelector' => ['main h2', 'main h3', 'main p'],
            ],
        ],
        [
            '@type' => 'BreadcrumbList',
            '@id' => $canonicalUrl . '#breadcrumb',
            'itemListElement' => breadcrumbItems($page, $resource, $glossaryTerm, $dossier, $dossierChapter),
        ],
    ];

    if ($page === 'filieres') {
        $graph[] = sectorItemList($sectors, $baseUrl);
    }

    if ($page === 'ressources') {
        $graph[] = resourceItemList($resources, $baseUrl);
    }

    if ($page === 'dossiers') {
        $graph[] = dossierItemList($dossiers, $baseUrl);
    }

    if ($page === 'faq') {
        $graph[] = faqStructuredData($faq, $canonicalUrl);
    }

    if ($page === 'glossaire' && is_array($glossaryTerm)) {
        $graph[] = glossaryTermStructuredData($glossaryTerm, $canonicalUrl);
        $graph[] = faqStructuredDataFromPairs(
            glossaryTermFaqPairs($glossaryTerm),
            $canonicalUrl . '#faq'
        );
    }

    if ($page === 'glossaire' && !is_array($glossaryTerm)) {
        $graph[] = glossaryStructuredData($glossary, $canonicalUrl);
    }

    if ($page === 'ressource' && is_array($resource)) {
        $graph[] = resourceArticleStructuredData($resource, $canonicalUrl, $baseUrl, $siteTitle, $dateModified, $siteGeo);
        $graph[] = faqStructuredDataFromPairs(
            resourceFaqPairs($resource),
            $canonicalUrl . '#faq'
        );
    }

    if ($page === 'dossier' && is_array($dossier)) {
        $graph[] = dossierArticleStructuredData($dossier, $dossierChapter, $canonicalUrl, $baseUrl, $siteTitle, $dateModified);
    }

    return [
        '@context' => 'https://schema.org',
        '@graph' => $graph,
    ];
}

/**
 * @return array<int, string>
 */
function pageKeywordList(string $keywords): array
{
    $items = [];
    foreach (explode(',', $keywords) as $keyword) {
        $keyword = trim($keyword);
        if ($keyword !== '') {
            $items[] = $keyword;
        }
    }

    return $items;
}

/**
 * @param array<string, mixed> $resource
 * @param int $limit
 * @return array<int, array{question:string, answer:string}>
 */
function resourceFaqPairs(array $resource, int $limit = 6): array
{
    $pairs = [];

    $add = function (string $question, string $answer) use (&$pairs, $limit): void {
        $question = trim($question);
        $answer = trim(preg_replace('/\s+/u', ' ', $answer));
        if ($question === '' || $answer === '' || count($pairs) >= $limit) {
            return;
        }

        $pairs[] = ['question' => $question, 'answer' => $answer];
    };

    if (isset($resource['title'], $resource['description']) && is_string($resource['title']) && is_string($resource['description'])) {
        $add(
            t('qa.resource_title'),
            $resource['title'] . ' : ' . $resource['description']
        );
    }

    if (isset($resource['for']) && is_string($resource['for']) && trim($resource['for']) !== '') {
        $add(t('resources.target') . '?', trim($resource['for']));
    }

    if (isset($resource['overview']) && is_string($resource['overview']) && trim($resource['overview']) !== '') {
        $add(t('resources.intro_title') . '?', trim($resource['overview']));
    }

    if (is_array($resource['steps'] ?? null) && $resource['steps'] !== []) {
        $steps = array_slice(array_values(array_filter($resource['steps'], 'is_string')), 0, 3);
        if ($steps !== []) {
            $add(t('resources.section_steps') . '?', implode(' / ', array_map('trim', $steps)));
        }
    }

    if (is_array($resource['checklist'] ?? null) && $resource['checklist'] !== []) {
        $items = array_slice(array_values(array_filter($resource['checklist'], 'is_string')), 0, 3);
        if ($items !== []) {
            $add(t('resources.section_checklist') . '?', implode(' ; ', array_map('trim', $items)));
        }
    }

    if (is_array($resource['timeline'] ?? null) && $resource['timeline'] !== []) {
        $items = array_slice(array_values(array_filter($resource['timeline'], 'is_string')), 0, 3);
        if ($items !== []) {
            $add(t('resources.section_timeline') . '?', implode(' > ', array_map('trim', $items)));
        }
    }

    if (is_array($resource['support_contacts'] ?? null) && $resource['support_contacts'] !== []) {
        $items = array_slice(array_values(array_filter($resource['support_contacts'], 'is_string')), 0, 2);
        if ($items !== []) {
            $add(t('resources.section_support_contacts') . '?', implode(' ; ', array_map('trim', $items)));
        }
    }

    return $pairs;
}

/**
 * @param array<string, mixed> $glossaryTerm
 * @return array<int, array{question:string, answer:string}>
 */
function glossaryTermFaqPairs(array $glossaryTerm, int $limit = 4): array
{
    $term = isset($glossaryTerm['term']) && is_string($glossaryTerm['term']) ? trim($glossaryTerm['term']) : '';
    $definition = isset($glossaryTerm['definition']) && is_string($glossaryTerm['definition']) ? trim($glossaryTerm['definition']) : '';
    if ($term === '' || $definition === '') {
        return [];
    }

    $pairs = [
        [
            'question' => t('glossary.default_term') . ' : ' . $term,
            'answer' => $definition,
        ],
        [
            'question' => t('glossary.why'),
            'answer' => t('glossary.intro', ['count' => '80+']),
        ],
    ];

    if (count($pairs) < $limit) {
        $pairs[] = [
            'question' => t('glossary.context'),
            'answer' => $definition,
        ];
    }

    return array_slice($pairs, 0, $limit);
}

/**
 * @param array<int, array<string, mixed>> $pairs
 */
function faqStructuredDataFromPairs(array $pairs, string $id): array
{
    $mainEntity = [];
    foreach ($pairs as $pair) {
        if (!isset($pair['question'], $pair['answer']) || !is_string($pair['question']) || !is_string($pair['answer'])) {
            continue;
        }

        $question = trim($pair['question']);
        $answer = trim($pair['answer']);
        if ($question === '' || $answer === '') {
            continue;
        }

        $mainEntity[] = [
            '@type' => 'Question',
            'name' => $question,
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $answer,
            ],
        ];
    }

    return [
        '@type' => 'FAQPage',
        '@id' => $id,
        'mainEntity' => $mainEntity,
    ];
}

function pageSchemaType(string $page, bool $isGlossaryTerm = false): string
{
    if ($page === 'filieres' || $page === 'ressources' || $page === 'dossiers' || ($page === 'glossaire' && !$isGlossaryTerm)) {
        return 'CollectionPage';
    }

    if ($page === 'glossaire' && $isGlossaryTerm) {
        return 'Article';
    }

    if ($page === 'faq') {
        return 'FAQPage';
    }

    if ($page === 'ressource') {
        return 'Article';
    }

    if ($page === 'dossier') {
        return 'Article';
    }

    return 'WebPage';
}

/**
 * @param array<string, mixed>|null $resource
 * @param array<string, mixed>|null $glossaryTerm
 * @return array<int, array<string, mixed>>
 */
function breadcrumbItems(string $page, ?array $resource = null, ?array $glossaryTerm = null, ?array $dossier = null, ?array $dossierChapter = null): array
{
    $baseUrl = siteBaseUrl();
    $items = [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => t('nav.home'),
            'item' => $baseUrl . canonicalPath('accueil'),
        ],
    ];

    if ($page === 'filieres') {
        $items[] = ['@type' => 'ListItem', 'position' => 2, 'name' => t('nav.sectors'), 'item' => $baseUrl . canonicalPath('filieres')];
    } elseif ($page === 'ressources') {
        $items[] = ['@type' => 'ListItem', 'position' => 2, 'name' => t('nav.resources'), 'item' => $baseUrl . canonicalPath('ressources')];
    } elseif ($page === 'dossiers') {
        $items[] = ['@type' => 'ListItem', 'position' => 2, 'name' => t('nav.dossiers'), 'item' => $baseUrl . canonicalPath('dossiers')];
    } elseif ($page === 'faq') {
        $items[] = ['@type' => 'ListItem', 'position' => 2, 'name' => t('nav.faq'), 'item' => $baseUrl . canonicalPath('faq')];
    } elseif ($page === 'glossaire' && !is_array($glossaryTerm)) {
        $items[] = ['@type' => 'ListItem', 'position' => 2, 'name' => t('nav.glossary'), 'item' => $baseUrl . canonicalPath('glossaire')];
    } elseif ($page === 'glossaire' && is_array($glossaryTerm)) {
        $items[] = ['@type' => 'ListItem', 'position' => 2, 'name' => t('nav.glossary'), 'item' => $baseUrl . canonicalPath('glossaire')];
        $items[] = [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => isset($glossaryTerm['term']) && is_string($glossaryTerm['term']) ? $glossaryTerm['term'] : t('nav.glossary'),
            'item' => $baseUrl . canonicalPath('glossaire', '', glossaryEntrySlug($glossaryTerm)),
        ];
    } elseif ($page === 'ressource') {
        $items[] = ['@type' => 'ListItem', 'position' => 2, 'name' => t('nav.resources'), 'item' => $baseUrl . canonicalPath('ressources')];
        $items[] = [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => isset($resource['title']) && is_string($resource['title']) ? $resource['title'] : t('resources.default_resource'),
            'item' => $baseUrl . canonicalPath('ressource', isset($resource['id']) && is_string($resource['id']) ? $resource['id'] : ''),
        ];
    } elseif ($page === 'dossier') {
        $dossierId = isset($dossier['id']) && is_string($dossier['id']) ? $dossier['id'] : '';
        $chapterId = isset($dossierChapter['id']) && is_string($dossierChapter['id']) ? $dossierChapter['id'] : '';
        $items[] = ['@type' => 'ListItem', 'position' => 2, 'name' => t('nav.dossiers'), 'item' => $baseUrl . canonicalPath('dossiers')];
        $items[] = [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => isset($dossier['title']) && is_string($dossier['title']) ? $dossier['title'] : t('dossiers.eyebrow'),
            'item' => $baseUrl . canonicalPath('dossier', '', '', $dossierId, $chapterId),
        ];
    }

    return $items;
}

/**
 * @param array<int, array<string, mixed>> $sectors
 * @return array<string, mixed>
 */
function sectorItemList(array $sectors, string $baseUrl): array
{
    $items = [];
    foreach ($sectors as $position => $sector) {
        $items[] = [
            '@type' => 'ListItem',
            'position' => $position + 1,
            'name' => isset($sector['label']) && is_string($sector['label']) ? $sector['label'] : t('nav.sectors'),
            'description' => isset($sector['summary']) && is_string($sector['summary']) ? $sector['summary'] : '',
            'url' => $baseUrl . canonicalPath('filieres'),
        ];
    }

    return [
        '@type' => 'ItemList',
        '@id' => $baseUrl . canonicalPath('filieres') . '#sector-list',
        'name' => t('sectors.title'),
        'itemListElement' => $items,
    ];
}

/**
 * @param array<int, array<string, mixed>> $resources
 * @return array<string, mixed>
 */
function resourceItemList(array $resources, string $baseUrl): array
{
    $items = [];
    foreach ($resources as $position => $resource) {
        $id = isset($resource['id']) && is_string($resource['id']) ? $resource['id'] : '';
        $items[] = [
            '@type' => 'ListItem',
            'position' => $position + 1,
            'name' => isset($resource['title']) && is_string($resource['title']) ? $resource['title'] : t('resources.default_resource'),
            'description' => isset($resource['description']) && is_string($resource['description']) ? $resource['description'] : '',
            'url' => $baseUrl . canonicalPath('ressource', $id),
        ];
    }

    return [
        '@type' => 'ItemList',
        '@id' => $baseUrl . canonicalPath('ressources') . '#resource-list',
        'name' => t('resources.title'),
        'itemListElement' => $items,
    ];
}

/**
 * @param array<int, array<string, mixed>> $dossiers
 * @return array<string, mixed>
 */
function dossierItemList(array $dossiers, string $baseUrl): array
{
    $items = [];
    foreach ($dossiers as $position => $dossier) {
        $id = isset($dossier['id']) && is_string($dossier['id']) ? $dossier['id'] : '';
        $items[] = [
            '@type' => 'ListItem',
            'position' => $position + 1,
            'name' => isset($dossier['title']) && is_string($dossier['title']) ? $dossier['title'] : t('dossiers.eyebrow'),
            'description' => isset($dossier['subtitle']) && is_string($dossier['subtitle']) ? $dossier['subtitle'] : '',
            'url' => $baseUrl . canonicalPath('dossier', '', '', $id),
        ];
    }

    return [
        '@type' => 'ItemList',
        '@id' => $baseUrl . canonicalPath('dossiers') . '#dossier-list',
        'name' => t('dossiers.title'),
        'itemListElement' => $items,
    ];
}

/**
 * @param array<string, mixed> $dossier
 * @param array<string, mixed>|null $chapter
 * @return array<string, mixed>
 */
function dossierArticleStructuredData(array $dossier, ?array $chapter, string $canonicalUrl, string $baseUrl, string $siteTitle, string $dateModified): array
{
    $title = isset($dossier['title']) && is_string($dossier['title']) ? $dossier['title'] : 'MyAgri-Dossier';
    $headline = $title;
    if (isset($chapter['title']) && is_string($chapter['title']) && $chapter['title'] !== '') {
        $headline = $chapter['title'] . ' | ' . $title;
    }

    $description = isset($chapter['summary']) && is_string($chapter['summary'])
        ? $chapter['summary']
        : (isset($dossier['subtitle']) && is_string($dossier['subtitle']) ? $dossier['subtitle'] : '');

    return [
        '@type' => 'Article',
        '@id' => $canonicalUrl . '#article',
        'headline' => $headline,
        'description' => $description,
        'mainEntityOfPage' => $canonicalUrl,
        'image' => $baseUrl . (isset($dossier['illustration']) && is_string($dossier['illustration']) ? $dossier['illustration'] : '/assets/img/hero.png'),
        'inLanguage' => siteLanguage(),
        'datePublished' => $dateModified,
        'dateModified' => $dateModified,
        'author' => [
            '@type' => 'Organization',
            'name' => 'MyAgri',
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => $siteTitle,
            'logo' => [
                '@type' => 'ImageObject',
                'url' => $baseUrl . '/assets/img/logo-myagri.svg',
            ],
        ],
    ];
}

/**
 * @param array<int, array<string, mixed>> $faq
 * @return array<string, mixed>
 */
function faqStructuredData(array $faq, string $canonicalUrl): array
{
    $questions = [];
    foreach ($faq as $item) {
        if (!isset($item['q'], $item['a']) || !is_string($item['q']) || !is_string($item['a'])) {
            continue;
        }

        $questions[] = [
            '@type' => 'Question',
            'name' => $item['q'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $item['a'],
            ],
        ];
    }

    return [
        '@type' => 'FAQPage',
        '@id' => $canonicalUrl . '#faq',
        'mainEntity' => $questions,
    ];
}

/**
 * @param array<int, array<string, mixed>> $glossary
 * @return array<string, mixed>
 */
function glossaryStructuredData(array $glossary, string $canonicalUrl): array
{
    $terms = [];
    foreach ($glossary as $entry) {
        if (!isset($entry['term'], $entry['definition']) || !is_string($entry['term']) || !is_string($entry['definition'])) {
            continue;
        }

        $terms[] = [
            '@type' => 'DefinedTerm',
            'name' => $entry['term'],
            'description' => $entry['definition'],
        ];
    }

    return [
        '@type' => 'DefinedTermSet',
        '@id' => $canonicalUrl . '#glossary',
        'name' => t('glossary.title'),
        'hasDefinedTerm' => $terms,
    ];
}

/**
 * @param array<string, mixed> $resource
 * @return array<string, mixed>
 */
function resourceArticleStructuredData(
    array $resource,
    string $canonicalUrl,
    string $baseUrl,
    string $siteTitle,
    string $dateModified,
    array $siteGeo = []
): array {
    $siteName = isset($siteGeo['name']) && is_string($siteGeo['name']) ? trim($siteGeo['name']) : '';
    if ($siteName === '') {
        $siteName = t('geo.name');
    }

    return [
        '@type' => 'Article',
        '@id' => $canonicalUrl . '#article',
        'headline' => isset($resource['title']) && is_string($resource['title']) ? $resource['title'] : 'MyAgri-Ressource',
        'description' => isset($resource['description']) && is_string($resource['description']) ? $resource['description'] : '',
        'articleBody' => resourcePlainText($resource),
        'mainEntityOfPage' => $canonicalUrl,
        'mainEntity' => ['@id' => $canonicalUrl . '#faq'],
        'spatialCoverage' => $siteName,
        'image' => $baseUrl . '/assets/img/hero.png',
        'keywords' => pageKeywordList(pageSeo('ressource', ['title' => $siteTitle], $resource)['keywords']),
        'inLanguage' => siteLanguage(),
        'datePublished' => $dateModified,
        'author' => [
            '@type' => 'Organization',
            'name' => 'MyAgri',
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => $siteTitle,
            'logo' => [
                '@type' => 'ImageObject',
                'url' => $baseUrl . '/assets/img/logo-myagri.svg',
            ],
        ],
        'dateModified' => $dateModified,
    ];
}

/**
 * @param array<string, mixed> $resource
 */
function resourcePlainText(array $resource): string
{
    $parts = [];
    foreach (['description', 'overview', 'for', 'continuous_content'] as $key) {
        if (isset($resource[$key]) && is_string($resource[$key])) {
            $parts[] = trim($resource[$key]);
        }
    }

    return implode(' ', array_filter($parts));
}

function updatedAtIsoDate(string $updatedAt): string
{
    $months = [
        'januar' => '01',
        'februar' => '02',
        'märz' => '03',
        'maerz' => '03',
        'mai' => '05',
        'juni' => '06',
        'juli' => '07',
        'september' => '09',
        'oktober' => '10',
        'november' => '11',
        'dezember' => '12',
        'janvier' => '01',
        'février' => '02',
        'mars' => '03',
        'avril' => '04',
        'juin' => '06',
        'juillet' => '07',
        'août' => '08',
        'septembre' => '09',
        'octobre' => '10',
        'novembre' => '11',
        'décembre' => '12',
        'january' => '01',
        'february' => '02',
        'march' => '03',
        'april' => '04',
        'may' => '05',
        'june' => '06',
        'july' => '07',
        'august' => '08',
        'september' => '09',
        'october' => '10',
        'december' => '12',
        'januari' => '01',
        'februari' => '02',
        'maart' => '03',
        'mei' => '05',
    ];

    if (preg_match('/^(\d{1,2})\.?\s+([[:alpha:]äöüÄÖÜßéû]+)\s+(\d{4})$/u', mb_strtolower($updatedAt), $matches) === 1) {
        $month = $months[$matches[2]] ?? null;
        if ($month !== null) {
            return sprintf('%04d-%s-%02d', (int) $matches[3], $month, (int) $matches[1]);
        }
    }

    return date('Y-m-d');
}

function canonicalPath(string $page, string $resourceId = '', string $glossaryTerm = '', string $dossierId = '', string $chapterId = '', ?string $language = null): string
{
    $language = normalizePortalLanguage($language ?? currentLanguage());

    if ($page === 'ressource') {
        if ($resourceId === '') {
            return localizedUrl(['page' => 'ressources'], $language);
        }

        return localizedUrl(['page' => 'ressource', 'resource' => $resourceId], $language);
    }

    if ($page === 'glossaire' && $glossaryTerm !== '') {
        return localizedUrl(['page' => 'glossaire', 'term' => $glossaryTerm], $language);
    }

    if ($page === 'dossier') {
        if ($dossierId === '') {
            return localizedUrl(['page' => 'dossiers'], $language);
        }

        $params = ['page' => 'dossier', 'dossier' => $dossierId];
        if ($chapterId !== '') {
            $params['chapitre'] = $chapterId;
        }

        return localizedUrl($params, $language);
    }

    if ($page === 'accueil') {
        return localizedUrl(['page' => 'accueil'], $language);
    }

    if (in_array($page, ['filieres', 'ressources', 'faq', 'glossaire', 'dossiers'], true)) {
        return localizedUrl(['page' => $page], $language);
    }

    return localizedUrl(['page' => 'accueil'], $language);
}

function glossarySlug(string $term): string
{
    $normalized = trim($term);
    if ($normalized === '') {
        return '';
    }

    $normalized = strtr($normalized, [
        "\xC3\xA0" => 'a',
        "\xC3\xA1" => 'a',
        "\xC3\xA2" => 'a',
        "\xC3\xA3" => 'a',
        "\xC3\xA4" => 'a',
        "\xC3\xA5" => 'a',
        "\xC3\xA7" => 'c',
        "\xC3\xA8" => 'e',
        "\xC3\xA9" => 'e',
        "\xC3\xAA" => 'e',
        "\xC3\xAB" => 'e',
        "\xC3\xAC" => 'i',
        "\xC3\xAD" => 'i',
        "\xC3\xAE" => 'i',
        "\xC3\xAF" => 'i',
        "\xC3\xB1" => 'n',
        "\xC3\xB2" => 'o',
        "\xC3\xB3" => 'o',
        "\xC3\xB4" => 'o',
        "\xC3\xB5" => 'o',
        "\xC3\xB6" => 'o',
        "\xC3\xB8" => 'o',
        "\xC3\xB9" => 'u',
        "\xC3\xBA" => 'u',
        "\xC3\xBB" => 'u',
        "\xC3\xBC" => 'u',
        "\xC3\xBD" => 'y',
        "\xC3\xBF" => 'y',
        "\xC3\x80" => 'a',
        "\xC3\x81" => 'a',
        "\xC3\x82" => 'a',
        "\xC3\x83" => 'a',
        "\xC3\x84" => 'a',
        "\xC3\x85" => 'a',
        "\xC3\x86" => 'ae',
        "\xC3\x87" => 'c',
        "\xC3\x88" => 'e',
        "\xC3\x89" => 'e',
        "\xC3\x8A" => 'e',
        "\xC3\x8B" => 'e',
        "\xC3\x8C" => 'i',
        "\xC3\x8D" => 'i',
        "\xC3\x8E" => 'i',
        "\xC3\x8F" => 'i',
        "\xC3\x90" => 'd',
        "\xC3\x91" => 'n',
        "\xC3\x92" => 'o',
        "\xC3\x93" => 'o',
        "\xC3\x94" => 'o',
        "\xC3\x95" => 'o',
        "\xC3\x96" => 'o',
        "\xC3\x98" => 'o',
        "\xC3\x99" => 'u',
        "\xC3\x9A" => 'u',
        "\xC3\x9B" => 'u',
        "\xC3\x9C" => 'u',
        "\xC3\x9F" => 'ss',
        "\xC5\x92" => 'oe',
        "\xC5\x93" => 'oe',
        "\xE2\x80\x98" => ' ',
        "\xE2\x80\x99" => ' ',
        "\xE2\x80\x9C" => ' ',
        "\xE2\x80\x9D" => ' ',
        "\xC2\xAB" => ' ',
        "\xC2\xBB" => ' ',
        "\xE2\x80\x93" => ' ',
        "\xE2\x80\x94" => ' ',
        "\xE2\x80\xA6" => ' ',
        "\xC2\xA0" => ' ',
        "\xC3\x9E" => 'p',
    ]);

    $normalized = mb_strtolower($normalized, 'UTF-8');
    $normalized = preg_replace('/[\'"`]/', ' ', $normalized);

    if (function_exists('iconv')) {
        $converted = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $normalized);
        if (is_string($converted) && $converted !== '') {
            $normalized = $converted;
        }
    }

    $normalized = preg_replace('/[^a-z0-9]+/i', '-', $normalized);
    if (!is_string($normalized)) {
        return '';
    }

    $normalized = preg_replace('/-+/', '-', $normalized);
    return trim($normalized, '-');
}

/**
 * @param array<string, mixed> $entry
 */
function glossaryEntrySlug(array $entry): string
{
    if (isset($entry['slug']) && is_string($entry['slug']) && trim($entry['slug']) !== '') {
        return glossarySlug($entry['slug']);
    }

    if (isset($entry['term']) && is_string($entry['term'])) {
        return glossarySlug($entry['term']);
    }

    return '';
}

/**
 * @return array<string, mixed>|null
 */
function glossaryTermBySlug(array $glossary, string $slug): ?array
{
    $normalizedSlug = glossarySlug($slug);
    foreach ($glossary as $entry) {
        if (!is_array($entry) || !isset($entry['term']) || !is_string($entry['term'])) {
            continue;
        }

        if (glossaryEntrySlug($entry) === $normalizedSlug || glossarySlug($entry['term']) === $normalizedSlug) {
            return $entry;
        }
    }

    return null;
}

/**
 * @param array<int, array<string, mixed>> $glossary
 * @return array<string, mixed>|null
 */
function glossaryTermByTitle(array $glossary, string $termTitle): ?array
{
    foreach ($glossary as $entry) {
        if (!is_array($entry) || !isset($entry['term']) || !is_string($entry['term'])) {
            continue;
        }

        if (mb_strtolower(trim($entry['term'])) === mb_strtolower(trim($termTitle))) {
            return $entry;
        }
    }

    return null;
}

/**
 * @param array<int, array<string, mixed>> $glossary
 * @return array<string, mixed>|null
 */
function glossaryTermById(string $termId, array $glossary): ?array
{
    return glossaryTermBySlug($glossary, $termId);
}

/**
 * Return dedicated glossary template path when it exists.
 */
function glossaryTemplatePath(string $termSlug): ?string
{
    return null;
}

/**
 * @param array<string, mixed> $glossaryTerm
 */
function glossaryTermStructuredData(array $glossaryTerm, string $canonicalUrl): array
{
    $term = isset($glossaryTerm['term']) && is_string($glossaryTerm['term']) ? $glossaryTerm['term'] : t('glossary.default_term');
    $definition = isset($glossaryTerm['definition']) && is_string($glossaryTerm['definition']) ? $glossaryTerm['definition'] : '';
    $base = rtrim($canonicalUrl, '#');

    return [
        '@type' => 'DefinedTerm',
        '@id' => $canonicalUrl . '#definedTerm',
        'name' => $term,
        'description' => $definition,
        'url' => $canonicalUrl,
        'inLanguage' => siteLanguage(),
        'inDefinedTermSet' => [
            '@type' => 'DefinedTermSet',
            'name' => t('glossary.title'),
            '@id' => $base . '#glossary',
            'url' => $base . '#glossary',
        ],
    ];
}

/**
 * @param array<int, mixed> $items
 */
function resourceContinuousText(array $items): string
{
    $parts = [];
    foreach ($items as $item) {
        if (is_string($item) && $item !== '') {
            $parts[] = trim($item);
        }
    }

    return implode(' ', $parts);
}

/**
 * Return dedicated resource template path when it exists.
 */
function resourceTemplatePath(string $resourceId): ?string
{
    return null;
}

function splitTextIntoParagraphs(string $text): array
{
    $text = trim($text);
    if ($text === '') {
        return [];
    }

    $doubleBreaks = preg_split('/\R{2,}/u', $text, -1, PREG_SPLIT_NO_EMPTY);
    if (is_array($doubleBreaks) && count($doubleBreaks) > 1) {
        $paragraphs = [];
        foreach ($doubleBreaks as $paragraph) {
            $clean = trim($paragraph);
            if ($clean !== '') {
                $paragraphs[] = $clean;
            }
        }
        return $paragraphs;
    }

    $sentences = preg_split('/(?<=[\.\?\!\x{2026}])\s+(?=[«A-Za-zÄÖÜäöüßÀ-ÖØ-öø-ÿ0-9])/u', $text, -1, PREG_SPLIT_NO_EMPTY);
    if (!is_array($sentences) || count($sentences) <= 1) {
        return [$text];
    }

    $paragraphs = [];
    $chunkSize = 2;
    for ($i = 0, $count = count($sentences); $i < $count; $i += $chunkSize) {
        $chunk = array_slice($sentences, $i, $chunkSize);
        $paragraph = trim(implode(' ', $chunk));
        if ($paragraph !== '') {
            $paragraphs[] = $paragraph;
        }
    }

    return $paragraphs;
}

function siteBaseUrl(): string
{
    $envBase = getenv('SITE_URL');
    if (is_string($envBase) && $envBase !== '') {
        return rtrim($envBase, '/');
    }

    return 'https://myagri.be';
}

