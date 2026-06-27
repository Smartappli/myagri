<?php
if (!is_array($selectedGlossaryTerm)) {
    return;
}

$term = isset($selectedGlossaryTerm['term']) && is_string($selectedGlossaryTerm['term']) ? $selectedGlossaryTerm['term'] : 'Begriff';
$definition = isset($selectedGlossaryTerm['definition']) && is_string($selectedGlossaryTerm['definition']) ? $selectedGlossaryTerm['definition'] : '';
$termSlug = glossaryEntrySlug($selectedGlossaryTerm);

$profiles = [
    'sols' => [
        'theme' => 'Böden, Fruchtbarkeit und Schutz der Parzellen',
        'context' => 'In der Wallonie bestimmen Bodenqualität, Struktur und organische Substanz Erträge, Trockenheitsresistenz, Erosionsrisiko und den Bedarf an Betriebsmitteln.',
        'producer_use' => 'Für einen Betrieb hilft dieser Begriff, Fruchtfolgen, Zwischenfrüchte, organische Düngung, Bodenbearbeitung und Befahrbarkeit besser zu planen.',
        'citizen_use' => 'Für Bürgerinnen, Bürger und Lehrkräfte zeigt er, dass ein Feld nicht nur Produktionsfläche ist, sondern ein lebendiger, empfindlicher und langsam regenerierender Standort.',
        'indicators' => ['Bodenbedeckung oder Pflanzenreste zwischen zwei Kulturen.', 'Stabile Bodenstruktur nach starkem Regen.', 'Organische Substanz, Bodenleben und sichtbare Erosionsspuren.'],
        'pitfalls' => ['Eine einzelne Technik isoliert bewerten, statt das Anbausystem zu betrachten.', 'Kurzfristige und dauerhafte Fruchtbarkeit verwechseln.', 'Relief, Bodenart und Wetter als Einflussfaktoren unterschätzen.'],
        'example' => 'Ein Ackerbaubetrieb kann längere Fruchtfolgen, Zwischenfrüchte und organische Düngung kombinieren, um Parzellen im Winter zu schützen und die Tragfähigkeit im Frühjahr zu verbessern.',
        'related' => ['fertilite-du-sol', 'matiere-organique', 'humus', 'erosion-des-sols', 'couvert-vegetal', 'cultures-intermediaires', 'reserve-utile-du-sol', 'semis-direct'],
    ],
    'elevage' => [
        'theme' => 'Tierhaltung, Grünland und betriebliche Autonomie',
        'context' => 'Wallonische Grünlandsysteme beruhen häufig auf dem Gleichgewicht zwischen Weiden, Futter, Herden, Gebäuden, Arbeitszeit und wirtschaftlicher Verwertung von Milch oder Fleisch.',
        'producer_use' => 'Für Tierhaltungsbetriebe hilft der Begriff, Herdenführung, Weidemanagement, Futtervorräte, Futterkosten und Tierwohl zu steuern.',
        'citizen_use' => 'Für die Öffentlichkeit erklärt er die Rolle von Grünland, die Saisonalität der Weide und die Unterschiede zwischen Haltungsmodellen.',
        'indicators' => ['Anteil des Futters, der auf dem Betrieb erzeugt wird.', 'Zustand der Weiden, Grasverfügbarkeit und Weidedruck.', 'Futterkosten, Tiergesundheit und Produktionsstabilität.'],
        'pitfalls' => ['Betriebe vergleichen, ohne verfügbare Flächen zu berücksichtigen.', 'Wetter, Höhenlage und Grünlandqualität ausblenden.', 'Tierhaltung auf einen einzigen Umwelt- oder Wirtschaftsindikator reduzieren.'],
        'example' => 'Ein Milchviehbetrieb kann seine Autonomie durch Rotationsweide, Mahd, Futterlagerung und eine zur Fläche passende Tierzahl sichern.',
        'related' => ['prairie-permanente', 'prairie-temporaire', 'autonomie-fourragere', 'autonomie-proteique', 'paturage-tournant', 'densite-de-chargement', 'effluents-d-elevage', 'polyculture-elevage'],
    ],
    'filiere' => [
        'theme' => 'Wertschöpfungsketten, Wert und Konsumentscheidungen',
        'context' => 'Ein Agrarprodukt erhält seinen Wert durch Verarbeitung, Logistik, Vertrieb, Qualität, Herkunft und Vertrauen zwischen Produzenten, Handel und Käufern.',
        'producer_use' => 'Für Betriebe oder Kooperativen hilft der Begriff, Absatzwege zu wählen, Preise zu verhandeln, Verarbeitung zu organisieren und Angebote verständlich zu machen.',
        'citizen_use' => 'Für Konsumentinnen und Konsumenten erleichtert er den Vergleich von Herkunft, Labels, Kilopreis, Saisonalität, Verarbeitung und Erzeugervergütung.',
        'indicators' => ['Anzahl der Zwischenstufen und Preistransparenz.', 'Ort der Erzeugung und Ort der Verarbeitung.', 'Pflichtenheft, Label oder direkte Beziehung zum Betrieb.'],
        'pitfalls' => ['Lokale Erzeugung, lokale Verarbeitung und lokalen Verkauf gleichsetzen.', 'Ein Logo als ausreichende Qualitätsaussage betrachten.', 'Arbeits-, Lager-, Transport- und Verarbeitungskosten vergessen.'],
        'example' => 'Ein in der Wallonie angebauter Apfel kann roh auf dem Markt verkauft, am Hof zu Saft verarbeitet oder in eine längere Kette mit Verpackung und Vertrieb integriert werden.',
        'related' => ['filiere', 'circuit-court', 'vente-directe', 'valeur-ajoutee', 'tracabilite', 'cahier-des-charges', 'certification', 'prix-au-kilo'],
    ],
    'transition' => [
        'theme' => 'Agroökologischer Wandel und Resilienz',
        'context' => 'Landwirtschaftlicher Wandel ist kein Einheitsrezept. Er verbindet lokale Diagnose, schrittweise Versuche, Beratung, wirtschaftliche Tragfähigkeit und Klimaanpassung.',
        'producer_use' => 'Für Betriebe hilft der Begriff, realistische Veränderungen zu priorisieren, Wirkungen zu messen und ökologische Probleme nicht in wirtschaftliche oder soziale Probleme zu verschieben.',
        'citizen_use' => 'Für die Öffentlichkeit liefert er Orientierung zu Zielkonflikten zwischen Nahrungsmittelproduktion, Biodiversität, Einkommen, Energie, Wasser und gesellschaftlichen Erwartungen.',
        'indicators' => ['Geringere Abhängigkeit von einer knappen Ressource.', 'Stabiles Einkommen und bessere Arbeitsqualität.', 'Messbare Effekte auf Böden, Wasser, Biodiversität oder Emissionen.'],
        'pitfalls' => ['Wandel als sofortig oder überall gleich darstellen.', 'Produktion und Umwelt pauschal gegeneinanderstellen.', 'Lernzeit, Investitionen und wirtschaftliche Risiken unterschätzen.'],
        'example' => 'Ein Betrieb kann Zwischenfrüchte testen, Fruchtfolgen verlängern, einen begrenzten Direktverkauf aufbauen und Kosten verfolgen, bevor Änderungen ausgeweitet werden.',
        'related' => ['agroecologie', 'transition-agroecologique', 'agriculture-regeneratrice', 'agriculture-biologique', 'agriculture-integree', 'agriculture-de-precision', 'services-ecosystemiques', 'diversification'],
    ],
    'climat' => [
        'theme' => 'Klima, Wasser, Kohlenstoff und Energie',
        'context' => 'Trockenperioden, Starkregen, Energiekosten und Klimaziele beeinflussen landwirtschaftliche Entscheidungen in der Wallonie direkt.',
        'producer_use' => 'Für Betriebe hilft der Begriff, Risiken zu steuern, Ressourcen zu sichern, Emissionen oder Speicherung zu messen und passende Investitionen zu wählen.',
        'citizen_use' => 'Für die Öffentlichkeit macht er die Zusammenhänge zwischen landwirtschaftlichen Praktiken, Ernährung, Landschaft, Energie, Wasser und Klimaanpassung sichtbar.',
        'indicators' => ['Wasserverfügbarkeit und Stressanfälligkeit der Kulturen.', 'Vermiedene Emissionen oder gespeicherter Kohlenstoff.', 'Energieverbrauch, Autonomie und Verwertung von Nebenprodukten.'],
        'pitfalls' => ['Einen Klimaindikator isoliert betrachten.', 'Vorübergehende Speicherung mit dauerhafter Emissionsminderung verwechseln.', 'Extreme Wetterjahre als Einfluss auf Ergebnisse unterschätzen.'],
        'example' => 'Ein Betrieb kann Hecken, Zwischenfrüchte, bedarfsgerechte Bewässerung und Energieeffizienz kombinieren, um Trockenheit und steigende Kosten besser abzufedern.',
        'related' => ['bilan-carbone', 'sequestration-carbone', 'stress-hydrique', 'irrigation-raisonnee', 'empreinte-eau', 'gestion-de-l-eau-a-la-parcelle', 'methanisation', 'digestat'],
    ],
    'territoire' => [
        'theme' => 'Territorium, öffentliche Politik und Bodennutzung',
        'context' => 'Landwirtschaft hängt von kollektiven Entscheidungen ab: Zugang zu Boden, Raumplanung, öffentliche Hilfen, geteilte Daten, Infrastruktur und regionale Ernährungsentscheidungen.',
        'producer_use' => 'Für Betriebe und Projektträger hilft der Begriff, Regeln, Verwaltungszwänge, lokale Partnerschaften und Begleitmöglichkeiten früh einzuschätzen.',
        'citizen_use' => 'Für Gemeinden und Bürgerinnen und Bürger zeigt er, wie Raumplanung, Gemeinschaftsverpflegung und öffentliche Beschaffung Agrarsektoren beeinflussen.',
        'indicators' => ['Klarheit der Regeln und zuständigen Stellen.', 'Erhaltene Agrarfläche und Zugang für Projekte.', 'Qualität von Daten, Partnerschaften und territorialer Nachverfolgung.'],
        'pitfalls' => ['Politische Ziele mit bereits geltenden Pflichten verwechseln.', 'Unterschiede zwischen europäischer, regionaler und kommunaler Ebene ausblenden.', 'Territorium auf eine Karte reduzieren, ohne Akteure und Arbeit vor Ort zu betrachten.'],
        'example' => 'Eine Gemeinde kann Agrarflächen schützen, einen lokalen Markt unterstützen und Kantinen schrittweise saisonaler ausrichten, wenn sie mit Produzenten koordiniert arbeitet.',
        'related' => ['pac', 'conditionnalite', 'eco-regime', 'maec', 'natura-2000', 'zero-artificialisation-nette-zan', 'souverainete-alimentaire', 'systeme-alimentaire-territorial'],
    ],
];

$profileBySlug = [
    'rotation' => 'sols', 'assolement' => 'sols', 'amendement-organique' => 'sols', 'analyse-de-sol' => 'sols', 'battance' => 'sols', 'couvert-vegetal' => 'sols', 'couverts-permanents' => 'sols', 'cultures-associees' => 'sols', 'culture-derobee' => 'sols', 'erosion-des-sols' => 'sols', 'fertilite-du-sol' => 'sols', 'gestion-integree-des-ravageurs' => 'sols', 'humus' => 'sols', 'interculture' => 'sols', 'intrants' => 'sols', 'labour' => 'sols', 'matiere-organique' => 'sols', 'mycorhizes' => 'sols', 'ph-du-sol' => 'sols', 'plan-de-fumure' => 'sols', 'proteagineux' => 'sols', 'ruissellement' => 'sols', 'auxiliaires-de-culture' => 'sols', 'bande-enherbee' => 'sols', 'biodiversite-fonctionnelle' => 'sols', 'compost' => 'sols', 'cultures-intermediaires' => 'sols', 'drainage-agricole' => 'sols', 'effluents-d-elevage' => 'sols', 'nitrates' => 'sols', 'reserve-utile-du-sol' => 'sols', 'semis-direct' => 'sols', 'tassement-du-sol' => 'sols', 'techniques-culturales-simplifiees' => 'sols', 'travail-du-sol' => 'sols', 'zone-tampon' => 'sols',
    'prairie-permanente' => 'elevage', 'autonomie-fourragere' => 'elevage', 'polyculture-elevage' => 'elevage', 'densite-de-chargement' => 'elevage', 'elevage-extensif' => 'elevage', 'bien-etre-animal' => 'elevage', 'culture-fourragere' => 'elevage', 'ensilage' => 'elevage', 'fauche' => 'elevage', 'fourrage' => 'elevage', 'paturage-tournant' => 'elevage', 'sante-animale' => 'elevage', 'unite-gros-betail-ugb' => 'elevage', 'autonomie-proteique' => 'elevage', 'prairie-temporaire' => 'elevage',
    'circuit-court' => 'filiere', 'filiere' => 'filiere', 'valeur-ajoutee' => 'filiere', 'tracabilite' => 'filiere', 'aop-igp' => 'filiere', 'prix-remunerateur' => 'filiere', 'saisonnalite' => 'filiere', 'transformation-a-la-ferme' => 'filiere', 'pertes-post-recolte' => 'filiere', 'cahier-des-charges' => 'filiere', 'certification' => 'filiere', 'chaine-du-froid' => 'filiere', 'conservation-des-aliments' => 'filiere', 'cooperative-agricole' => 'filiere', 'groupe-d-achat' => 'filiere', 'logistique-alimentaire' => 'filiere', 'point-relais' => 'filiere', 'prix-au-kilo' => 'filiere', 'prix-de-revient' => 'filiere', 'qualite-differenciee' => 'filiere', 'relocalisation-alimentaire' => 'filiere', 'restauration-collective' => 'filiere', 'stockage-a-la-ferme' => 'filiere', 'systeme-alimentaire-territorial' => 'filiere', 'vente-directe' => 'filiere',
    'agroecologie' => 'transition', 'transition-agroecologique' => 'transition', 'resilience' => 'transition', 'agriculture-biologique' => 'transition', 'agriculture-de-precision' => 'transition', 'agroforesterie' => 'transition', 'bocage' => 'transition', 'diversification' => 'transition', 'economie-circulaire' => 'transition', 'agriculture-regeneratrice' => 'transition', 'agriculture-integree' => 'transition', 'agriculture-urbaine' => 'transition', 'apiculture' => 'transition', 'capteur-agricole' => 'transition', 'charge-de-travail' => 'transition', 'ferme-pedagogique' => 'transition', 'lutte-biologique' => 'transition', 'outil-d-aide-a-la-decision' => 'transition', 'paiement-pour-services-environnementaux' => 'transition', 'pollinisation' => 'transition', 'services-ecosystemiques' => 'transition', 'tableau-de-bord-agricole' => 'transition', 'variete-resistante' => 'transition', 'verger-haute-tige' => 'transition',
    'bilan-carbone' => 'climat', 'biomasse' => 'climat', 'decarbonation-agricole' => 'climat', 'energie-renouvelable-agricole' => 'climat', 'haie-vive' => 'climat', 'irrigation-raisonnee' => 'climat', 'methanisation' => 'climat', 'sequestration-carbone' => 'climat', 'stress-hydrique' => 'climat', 'digestat' => 'climat', 'empreinte-eau' => 'climat', 'bassin-versant' => 'climat', 'gestion-de-l-eau-a-la-parcelle' => 'climat', 'zone-humide' => 'climat',
    'pac' => 'territoire', 'souverainete-alimentaire' => 'territoire', 'wallesmart' => 'territoire', 'zero-artificialisation-nette-zan' => 'territoire', 'consentement-des-donnees' => 'territoire', 'conditionnalite' => 'territoire', 'eco-regime' => 'territoire', 'exploitation-familiale' => 'territoire', 'foncier-agricole' => 'territoire', 'interoperabilite' => 'territoire', 'maec' => 'territoire', 'marche-public-alimentaire' => 'territoire', 'natura-2000' => 'territoire', 'projet-alimentaire-territorial' => 'territoire',
];

$profileKey = $profileBySlug[$termSlug] ?? 'transition';
$profile = $profiles[$profileKey];

$introduction = $glossaryIntroduction ?? (
    $definition !== ''
        ? $term . ' ist ein Schlüsselbegriff, um Landwirtschaft in der Wallonie zu verstehen. ' . $definition . ' Die folgende Seite erklärt Nutzen, konkrete Wirkungen und Prüfpunkte für Unterricht, Bürgergespräche oder landwirtschaftliche Projekte.'
        : 'Dieser Begriff beschreibt einen konkreten Aspekt landwirtschaftlicher Praxis, Wertschöpfungsketten oder Alltagssteuerung auf Betrieben.'
);

$whatToSee = $glossaryWhatToSee ?? $profile['indicators'];
$whyImportant = $glossaryWhyImportant ?? [
    'Technische Entscheidungen auf einem Betrieb oder in einer Wertschöpfungskette besser verstehen.',
    'Agrarbegriffe mit beobachtbaren Wirkungen auf Einkommen, Böden, Wasser, Biodiversität oder lokale Organisation verbinden.',
    'Abkürzungen in öffentlichen Debatten vermeiden und verfügbare Nachweise einordnen.',
];
$actions = $glossaryActions ?? [
    'Prüfen, wo der Begriff auftaucht: Fachunterlage, Etikett, Gemeindeprojekt, Hofbesuch oder öffentliche Debatte.',
    'Nachfragen, welcher Indikator die Aussage konkret überprüfbar macht.',
    'Mehrere lokale Situationen vergleichen, bevor eine Schlussfolgerung verallgemeinert wird.',
];

$relatedTerms = [];
if (isset($profile['related']) && is_array($profile['related'])) {
    foreach ($profile['related'] as $relatedSlug) {
        if (!is_string($relatedSlug) || $relatedSlug === $termSlug) {
            continue;
        }

        $related = glossaryTermBySlug($glossary, $relatedSlug);
        if (is_array($related) && isset($related['term']) && is_string($related['term'])) {
            $relatedTerms[] = $related;
        }
    }
}

$verificationQuestions = [
    'Welches konkrete Problem hilft dieser Begriff zu verstehen oder zu lösen?',
    'Welche Akteure sind betroffen: Betrieb, Verarbeiter, Gemeinde, Konsument, Lehrkraft?',
    'Welche Indikatoren zeigen, dass die angekündigte Wirkung tatsächlich besteht?',
    'Welche Grenzen müssen erwähnt werden, damit die Erklärung nicht zu stark vereinfacht?',
];
?>

<section aria-labelledby="glossary-term-title" class="shadow-soft glossary-detail">
    <p><a href="?page=glossaire">Zurück zum Glossar</a></p>
    <p class="eyebrow"><?= e($profile['theme']) ?></p>
    <h2 id="glossary-term-title"><?= e($term) ?></h2>

    <article class="card resource-summary">
        <p><?= e($introduction) ?></p>
    </article>

    <div class="resource-detail-grid">
        <article class="card">
            <h3>Erweiterte Definition</h3>
            <p><?= e($definition) ?></p>
            <p>In der Praxis muss dieser Begriff immer in einen konkreten Kontext gesetzt werden: Betriebstyp, Boden, lokales Klima, Absatzwege, geltende Regeln und verfolgte Ziele. Erst dieser Kontext macht aus einer kurzen Definition nützliches Verständnis.</p>
        </article>

        <article class="card">
            <h3>Wozu dient das?</h3>
            <ul class="list-tight">
                <?php foreach ($whyImportant as $line): ?>
                    <li><?= e($line) ?></li>
                <?php endforeach; ?>
            </ul>
        </article>
    </div>

    <article class="card">
        <h3>Kontext in der Wallonie</h3>
        <p><?= e($profile['context']) ?></p>
        <p>Diese territoriale Einordnung ist wichtig, weil derselbe Begriff je nach Provinz, Boden, vorhandenen Sektoren, Verarbeitungsinfrastruktur und lokalen Absatzmöglichkeiten unterschiedliche Wirkungen haben kann.</p>
    </article>

    <div class="resource-detail-grid">
        <section class="card">
            <h3>Worauf achten?</h3>
            <ul class="list-tight">
                <?php foreach ($whatToSee as $line): ?>
                    <li><?= e($line) ?></li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section class="card">
            <h3>Nutzung auf dem Betrieb</h3>
            <p><?= e($profile['producer_use']) ?></p>
        </section>

        <section class="card">
            <h3>Nutzung für Bürgerinnen und Bürger</h3>
            <p><?= e($profile['citizen_use']) ?></p>
        </section>
    </div>

    <div class="resource-detail-grid">
        <section class="card">
            <h3>Konkretes Beispiel</h3>
            <p><?= e($profile['example']) ?></p>
        </section>

        <section class="card">
            <h3>Prüfpunkte</h3>
            <ul class="list-tight">
                <?php foreach ($profile['pitfalls'] as $line): ?>
                    <li><?= e($line) ?></li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section class="card">
            <h3>Anwenden</h3>
            <ul class="list-tight">
                <?php foreach ($actions as $line): ?>
                    <li><?= e($line) ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
    </div>

    <article class="card">
        <h3>Fragen zur Einordnung</h3>
        <ul class="list-tight">
            <?php foreach ($verificationQuestions as $question): ?>
                <li><?= e($question) ?></li>
            <?php endforeach; ?>
        </ul>
    </article>

    <?php if ($relatedTerms !== []): ?>
        <article class="card">
            <h3>Verwandte Begriffe</h3>
            <ul class="related-terms">
                <?php foreach ($relatedTerms as $relatedTerm): ?>
                    <?php
                    $relatedName = isset($relatedTerm['term']) && is_string($relatedTerm['term']) ? $relatedTerm['term'] : '';
                    if ($relatedName === '') {
                        continue;
                    }
                    ?>
                    <li><a href="?page=glossaire&amp;term=<?= e(glossaryEntrySlug($relatedTerm)) ?>"><?= e($relatedName) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </article>
    <?php endif; ?>
</section>
