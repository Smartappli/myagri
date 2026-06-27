<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'wallesmart');
}

if (!is_array($selectedGlossaryTerm)) {
    return;
}

$term = isset($selectedGlossaryTerm['term']) && is_string($selectedGlossaryTerm['term']) ? $selectedGlossaryTerm['term'] : 'WALLeSmart';
$definition = isset($selectedGlossaryTerm['definition']) && is_string($selectedGlossaryTerm['definition'])
    ? $selectedGlossaryTerm['definition']
    : 'Wallonische digitale Plattform, die den sicheren Austausch landwirtschaftlicher Daten zwischen Werkzeugen, Betrieben und autorisierten Partnern erleichtert.';

$problems = [
    'Betriebsdaten liegen häufig verteilt in mehreren Programmen, Portalen, Sensoren und Organisationen.',
    'Landwirtinnen und Landwirte verlieren Zeit, wenn sie sich in mehrere Dienste einloggen oder dieselbe Information mehrfach eingeben müssen.',
    'Agraranwendungen sind nicht immer kompatibel: Formate, Referenzen und Zugriffsrechte unterscheiden sich.',
    'Der Wert landwirtschaftlicher Daten hängt auch von der Governance ab: Wer greift zu, zu welchem Zweck, mit welcher Zustimmung und welcher Nachverfolgbarkeit?',
];

$howItWorks = [
    'Interoperabilität: Daten sollen zwischen kompatiblen Werkzeugen zirkulieren, statt in getrennten Silos zu bleiben.',
    'Vereinfachter Zugang: WALLeSmart bietet einen gesicherten Zugangspunkt zu landwirtschaftlichen Anwendungen und Partnerdiensten.',
    'Dashboard: Ziel ist ein zusammenfassender Blick auf nützliche Betriebsinformationen, ohne spezialisierte Fachwerkzeuge zu ersetzen.',
    'Zustimmungsmanagement: Datenaustausch bleibt an die Zustimmung der Nutzerinnen und Nutzer sowie an klare Dienstregeln gebunden.',
];

$uses = [
    'Für Betriebe: Doppeleingaben reduzieren, Indikatoren leichter finden und Freigaben besser kontrollieren.',
    'Für Beratung und technische Organisationen: mit strukturierteren Daten arbeiten, sofern Zugang begründet und akzeptiert ist.',
    'Für Entwickler landwirtschaftlicher Werkzeuge: gemeinsame Infrastruktur und Referenzen nutzen, statt jede Verbindung neu aufzubauen.',
    'Für Lehrkräfte und Bürgerinnen und Bürger: verstehen, dass Agrardigitalisierung auch Vertrauen, Standards und Governance betrifft.',
];

$watchPoints = [
    'Zentralisierung nicht mit freiem Zugang verwechseln: Landwirtschaftliche Daten bleiben sensibel.',
    'Prüfen, welche Dienste zum Zeitpunkt der Nutzung tatsächlich integriert sind.',
    'Technisches Versprechen und messbaren Nutzen unterscheiden: Zeitgewinn, weniger Fehler, bessere Beratung oder Verwaltungsvereinfachung müssen beobachtbar sein.',
    'Digitale Abhängigkeit betrachten: Verbindung, Geräte, Begleitung und Verständnis der Zustimmung bestimmen die reale Nutzung.',
];

$questions = [
    'Welche Daten werden geteilt: Herde, Milch, Parzelle, Wetter, Beratung, Verwaltungsdokument oder wirtschaftlicher Indikator?',
    'Wer beantragt den Zugang, für welche Dauer und für welchen konkreten Dienst?',
    'Kann der Betrieb eine Zustimmung leicht ändern oder widerrufen?',
    'Vermeidet der Dienst wirklich eine Doppelerfassung oder fügt er eine zusätzliche digitale Ebene hinzu?',
    'Sind Datenquellen und Grenzen der angezeigten Indikatoren verständlich?',
];

$examples = [
    'Ein Dashboard kann Warnungen aus mehreren Werkzeugen bündeln und für Detailanalysen zum Ursprungsdienst zurückführen.',
    'Eine Herdenmanagement-App kann bekannte Partnerdaten nutzen, wenn Austausch technisch kompatibel und autorisiert ist.',
    'Wetter-, Parzellen- oder Gesundheitsdaten werden nützlicher, wenn sie mit einer konkreten Entscheidung verbunden sind: Weide, Eingriff, Milchkontrolle oder Beratung.',
];

$relatedSlugs = ['agriculture-de-precision', 'tracabilite', 'filiere', 'pac', 'systeme-alimentaire-territorial', 'resilience'];
$relatedTerms = [];
foreach ($relatedSlugs as $relatedSlug) {
    $related = glossaryTermBySlug($glossary, $relatedSlug);
    if (is_array($related) && isset($related['term']) && is_string($related['term'])) {
        $relatedTerms[] = $related;
    }
}

$references = [
    ['label' => 'WALLeSmart - offizielle Website', 'url' => 'https://www.wallesmart.be/'],
    ['label' => 'WALLeSmart - Dienste und Funktionsweise', 'url' => 'https://www.wallesmart.be/nos-services'],
    ['label' => 'WALLeSmart - Ursprung, Governance und Partner', 'url' => 'https://www.wallesmart.be/qui-sommes-nous'],
    ['label' => 'CRA-W - Projekt WALLeSmart', 'url' => 'https://www.cra.wallonie.be/fr/wallesmart'],
    ['label' => 'CRA-W - digitalen Alltag der Landwirte erleichtern', 'url' => 'https://www.cra.wallonie.be/fr/wallesmart-alleger-le-quotidien-numerique-des-agriculteurs'],
];
?>

<section aria-labelledby="glossary-term-title" class="shadow-soft glossary-detail">
    <p><a href="?page=glossaire">Zurück zum Glossar</a></p>
    <p class="eyebrow">Agrardigitalisierung, Daten und Governance</p>
    <h2 id="glossary-term-title"><?= e($term) ?></h2>

    <article class="card resource-summary">
        <p><strong>Kurzdefinition:</strong> <?= e($definition) ?></p>
        <p>WALLeSmart ist als digitale Koordinationsinfrastruktur zu verstehen. Es geht nicht nur darum, Daten online zu stellen, sondern landwirtschaftliche Werkzeuge kompatibel, nützlich und durch die betroffenen Nutzer kontrollierbar zu machen.</p>
    </article>

    <div class="resource-detail-grid">
        <article class="card">
            <h3>Ausgangsproblem</h3>
            <ul class="list-tight">
                <?php foreach ($problems as $line): ?>
                    <li><?= e($line) ?></li>
                <?php endforeach; ?>
            </ul>
        </article>

        <article class="card">
            <h3>Funktionsweise</h3>
            <ul class="list-tight">
                <?php foreach ($howItWorks as $line): ?>
                    <li><?= e($line) ?></li>
                <?php endforeach; ?>
            </ul>
        </article>
    </div>

    <article class="card">
        <h3>Wallonischer Kontext</h3>
        <p>Die Wallonie verfügt bereits über spezialisierte Agrarwerkzeuge für Herdenführung, Milchdaten, Wetter, Parzellen, Tiergesundheit, technische Beratung und Verwaltung. WALLeSmart soll die Fragmentierung dieses Ökosystems verringern, indem es den Austausch zwischen kompatiblen Diensten erleichtert.</p>
        <p>Die Plattform sollte nicht als Wundermittel verstanden werden. Ihr Nutzen hängt von realer Dienstintegration, Datenqualität, klaren Zustimmungen und guter Begleitung der Nutzerinnen und Nutzer ab.</p>
    </article>

    <div class="resource-detail-grid">
        <section class="card">
            <h3>Konkrete Nutzungen</h3>
            <ul class="list-tight">
                <?php foreach ($uses as $line): ?>
                    <li><?= e($line) ?></li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section class="card">
            <h3>Lesbare Beispiele</h3>
            <ul class="list-tight">
                <?php foreach ($examples as $line): ?>
                    <li><?= e($line) ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
    </div>

    <div class="resource-detail-grid">
        <section class="card">
            <h3>Prüfpunkte</h3>
            <ul class="list-tight">
                <?php foreach ($watchPoints as $line): ?>
                    <li><?= e($line) ?></li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section class="card">
            <h3>Fragen stellen</h3>
            <ul class="list-tight">
                <?php foreach ($questions as $line): ?>
                    <li><?= e($line) ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
    </div>

    <article class="card">
        <h3>Merken</h3>
        <p>WALLeSmart ist nicht nur ein Verzeichnis von Anwendungen. Es ist ein Versuch, wallonische Agrardigitalisierung interoperabler, sicherer und verständlicher zu machen. Die zentrale Frage lautet daher: Welche Daten zirkulieren, mit welcher Zustimmung und für welche nützliche Entscheidung auf dem Betrieb?</p>
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

    <article class="card references-card">
        <h3>Nützliche Quellen</h3>
        <p class="meta">Quellen, die für eine eigene, nicht kopierte Erklärung herangezogen wurden.</p>
        <ul class="reference-list">
            <?php foreach ($references as $reference): ?>
                <li><a href="<?= e($reference['url']) ?>" rel="noopener noreferrer" target="_blank"><?= e($reference['label']) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </article>
</section>
