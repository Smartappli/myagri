<?php declare(strict_types=1);

/**
 * @return array<string, array<string, string>>
 */
function portalLanguages(): array
{
    return [
        'fr' => ['code' => 'fr', 'name' => 'Français', 'native' => 'Français', 'html_lang' => 'fr-BE', 'locale' => 'fr_BE', 'hreflang' => 'fr-BE'],
        'en' => ['code' => 'en', 'name' => 'English', 'native' => 'English', 'html_lang' => 'en-BE', 'locale' => 'en_BE', 'hreflang' => 'en-BE'],
        'ge' => ['code' => 'ge', 'name' => 'Deutsch', 'native' => 'Deutsch', 'html_lang' => 'de-BE', 'locale' => 'de_BE', 'hreflang' => 'de-BE'],
        'nl' => ['code' => 'nl', 'name' => 'Nederlands', 'native' => 'Nederlands', 'html_lang' => 'nl-BE', 'locale' => 'nl_BE', 'hreflang' => 'nl-BE'],
    ];
}

function defaultPortalLanguage(): string
{
    return 'fr';
}

function normalizePortalLanguage(?string $language): string
{
    $language = strtolower(trim((string) $language));
    if ($language === 'de') {
        return 'ge';
    }

    return array_key_exists($language, portalLanguages()) ? $language : defaultPortalLanguage();
}

function currentLanguage(): string
{
    $language = $_GET['lang'] ?? null;
    if (is_string($language) && $language !== '') {
        return normalizePortalLanguage($language);
    }

    return defaultPortalLanguage();
}

/**
 * @return array<string, string>
 */
function portalLanguageConfig(?string $language = null): array
{
    $code = normalizePortalLanguage($language ?? currentLanguage());
    return portalLanguages()[$code];
}

/**
 * @return array<string, mixed>
 */
function getPortalData(?string $language = null): array
{
    static $cache = [];

    $code = normalizePortalLanguage($language ?? currentLanguage());
    if (isset($cache[$code])) {
        return $cache[$code];
    }

    $path = __DIR__ . '/translations/' . $code . '.php';
    if (!is_file($path)) {
        $path = __DIR__ . '/translations/' . defaultPortalLanguage() . '.php';
        $code = defaultPortalLanguage();
    }

    $data = require $path;
    if (!is_array($data)) {
        throw new RuntimeException('Invalid portal translation file: ' . $path);
    }

    $data['language'] = portalLanguageConfig($code);
    $data['ui'] = portalUiTranslations($code);

    return $cache[$code] = $data;
}

/**
 * @return array<string, mixed>
 */
function portalUiTranslations(?string $language = null): array
{
    $code = normalizePortalLanguage($language ?? currentLanguage());
    $translations = [
        'fr' => [
            'nav.home' => 'Accueil',
            'nav.sectors' => 'Filières',
            'nav.resources' => 'Ressources',
            'nav.dossiers' => 'Dossiers',
            'nav.faq' => 'FAQ',
            'nav.glossary' => 'Glossaire',
            'head.llms_short_title' => 'Résumé MyAgri pour les moteurs génératifs',
            'head.llms_full_title' => 'Corpus MyAgri pour les moteurs génératifs',
            'head.api_title' => 'Données structurées MyAgri',
            'head.image_alt' => 'Paysage agricole wallon illustrant le portail citoyen MyAgri',
            'head.brand_aria' => 'Accueil MyAgri',
            'head.nav_aria' => 'Navigation principale',
            'hero.updated_prefix' => 'Mis à jour le',
            'hero.geo_label' => 'Wallonie, Belgique',
            'language.label' => 'Langue',
            'language.aria' => 'Choisir la langue du site',
            'search.label' => 'Recherche globale',
            'search.placeholder' => 'ex. eau, élevage, saison',
            'footer.description' => 'MyAgri - portail public d’information sur l’agriculture.',
            'footer.nav_aria' => 'Liens techniques et éditoriaux',
            'footer.llms' => 'Résumé LLM',
            'footer.last_update' => 'Dernière mise à jour',
            'home.eyebrow' => 'Comprendre, choisir, transmettre',
            'home.title' => 'Par où commencer ?',
            'home.intro' => 'MyAgri organise les informations sur l’agriculture wallonne selon des usages clairs : comprendre les filières, préparer des démarches concrètes et vérifier les termes avant d’en parler.',
            'home.card_sector_title' => 'Comprendre une filière',
            'home.card_sector_text' => 'Repérez les productions, les contraintes pratiques et les actions possibles.',
            'home.card_sector_cta' => 'Explorer les filières',
            'home.card_action_title' => 'Préparer une action',
            'home.card_action_text' => 'Utilisez les guides pour visites, achats locaux, ateliers, orientation ou projets.',
            'home.card_action_cta' => 'Voir les ressources',
            'home.card_term_title' => 'Clarifier un terme',
            'home.card_term_text' => 'Utilisez les définitions pour lire un article, préparer un cours ou comparer des démarches.',
            'home.card_term_cta' => 'Ouvrir le glossaire',
            'home.card_dossier_title' => 'Approfondir un sujet',
            'home.card_dossier_text' => 'Lisez des dossiers illustrés avec chapitres courts, repères et sources vérifiables.',
            'home.card_dossier_cta' => 'Voir les dossiers',
            'home.basics_title' => 'Repères de base',
            'home.editorial_eyebrow' => 'Méthode éditoriale',
            'home.editorial_title' => 'Contenus propres, sources vérifiables',
            'home.editorial_intro' => 'MyAgri ne rassemble pas des définitions copiées. Le portail reformule, contextualise et indique quand une information doit être vérifiée auprès d’un organisme compétent.',
            'home.pillars_title' => 'Les 4 piliers',
            'home.themes_title' => 'Thèmes transversaux',
            'home.provinces_title' => 'Lire par province',
            'home.calendar_title' => 'Calendrier agricole simplifié',
            'sectors.title' => 'Explorer les filières',
            'sectors.intro' => 'Chaque filière relie productions, métiers, contraintes pratiques, débouchés et choix de consommation. Cette page relie ce que l’on voit dans le paysage à ce qui arrive dans l’assiette.',
            'sectors.filter_placeholder' => 'ex. lait, saison, cultures',
            'sectors.filter_aria' => 'Filtrer les filières',
            'sectors.issues' => 'Enjeux',
            'sectors.public_actions' => 'Que peut faire le public ?',
            'resources.title' => 'Ressources utiles',
            'resources.intro' => 'Des guides pratiques pour passer de l’intention à l’action : organiser une visite, comparer des labels, mieux acheter, découvrir des métiers ou préparer un dossier d’accompagnement.',
            'resources.for' => 'Pour',
            'resources.detail_link' => 'Voir la fiche détaillée',
            'resources.not_found_title' => 'Ressource introuvable',
            'resources.not_found_text' => 'La ressource demandée n’existe pas ou n’est plus disponible.',
            'resources.back_list' => 'Retour à la liste des ressources',
            'resources.back' => 'Retour aux ressources',
            'resources.target' => 'Public cible',
            'resources.intro_title' => 'Introduction générale',
            'resources.verification_title' => 'Vérifier avant d’agir',
            'resources.verification_text' => '{resource} fournit une orientation pratique. Avant une décision engageante, documentez les sources, les coûts, les contraintes locales et les personnes consultées.',
            'resources.default_resource' => 'cette ressource',
            'resources.section_steps' => 'Étapes recommandées',
            'resources.section_checklist' => 'Checklist pratique',
            'resources.section_eligible_projects' => 'Projets généralement éligibles',
            'resources.section_required_documents' => 'Documents souvent demandés',
            'resources.section_timeline' => 'Calendrier indicatif',
            'resources.section_common_pitfalls' => 'Erreurs fréquentes à éviter',
            'resources.section_support_contacts' => 'Accompagnateurs possibles',
            'resources.section_learning_objectives' => 'Objectifs d’apprentissage',
            'resources.section_recommended_program' => 'Déroulé recommandé',
            'resources.section_age_adaptations' => 'Adaptation selon l’âge du public',
            'resources.section_pedagogical_activities' => 'Exemples d’activités pédagogiques',
            'resources.section_risk_prevention' => 'Prévention et sécurité',
            'resources.section_budget_items' => 'Postes budgétaires à prévoir',
            'resources.section_evaluation_method' => 'Méthode d’évaluation',
            'dossiers.title' => 'Dossiers citoyens',
            'dossiers.intro' => 'Des dossiers thématiques pour comprendre les liens entre pratiques agricoles, environnement, alimentation locale et décisions collectives.',
            'dossiers.cta' => 'Lire le dossier',
            'dossiers.not_found_title' => 'Dossier introuvable',
            'dossiers.not_found_text' => 'Le dossier demandé n’existe pas ou n’est plus disponible.',
            'dossiers.back_list' => 'Retour aux dossiers',
            'dossiers.eyebrow' => 'Dossier citoyen',
            'dossiers.for' => 'Pour',
            'dossiers.learning_objectives' => 'Objectifs d’apprentissage',
            'dossiers.pedagogical_use' => 'Comment utiliser ce dossier',
            'dossiers.activity_kit' => 'Matériel recommandé',
            'dossiers.evaluation' => 'Vérifier la compréhension',
            'dossiers.chapter_nav_aria' => 'Chapitres du dossier',
            'dossiers.pedagogical_sequence' => 'Déroulé pédagogique',
            'dossiers.workshop_eyebrow' => 'Activité guidée',
            'dossiers.debrief' => 'Débriefing',
            'dossiers.key_points' => 'À retenir',
            'dossiers.citizen_actions' => 'Pistes d’action',
            'dossiers.discussion_questions' => 'Questions de discussion',
            'dossiers.teacher_notes' => 'Repères pour l’animation',
            'dossiers.vocabulary' => 'Termes liés au dossier',
            'dossiers.references' => 'Sources utiles',
            'glossary.title' => 'Glossaire',
            'glossary.intro' => 'Un répertoire de {count} termes pour comprendre les filières agricoles, les pratiques de terrain, les politiques publiques, l’alimentation territoriale et les transitions agroécologiques.',
            'glossary.detail_link' => 'Voir la fiche détaillée',
            'glossary.back' => 'Retour au glossaire',
            'glossary.back_detail' => 'Retour à la fiche détaillée',
            'glossary.default_term' => 'Terme',
            'glossary.extended_definition' => 'Définition étendue',
            'glossary.why' => 'À quoi cela sert ?',
            'glossary.context' => 'Contexte en Wallonie',
            'glossary.classification_questions' => 'Questions de vérification',
            'glossary.related_terms' => 'Termes liés',
            'glossary.generic_theme' => 'Repère agricole',
            'faq.title' => 'Questions fréquentes',
            'faq.intro' => 'Réponses courtes pour mieux comprendre l’agriculture wallonne, ses contraintes et les choix possibles au quotidien.',
            'qa.default_title' => 'Questions et réponses courtes',
            'qa.resource_title' => 'Questions sur cette ressource',
            'qa.term_title' => 'Questions sur ce terme',
            'api.db_error' => 'Base de données MySQL indisponible',
            'api.unknown_section' => 'Section inconnue',
        ],
        'en' => [
            'nav.home' => 'Home',
            'nav.sectors' => 'Sectors',
            'nav.resources' => 'Resources',
            'nav.dossiers' => 'Dossiers',
            'nav.faq' => 'FAQ',
            'nav.glossary' => 'Glossary',
            'head.llms_short_title' => 'MyAgri summary for generative search systems',
            'head.llms_full_title' => 'MyAgri corpus for generative search systems',
            'head.api_title' => 'Structured MyAgri data',
            'head.image_alt' => 'Walloon agricultural landscape illustrating the MyAgri citizen portal',
            'head.brand_aria' => 'MyAgri home',
            'head.nav_aria' => 'Main navigation',
            'hero.updated_prefix' => 'Updated on',
            'hero.geo_label' => 'Wallonia, Belgium',
            'language.label' => 'Language',
            'language.aria' => 'Choose site language',
            'search.label' => 'Global search',
            'search.placeholder' => 'e.g. water, livestock, season',
            'footer.description' => 'MyAgri - public information portal on agriculture.',
            'footer.nav_aria' => 'Technical and editorial links',
            'footer.llms' => 'LLM summary',
            'footer.last_update' => 'Last update',
            'home.eyebrow' => 'Understand, choose, share',
            'home.title' => 'Where to start?',
            'home.intro' => 'MyAgri organises information about Walloon agriculture around clear uses: understand sectors, prepare practical steps and check terms before discussing them.',
            'home.card_sector_title' => 'Understand a sector',
            'home.card_sector_text' => 'Identify productions, practical constraints and relevant actions.',
            'home.card_sector_cta' => 'Explore sectors',
            'home.card_action_title' => 'Prepare an action',
            'home.card_action_text' => 'Use guides for visits, local purchases, workshops, orientation or projects.',
            'home.card_action_cta' => 'View resources',
            'home.card_term_title' => 'Clarify a term',
            'home.card_term_text' => 'Use definitions to read an article, prepare a lesson or compare approaches.',
            'home.card_term_cta' => 'Open glossary',
            'home.card_dossier_title' => 'Go deeper',
            'home.card_dossier_text' => 'Read illustrated dossiers with short chapters, reference points and verifiable sources.',
            'home.card_dossier_cta' => 'View dossiers',
            'home.basics_title' => 'Basics',
            'home.editorial_eyebrow' => 'Editorial method',
            'home.editorial_title' => 'Original content, verifiable sources',
            'home.editorial_intro' => 'MyAgri does not collect copied definitions. The portal rewrites, contextualises and indicates when information should be checked with a competent organisation.',
            'home.pillars_title' => 'The 4 pillars',
            'home.themes_title' => 'Cross-cutting themes',
            'home.provinces_title' => 'Read by province',
            'home.calendar_title' => 'Simplified farming calendar',
            'sectors.title' => 'Explore sectors',
            'sectors.intro' => 'Each sector links production, jobs, practical constraints, outlets and consumption choices. This page connects what is visible in the landscape with what reaches the plate.',
            'sectors.filter_placeholder' => 'e.g. milk, season, crops',
            'sectors.filter_aria' => 'Filter sectors',
            'sectors.issues' => 'Issues',
            'sectors.public_actions' => 'What can citizens do?',
            'resources.title' => 'Useful resources',
            'resources.intro' => 'Practical guides to move from intention to action: organise a visit, compare labels, buy better, discover jobs or prepare a support dossier.',
            'resources.for' => 'For',
            'resources.detail_link' => 'View detailed page',
            'resources.not_found_title' => 'Resource not found',
            'resources.not_found_text' => 'The requested resource does not exist or is no longer available.',
            'resources.back_list' => 'Back to the resource list',
            'resources.back' => 'Back to resources',
            'resources.target' => 'Target audience',
            'resources.intro_title' => 'General introduction',
            'resources.verification_title' => 'Check before acting',
            'resources.verification_text' => '{resource} provides practical guidance. Before making a binding decision, document sources, costs, local constraints and people consulted.',
            'resources.default_resource' => 'this resource',
            'resources.section_steps' => 'Recommended steps',
            'resources.section_checklist' => 'Practical checklist',
            'resources.section_eligible_projects' => 'Usually eligible projects',
            'resources.section_required_documents' => 'Often requested documents',
            'resources.section_timeline' => 'Indicative timeline',
            'resources.section_common_pitfalls' => 'Common mistakes to avoid',
            'resources.section_support_contacts' => 'Possible support contacts',
            'resources.section_learning_objectives' => 'Learning objectives',
            'resources.section_recommended_program' => 'Recommended programme',
            'resources.section_age_adaptations' => 'Adaptation by audience age',
            'resources.section_pedagogical_activities' => 'Examples of learning activities',
            'resources.section_risk_prevention' => 'Prevention and safety',
            'resources.section_budget_items' => 'Budget items to plan',
            'resources.section_evaluation_method' => 'Evaluation method',
            'dossiers.title' => 'Citizen dossiers',
            'dossiers.intro' => 'Thematic dossiers to understand links between farming practices, environment, local food and collective decisions.',
            'dossiers.cta' => 'Read dossier',
            'dossiers.not_found_title' => 'Dossier not found',
            'dossiers.not_found_text' => 'The requested dossier does not exist or is no longer available.',
            'dossiers.back_list' => 'Back to dossiers',
            'dossiers.eyebrow' => 'Citizen dossier',
            'dossiers.for' => 'For',
            'dossiers.learning_objectives' => 'Learning objectives',
            'dossiers.pedagogical_use' => 'How to use this dossier',
            'dossiers.activity_kit' => 'Recommended material',
            'dossiers.evaluation' => 'Check understanding',
            'dossiers.chapter_nav_aria' => 'Dossier chapters',
            'dossiers.pedagogical_sequence' => 'Learning sequence',
            'dossiers.workshop_eyebrow' => 'Guided activity',
            'dossiers.debrief' => 'Debrief',
            'dossiers.key_points' => 'Key points',
            'dossiers.citizen_actions' => 'Action ideas',
            'dossiers.discussion_questions' => 'Discussion questions',
            'dossiers.teacher_notes' => 'Facilitation notes',
            'dossiers.vocabulary' => 'Terms linked to the dossier',
            'dossiers.references' => 'Useful sources',
            'glossary.title' => 'Glossary',
            'glossary.intro' => 'A directory of {count} terms covering agricultural sectors, field practices, public policies, territorial food and agroecological transitions.',
            'glossary.detail_link' => 'View detailed page',
            'glossary.back' => 'Back to glossary',
            'glossary.back_detail' => 'Back to detailed page',
            'glossary.default_term' => 'Term',
            'glossary.extended_definition' => 'Extended definition',
            'glossary.why' => 'What is it used for?',
            'glossary.context' => 'Context in Wallonia',
            'glossary.classification_questions' => 'Verification questions',
            'glossary.related_terms' => 'Related terms',
            'glossary.generic_theme' => 'Agricultural reference point',
            'faq.title' => 'Frequently asked questions',
            'faq.intro' => 'Short answers to better understand Walloon agriculture, its constraints and everyday choices.',
            'qa.default_title' => 'Short questions and answers',
            'qa.resource_title' => 'Questions about this resource',
            'qa.term_title' => 'Questions about this term',
            'api.db_error' => 'MySQL database unavailable',
            'api.unknown_section' => 'Unknown section',
        ],
        'ge' => [
            'nav.home' => 'Start',
            'nav.sectors' => 'Sektoren',
            'nav.resources' => 'Ressourcen',
            'nav.dossiers' => 'Dossiers',
            'nav.faq' => 'FAQ',
            'nav.glossary' => 'Glossar',
            'head.llms_short_title' => 'MyAgri-Kurzfassung für generative Suchsysteme',
            'head.llms_full_title' => 'MyAgri-Korpus für generative Suchsysteme',
            'head.api_title' => 'Strukturierte MyAgri-Daten',
            'head.image_alt' => 'Wallonische Agrarlandschaft als Illustration des Bürgerportals MyAgri',
            'head.brand_aria' => 'MyAgri Startseite',
            'head.nav_aria' => 'Hauptnavigation',
            'hero.updated_prefix' => 'Aktualisiert am',
            'hero.geo_label' => 'Wallonie, Belgien',
            'language.label' => 'Sprache',
            'language.aria' => 'Sprache der Website wählen',
            'search.label' => 'Globale Suche',
            'search.placeholder' => 'z. B. Wasser, Tierhaltung, Saison',
            'footer.description' => 'MyAgri - öffentliches Informationsportal zur Landwirtschaft.',
            'footer.nav_aria' => 'Technische und redaktionelle Links',
            'footer.llms' => 'LLM-Zusammenfassung',
            'footer.last_update' => 'Letzte Aktualisierung',
        ],
        'nl' => [
            'nav.home' => 'Start',
            'nav.sectors' => 'Sectoren',
            'nav.resources' => 'Hulpmiddelen',
            'nav.dossiers' => 'Dossiers',
            'nav.faq' => 'FAQ',
            'nav.glossary' => 'Glossarium',
            'head.llms_short_title' => 'MyAgri-samenvatting voor generatieve zoeksystemen',
            'head.llms_full_title' => 'MyAgri-corpus voor generatieve zoeksystemen',
            'head.api_title' => 'Gestructureerde MyAgri-gegevens',
            'head.image_alt' => 'Waals landbouwlandschap als illustratie van het burgerportaal MyAgri',
            'head.brand_aria' => 'MyAgri startpagina',
            'head.nav_aria' => 'Hoofdnavigatie',
            'hero.updated_prefix' => 'Bijgewerkt op',
            'hero.geo_label' => 'Wallonië, België',
            'language.label' => 'Taal',
            'language.aria' => 'Kies de taal van de site',
            'search.label' => 'Globaal zoeken',
            'search.placeholder' => 'bv. water, veeteelt, seizoen',
            'footer.description' => 'MyAgri - openbaar informatieportaal over landbouw.',
            'footer.nav_aria' => 'Technische en redactionele links',
            'footer.llms' => 'LLM-samenvatting',
            'footer.last_update' => 'Laatste update',
        ],
    ];

    $fallback = $translations['en'];
    $selected = array_replace($fallback, $translations[$code] ?? []);

    if ($code === 'ge') {
        $selected = array_replace($translations['en'], $translations['ge'], [
            'resources.title' => 'Nützliche Ressourcen',
            'resources.for' => 'Für',
            'resources.detail_link' => 'Detailseite ansehen',
            'resources.not_found_title' => 'Ressource nicht gefunden',
            'resources.not_found_text' => 'Die angeforderte Ressource existiert nicht oder ist nicht mehr verfügbar.',
            'resources.back_list' => 'Zur Ressourcenliste zurück',
            'resources.back' => 'Zurück zu den Ressourcen',
            'resources.target' => 'Zielgruppe',
            'resources.intro_title' => 'Allgemeine Einführung',
            'resources.verification_title' => 'Vor dem Handeln prüfen',
            'resources.verification_text' => '{resource} liefert praktische Orientierung. Vor einer verbindlichen Entscheidung sollten Quellen, Kosten, lokale Zwänge und konsultierte Personen dokumentiert werden.',
            'resources.default_resource' => 'diese Ressource',
            'dossiers.title' => 'Bürgerdossiers',
            'dossiers.not_found_title' => 'Dossier nicht gefunden',
            'dossiers.not_found_text' => 'Das angeforderte Dossier existiert nicht oder ist nicht mehr verfügbar.',
            'dossiers.back_list' => 'Zurück zu den Dossiers',
            'dossiers.eyebrow' => 'Bürgerdossier',
            'dossiers.for' => 'Für',
            'glossary.title' => 'Glossar',
            'glossary.back' => 'Zurück zum Glossar',
            'glossary.default_term' => 'Begriff',
            'glossary.extended_definition' => 'Erweiterte Definition',
            'glossary.why' => 'Wozu dient das?',
            'glossary.context' => 'Kontext in der Wallonie',
            'glossary.classification_questions' => 'Fragen zur Einordnung',
            'glossary.related_terms' => 'Verwandte Begriffe',
            'glossary.generic_theme' => 'Landwirtschaftlicher Bezugspunkt',
            'qa.default_title' => 'Kurze Fragen und Antworten',
            'qa.resource_title' => 'Fragen zu dieser Ressource',
            'qa.term_title' => 'Fragen zu diesem Begriff',
            'api.db_error' => 'MySQL-Datenbank nicht verfügbar',
            'api.unknown_section' => 'Unbekannter Abschnitt',
        ]);
    }

    if ($code === 'nl') {
        $selected = array_replace($translations['en'], $translations['nl'], [
            'home.title' => 'Waar beginnen?',
            'resources.title' => 'Nuttige hulpmiddelen',
            'resources.for' => 'Voor',
            'resources.detail_link' => 'Detailpagina bekijken',
            'resources.not_found_title' => 'Hulpmiddel niet gevonden',
            'resources.not_found_text' => 'Het gevraagde hulpmiddel bestaat niet of is niet meer beschikbaar.',
            'resources.back_list' => 'Terug naar de lijst met hulpmiddelen',
            'resources.back' => 'Terug naar de hulpmiddelen',
            'resources.target' => 'Doelpubliek',
            'resources.intro_title' => 'Algemene inleiding',
            'resources.verification_title' => 'Controleren voor je handelt',
            'resources.verification_text' => '{resource} biedt praktische oriëntatie. Documenteer vóór een bindende beslissing de bronnen, kosten, lokale beperkingen en geraadpleegde personen.',
            'resources.default_resource' => 'dit hulpmiddel',
            'dossiers.title' => 'Burgerdossiers',
            'dossiers.cta' => 'Dossier lezen',
            'dossiers.not_found_title' => 'Dossier niet gevonden',
            'dossiers.not_found_text' => 'Het gevraagde dossier bestaat niet of is niet meer beschikbaar.',
            'dossiers.back_list' => 'Terug naar de dossiers',
            'dossiers.eyebrow' => 'Burgerdossier',
            'dossiers.for' => 'Voor',
            'glossary.title' => 'Glossarium',
            'glossary.detail_link' => 'Detailpagina bekijken',
            'glossary.back' => 'Terug naar het glossarium',
            'glossary.default_term' => 'Term',
            'glossary.extended_definition' => 'Uitgebreide definitie',
            'glossary.why' => 'Waarvoor dient dit?',
            'glossary.context' => 'Context in Wallonië',
            'glossary.classification_questions' => 'Verificatievragen',
            'glossary.related_terms' => 'Verwante termen',
            'glossary.generic_theme' => 'Landbouwkundig referentiepunt',
            'faq.title' => 'Veelgestelde vragen',
            'qa.default_title' => 'Korte vragen en antwoorden',
            'qa.resource_title' => 'Vragen over dit hulpmiddel',
            'qa.term_title' => 'Vragen over deze term',
            'api.db_error' => 'MySQL-database niet beschikbaar',
            'api.unknown_section' => 'Onbekende sectie',
        ]);
    }

    return $selected;
}

/**
 * @param array<string, scalar|null> $replace
 */
function t(string $key, array $replace = []): string
{
    $translations = portalUiTranslations(currentLanguage());
    $value = $translations[$key] ?? $key;

    foreach ($replace as $replaceKey => $replaceValue) {
        $value = str_replace('{' . $replaceKey . '}', (string) $replaceValue, $value);
    }

    return $value;
}

function localizedUrl(array $params = [], ?string $language = null): string
{
    $query = ['lang' => normalizePortalLanguage($language ?? currentLanguage())];
    foreach ($params as $key => $value) {
        if ($value === null || $value === '') {
            continue;
        }
        $query[(string) $key] = (string) $value;
    }

    return '/?' . http_build_query($query, '', '&', PHP_QUERY_RFC3986);
}

function languageSwitchUrl(string $language): string
{
    $params = ['page' => currentPage()];
    foreach (['resource', 'dossier', 'chapitre', 'term', 'q'] as $key) {
        if (isset($_GET[$key]) && is_string($_GET[$key]) && $_GET[$key] !== '') {
            $params[$key] = $_GET[$key];
        }
    }

    return localizedUrl($params, $language);
}
