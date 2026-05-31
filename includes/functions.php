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

    $allowed = ['accueil', 'filieres', 'ressources', 'faq', 'glossaire', 'ressource'];
    return in_array($page, $allowed, true) ? $page : 'accueil';
}

/**
 * @param array<string, mixed> $site
 * @param array<string, mixed>|null $resource
 * @param array<string, mixed>|null $glossaryTerm
 * @return array{title:string,description:string,keywords:string}
 */
/**
 * @param array<string, mixed> $site
 * @param array<string, mixed>|null $resource
 * @param array<string, mixed>|null $glossaryTerm
 * @return array{title:string,description:string,keywords:string}
 */
function pageSeo(string $page, array $site, ?array $resource = null, ?array $glossaryTerm = null): array
{
    $siteTitle = isset($site[''title'']) && is_string($site[''title'']) ? $site[''title''] : ''MyAgri'';

    if ($page === ''filieres'') {
        return [
            ''title'' => ''Filieres agricoles en Wallonie - '' . $siteTitle,
            ''description'' => ''Explorez les filieres agricoles wallonnes : grandes cultures, elevation, marai chage, diversification, enjeux et actions citoyennes.'',
            ''keywords'' => ''filieres agricoles, wallonie, elevation, cultures, maraichage, diversification, agriculture durable'',
        ];
    }

    if ($page === ''ressources'') {
        return [
            ''title'' => ''Ressources agricoles pratiques - '' . $siteTitle,
            ''description'' => ''Retrouvez des ressources pratiques : aides, formations, marches locaux, labels, consommation responsable et outils pedagogiques.'',
            ''keywords'' => ''ressources agricoles, aides agricoles, marches locaux, labels, formation agricole, consommation responsable'',
        ];
    }

    if ($page === ''faq'') {
        return [
            ''title'' => ''FAQ citoyenne sur l''agriculture wallonne - '' . $siteTitle,
            ''description'' => ''Reponses claires aux questions frequentes sur les prix agricoles, les circuits courts, la souverainete alimentaire et les actions citoyennes.'',
            ''keywords'' => ''faq agriculture wallonne, questions agriculture, circuits courts, prix agricoles, souverainete alimentaire'',
        ];
    }

    if ($page === ''glossaire'' && is_array($glossaryTerm) && isset($glossaryTerm[''term'']) && is_string($glossaryTerm[''term''])) {
        $termTitle = $glossaryTerm[''term''];
        $termDescription = isset($glossaryTerm[''definition'']) && is_string($glossaryTerm[''definition''])
            ? $glossaryTerm[''definition'']
            : ''Definition et applications concretes.'';

        return [
            ''title'' => $termTitle . '' - Glossaire agricole citoyen - '' . $siteTitle,
            ''description'' => $termDescription,
            ''keywords'' => strtolower($termTitle) . '', glossaire agricole, agriculture wallonne, definitions agricoles'',
        ];
    }

    if ($page === ''glossaire'') {
        return [
            ''title'' => ''Glossaire agricole citoyen - '' . $siteTitle,
            ''description'' => ''Comprendre les mots cles de l\'agriculture wallonne : agroecologie, rotation, circuit court, biodiversite, filiere et transition.'',
            ''keywords'' => ''glossaire agricole, vocabulaire agriculture, definitions agriculture, agroecologie, circuit court, wallonie'',
        ];
    }

    if ($page === ''ressource'' && is_array($resource)) {
        $resourceTitle = isset($resource[''title'']) && is_string($resource[''title'']) ? $resource[''title''] : ''Ressource'';
        $resourceDescription = isset($resource[''description'']) && is_string($resource[''description''])
            ? $resource[''description'']
            : ''Ressource pratique du portail MyAgri.'';

        return [
            ''title'' => $resourceTitle . '' - '' . $siteTitle,
            ''description'' => $resourceDescription,
            ''keywords'' => strtolower($resourceTitle) . '', agriculture wallonne, ressource pratique, myagri'',
        ];
    }

    return [
        ''title'' => $siteTitle,
        ''description'' => ''Portail citoyen pour comprendre l\'agriculture wallonne : alimentation, environnement, metiers, filieres et ressources utiles.'',
        ''keywords'' => ''agriculture wallonne, portail citoyen, alimentation locale, environnement, filieres agricoles, ressources'',
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
    ?array $glossaryTerm = null
): array {
    $baseUrl = siteBaseUrl();
    $siteTitle = isset($site['title']) && is_string($site['title']) ? $site['title'] : 'MyAgri';
    $siteSubtitle = isset($site['subtitle']) && is_string($site['subtitle']) ? $site['subtitle'] : '';
    $dateModified = updatedAtIsoDate(isset($site['updated_at']) && is_string($site['updated_at']) ? $site['updated_at'] : '');
    $resourceId = isset($resource['id']) && is_string($resource['id']) ? $resource['id'] : '';
    $glossaryTermSlug = is_array($glossaryTerm) && isset($glossaryTerm['term']) && is_string($glossaryTerm['term'])
        ? glossarySlug($glossaryTerm['term'])
        : '';
    $seo = pageSeo($page, $site, $resource, $glossaryTerm);
    $canonicalUrl = $baseUrl . canonicalPath($page, $resourceId, $glossaryTermSlug);

    $graph = [
        [
            '@type' => 'Organization',
            '@id' => $baseUrl . '/#organization',
            'name' => 'MyAgri',
            'url' => $baseUrl,
            'logo' => $baseUrl . '/assets/img/og-default.svg',
            'areaServed' => [
                '@type' => 'AdministrativeArea',
                'name' => 'Wallonie',
            ],
        ],
        [
            '@type' => 'WebSite',
            '@id' => $baseUrl . '/#website',
            'name' => $siteTitle,
            'alternateName' => 'MyAgri',
            'url' => $baseUrl,
            'description' => $siteSubtitle,
            'inLanguage' => 'fr-BE',
            'keywords' => pageKeywordList($seo['keywords']),
            'publisher' => ['@id' => $baseUrl . '/#organization'],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => $baseUrl . '/?page=accueil&q={search_term_string}',
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
            'isPartOf' => ['@id' => $baseUrl . '/#website'],
            'primaryImageOfPage' => [
                '@type' => 'ImageObject',
                'url' => $baseUrl . '/assets/img/hero.png',
                'caption' => 'Paysage agricole wallon illustrant le portail citoyen MyAgri.',
            ],
            'keywords' => pageKeywordList($seo['keywords']),
            'about' => [
                'agriculture wallonne',
                'alimentation locale',
                'filiÃ¨res agricoles',
                'ressources citoyennes',
            ],
            'audience' => [
                '@type' => 'Audience',
                'audienceType' => 'Citoyens, familles, enseignants, collectivitÃ©s et acteurs agricoles en Wallonie',
            ],
            'inLanguage' => 'fr-BE',
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
            'itemListElement' => breadcrumbItems($page, $resource, $glossaryTerm),
        ],
    ];

    if ($page === 'filieres') {
        $graph[] = sectorItemList($sectors, $baseUrl);
    }

    if ($page === 'ressources') {
        $graph[] = resourceItemList($resources, $baseUrl);
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
        $graph[] = resourceArticleStructuredData($resource, $canonicalUrl, $baseUrl, $siteTitle, $dateModified);
        $graph[] = faqStructuredDataFromPairs(
            resourceFaqPairs($resource),
            $canonicalUrl . '#faq'
        );
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
            'De quoi parle cette ressource ?',
            $resource['title'] . ' : ' . $resource['description']
        );
    }

    if (isset($resource['for']) && is_string($resource['for']) && trim($resource['for']) !== '') {
        $add('Qui peut sâ€™appuyer sur cette ressource ?', trim($resource['for']));
    }

    if (isset($resource['overview']) && is_string($resource['overview']) && trim($resource['overview']) !== '') {
        $add('Quel est lâ€™objectif de cette ressource ?', trim($resource['overview']));
    }

    if (is_array($resource['steps'] ?? null) && $resource['steps'] !== []) {
        $steps = array_slice(array_values(array_filter($resource['steps'], 'is_string')), 0, 3);
        if ($steps !== []) {
            $add('Quelle marche a suivre ?', implode(' / ', array_map('trim', $steps)));
        }
    }

    if (is_array($resource['checklist'] ?? null) && $resource['checklist'] !== []) {
        $items = array_slice(array_values(array_filter($resource['checklist'], 'is_string')), 0, 3);
        if ($items !== []) {
            $add('Quels points verifier en premier ?', 'Principaux points : ' . implode(' ; ', array_map('trim', $items)));
        }
    }

    if (is_array($resource['timeline'] ?? null) && $resource['timeline'] !== []) {
        $items = array_slice(array_values(array_filter($resource['timeline'], 'is_string')), 0, 3);
        if ($items !== []) {
            $add('Comment suit-on le calendrier ?', implode(' > ', array_map('trim', $items)));
        }
    }

    if (is_array($resource['support_contacts'] ?? null) && $resource['support_contacts'] !== []) {
        $items = array_slice(array_values(array_filter($resource['support_contacts'], 'is_string')), 0, 2);
        if ($items !== []) {
            $add('Qui peut accompagner ?', implode(' ; ', array_map('trim', $items)));
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
            'question' => sprintf('Que signifie le terme \"%s\" ?', $term),
            'answer' => $definition,
        ],
        [
            'question' => 'Pourquoi ce terme est-il important pour une politique agricole ?',
            'answer' => 'Il permet de comprendre un choix de pratique et de mesurer son impact.',
        ],
    ];

    return array_slice($pairs, 0, $limit);
}

/**
 * @param array<int, array{question:string, answer:string}> $pairs
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
    if ($page === 'filieres' || $page === 'ressources' || ($page === 'glossaire' && !$isGlossaryTerm)) {
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

    return 'WebPage';
}

/**
 * @param array<string, mixed>|null $resource
 * @param array<string, mixed>|null $glossaryTerm
 * @return array<int, array<string, mixed>>
 */
function breadcrumbItems(string $page, ?array $resource = null, ?array $glossaryTerm = null): array
{
    $baseUrl = siteBaseUrl();
    $items = [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Accueil',
            'item' => $baseUrl . '/?page=accueil',
        ],
    ];

    if ($page === 'filieres') {
        $items[] = ['@type' => 'ListItem', 'position' => 2, 'name' => 'FiliÃ¨res', 'item' => $baseUrl . '/?page=filieres'];
    } elseif ($page === 'ressources') {
        $items[] = ['@type' => 'ListItem', 'position' => 2, 'name' => 'Ressources', 'item' => $baseUrl . '/?page=ressources'];
    } elseif ($page === 'faq') {
        $items[] = ['@type' => 'ListItem', 'position' => 2, 'name' => 'FAQ', 'item' => $baseUrl . '/?page=faq'];
    } elseif ($page === 'glossaire' && !is_array($glossaryTerm)) {
        $items[] = ['@type' => 'ListItem', 'position' => 2, 'name' => 'Glossaire', 'item' => $baseUrl . '/?page=glossaire'];
    } elseif ($page === 'glossaire' && is_array($glossaryTerm)) {
        $items[] = ['@type' => 'ListItem', 'position' => 2, 'name' => 'Glossaire', 'item' => $baseUrl . '/?page=glossaire'];
        $items[] = [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => isset($glossaryTerm['term']) && is_string($glossaryTerm['term']) ? $glossaryTerm['term'] : 'Glossaire',
            'item' => $baseUrl . canonicalPath('glossaire', '', glossarySlug(is_array($glossaryTerm) && isset($glossaryTerm['term']) && is_string($glossaryTerm['term']) ? $glossaryTerm['term'] : '')),
        ];
    } elseif ($page === 'ressource') {
        $items[] = ['@type' => 'ListItem', 'position' => 2, 'name' => 'Ressources', 'item' => $baseUrl . '/?page=ressources'];
        $items[] = [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => isset($resource['title']) && is_string($resource['title']) ? $resource['title'] : 'Ressource',
            'item' => $baseUrl . canonicalPath('ressource', isset($resource['id']) && is_string($resource['id']) ? $resource['id'] : ''),
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
            'name' => isset($sector['label']) && is_string($sector['label']) ? $sector['label'] : 'FiliÃ¨re agricole',
            'description' => isset($sector['summary']) && is_string($sector['summary']) ? $sector['summary'] : '',
            'url' => $baseUrl . '/?page=filieres',
        ];
    }

    return [
        '@type' => 'ItemList',
        '@id' => $baseUrl . '/?page=filieres#sector-list',
        'name' => 'FiliÃ¨res agricoles en Wallonie',
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
            'name' => isset($resource['title']) && is_string($resource['title']) ? $resource['title'] : 'Ressource agricole',
            'description' => isset($resource['description']) && is_string($resource['description']) ? $resource['description'] : '',
            'url' => $baseUrl . canonicalPath('ressource', $id),
        ];
    }

    return [
        '@type' => 'ItemList',
        '@id' => $baseUrl . '/?page=ressources#resource-list',
        'name' => 'Ressources pratiques sur lâ€™agriculture wallonne',
        'itemListElement' => $items,
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
        'name' => 'Glossaire agricole citoyen',
        'hasDefinedTerm' => $terms,
    ];
}

/**
 * @param array<string, mixed> $resource
 * @return array<string, mixed>
 */
function resourceArticleStructuredData(array $resource, string $canonicalUrl, string $baseUrl, string $siteTitle, string $dateModified): array
{
    return [
        '@type' => 'Article',
        '@id' => $canonicalUrl . '#article',
        'headline' => isset($resource['title']) && is_string($resource['title']) ? $resource['title'] : 'Ressource MyAgri',
        'description' => isset($resource['description']) && is_string($resource['description']) ? $resource['description'] : '',
        'articleBody' => resourcePlainText($resource),
        'mainEntityOfPage' => $canonicalUrl,
        'mainEntity' => ['@id' => $canonicalUrl . '#faq'],
        'image' => $baseUrl . '/assets/img/hero.png',
        'keywords' => pageKeywordList(pageSeo('ressource', ['title' => $siteTitle], $resource)['keywords']),
        'inLanguage' => 'fr-BE',
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
                'url' => $baseUrl . '/assets/img/og-default.svg',
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
        'janvier' => '01',
        'fÃ©vrier' => '02',
        'mars' => '03',
        'avril' => '04',
        'mai' => '05',
        'juin' => '06',
        'juillet' => '07',
        'aoÃ»t' => '08',
        'septembre' => '09',
        'octobre' => '10',
        'novembre' => '11',
        'dÃ©cembre' => '12',
    ];

    if (preg_match('/^(\d{1,2})\s+([[:alpha:]]+)\s+(\d{4})$/u', mb_strtolower($updatedAt), $matches) === 1) {
        $month = $months[$matches[2]] ?? null;
        if ($month !== null) {
            return sprintf('%04d-%s-%02d', (int) $matches[3], $month, (int) $matches[1]);
        }
    }

    return date('Y-m-d');
}

function canonicalPath(string $page, string $resourceId = '', string $glossaryTerm = ''): string
{
    if ($page === 'ressource' && $resourceId !== '') {
        return '/?page=ressource&resource=' . rawurlencode($resourceId);
    }

    if ($page === 'glossaire' && $glossaryTerm !== '') {
        return '/?page=glossaire&term=' . rawurlencode($glossaryTerm);
    }

    if (in_array($page, ['accueil', 'filieres', 'ressources', 'faq', 'glossaire'], true)) {
        return '/?page=' . rawurlencode($page);
    }

    return '/?page=accueil';
}

function glossarySlug(string $term): string
{
    $normalized = trim($term);
    if ($normalized === '') {
        return '';
    }

    $normalized = html_entity_decode($normalized, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $normalized = strtolower($normalized);

    $utf8Map = [
        "\xC3\x80" => 'a',
        "\xC3\x81" => 'a',
        "\xC3\x82" => 'a',
        "\xC3\x83" => 'a',
        "\xC3\x84" => 'a',
        "\xC3\x85" => 'a',
        "\xC3\x89" => 'e',
        "\xC3\x88" => 'e',
        "\xC3\x8A" => 'e',
        "\xC3\x8B" => 'e',
        "\xC3\x8E" => 'i',
        "\xC3\x8F" => 'i',
        "\xC3\x8F" => 'i',
        "\xC3\x9C" => 'u',
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
        "\xC3\xB0" => 'd',
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
        "\xC5\x92" => 'oe',
        "\xC5\x93" => 'oe',
        "\xC3\x86" => 'ae',
        "\xC3\xA6" => 'ae',
        "\xE2\x80\x99" => '-',
        "\xE2\x80\x9C" => '',
        "\xE2\x80\x9D" => '',
        "\xE2\x80\x93" => '-',
        "\xE2\x80\x94" => '-',
        "\xE2\x80\xA6" => '-',
        "\xC2\xA0" => ' ',
        'ï¿½' => 'a',
        'ï¿½' => 'a',
    ];

    $normalized = strtr($normalized, $utf8Map);

    $slug = preg_replace('/[^a-z0-9]+/i', '-', $normalized);
    if (!is_string($slug)) {
        return '';
    }

    $slug = preg_replace('/-+/', '-', $slug);
    return trim($slug, '-');
}

/**
 * @param array<int, array<string, mixed>> $glossary
 * @return array<string, mixed>|null
 */
function glossaryTermBySlug(array $glossary, string $slug): ?array
{
    $normalizedSlug = glossarySlug($slug);
    foreach ($glossary as $entry) {
        if (!is_array($entry) || !isset($entry['term']) || !is_string($entry['term'])) {
            continue;
        }

        if (glossarySlug($entry['term']) === $normalizedSlug) {
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
    $normalized = trim($termSlug);
    if (!preg_match('/^[a-z0-9-]+$/', $normalized)) {
        return null;
    }

    $candidate = __DIR__ . '/views/glossaire/term-' . $normalized . '.php';
    if (is_file($candidate)) {
        return $candidate;
    }

    return null;
}

/**
 * @param array<string, mixed> $glossaryTerm
 */
function glossaryTermStructuredData(array $glossaryTerm, string $canonicalUrl): array
{
    $term = isset($glossaryTerm['term']) && is_string($glossaryTerm['term']) ? $glossaryTerm['term'] : 'Terme';
    $definition = isset($glossaryTerm['definition']) && is_string($glossaryTerm['definition']) ? $glossaryTerm['definition'] : '';

    return [
        '@type' => 'DefinedTerm',
        '@id' => $canonicalUrl . '#definedTerm',
        'name' => $term,
        'description' => $definition,
        'url' => $canonicalUrl,
        'inLanguage' => 'fr-BE',
        'inDefinedTermSet' => [
            '@type' => 'DefinedTermSet',
            'name' => 'Glossaire agricole citoyen',
            '@id' => rtrim(str_replace('#definedTerm', '', $canonicalUrl), '#') . '#glossary',
            'url' => rtrim(str_replace('#definedTerm', '', $canonicalUrl), '#') . '#glossary',
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
    $normalized = trim($resourceId);
    if (!preg_match('/^[a-z0-9-]+$/', $normalized)) {
        return null;
    }

    $candidate = __DIR__ . '/views/resources/resource-' . $normalized . '.php';
    if (is_file($candidate)) {
        return $candidate;
    }

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

    $sentences = preg_split('/(?<=[\.\?\!\x{2026}])\s+(?=[Â«A-Za-zÃ€-Ã¿0-9])/u', $text, -1, PREG_SPLIT_NO_EMPTY);
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





