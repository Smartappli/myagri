<?php
if (!is_array($selectedResource)) {
    ?>
    <section aria-labelledby="resource-not-found-title">
        <h2 id="resource-not-found-title">Ressource introuvable</h2>
        <p>La ressource demandee n'existe pas ou n'est plus disponible.</p>
        <p><a href="?page=ressources">Retour a la liste des ressources</a></p>
    </section>
    <?php
    return;
}

$resourceId = isset($selectedResource['id']) && is_string($selectedResource['id']) ? trim($selectedResource['id']) : '';
$resourceTemplate = resourceTemplatePath($resourceId);
if ($resourceTemplate !== null) {
    require $resourceTemplate;
    return;
}
?>

<section aria-labelledby="resource-title" class="shadow-soft">
    <p><a href="?page=ressources">← Retour aux ressources</a></p>
    <h2 id="resource-title"><?= e($selectedResource['title']) ?></h2>
    <p class="section-intro"><?= e($selectedResource['description']) ?></p>

    <article class="card resource-summary">
        <?php
        if (isset($selectedResource['overview']) && is_string($selectedResource['overview']) && $selectedResource['overview'] !== '') {
            echo '<p>' . e($selectedResource['overview']) . '</p>';
        }
        if (isset($selectedResource['for']) && is_string($selectedResource['for']) && $selectedResource['for'] !== '') {
            echo '<p><strong>Public concerne :</strong> ' . e($selectedResource['for']) . '</p>';
        }
        ?>
    </article>

    <?php
    $continuousContent = $selectedResource['continuous_content'] ?? null;
    if (is_string($continuousContent) && trim($continuousContent) !== ''): ?>
        <article class="card">
            <h3>Presentation generale</h3>
            <?php
            foreach (splitTextIntoParagraphs($continuousContent) as $continuousParagraph) {
                echo '<p>' . e($continuousParagraph) . '</p>';
            }
            ?>
        </article>
    <?php endif; ?>

    <?php if (is_array($selectedResource['content_blocks'] ?? null) && $selectedResource['content_blocks'] !== []): ?>
        <article class="resource-detail-grid">
            <?php foreach ($selectedResource['content_blocks'] as $contentBlock): ?>
                <?php
                if (!is_array($contentBlock)) {
                    continue;
                }
                $blockTitle = isset($contentBlock['title']) && is_string($contentBlock['title']) ? $contentBlock['title'] : '';
                $blockText = isset($contentBlock['text']) && is_string($contentBlock['text']) ? trim($contentBlock['text']) : '';
                $blockItems = isset($contentBlock['items']) && is_array($contentBlock['items']) ? $contentBlock['items'] : [];
                if ($blockTitle === '' && $blockText === '' && $blockItems === []) {
                    continue;
                }
                ?>
                <section class="card resource-detail-card">
                    <?php if ($blockTitle !== ''): ?>
                        <h3><?= e($blockTitle) ?></h3>
                    <?php endif; ?>
                    <?php if ($blockText !== ''): ?>
                        <?php foreach (splitTextIntoParagraphs($blockText) as $blockParagraph): ?>
                            <p><?= e($blockParagraph) ?></p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if ($blockItems !== []): ?>
                        <ul class="list-tight">
                            <?php foreach ($blockItems as $blockItem): ?>
                                <?php if (is_string($blockItem) && trim($blockItem) !== ''): ?>
                                    <li><?= e($blockItem) ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </section>
            <?php endforeach; ?>
        </article>
    <?php endif; ?>

    <?php
    $resourceSections = [
        'steps' => 'Etapes recommandees',
        'checklist' => 'Checklist pratique',
        'eligible_projects' => 'Projets generalement eligibles',
        'required_documents' => 'Documents souvent demandes',
        'timeline' => 'Chronologie indicative',
        'common_pitfalls' => 'Erreurs frequentes a eviter',
        'support_contacts' => 'Acteurs pouvant accompagner',
        'learning_objectives' => 'Objectifs pedagogiques',
        'recommended_program' => 'Deroule recommande',
        'age_adaptations' => "Adaptation selon l'age du public",
        'pedagogical_activities' => "Exemples d'activites pedagogiques",
        'risk_prevention' => 'Prevention et securite',
        'budget_items' => 'Postes de budget a prevoir',
        'evaluation_method' => "Methode d'evaluation",
    ];

    $resourceSectionCards = [];
    foreach ($resourceSections as $sectionKey => $sectionTitle) {
        $sectionItems = $selectedResource[$sectionKey] ?? null;
        if (!is_array($sectionItems) || $sectionItems === []) {
            continue;
        }
        $resourceSectionCards[] = [
            'title' => $sectionTitle,
            'items' => $sectionItems,
        ];
    }
    ?>

    <?php if ($resourceSectionCards !== []): ?>
        <article class="resource-detail-grid">
            <?php foreach ($resourceSectionCards as $resourceSectionCard): ?>
                <section class="card resource-detail-card">
                    <h3><?= e($resourceSectionCard['title']) ?></h3>
                    <ul class="list-tight">
                        <?php foreach ($resourceSectionCard['items'] as $resourceSectionItem): ?>
                            <?php if (is_string($resourceSectionItem) && $resourceSectionItem !== ''): ?>
                                <li><?= e($resourceSectionItem) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endforeach; ?>
        </article>
    <?php endif; ?>
</section>
