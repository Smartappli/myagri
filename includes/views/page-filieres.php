<section aria-labelledby="filieres-title" class="shadow-soft">
    <h2 id="filieres-title">Explorer les filières</h2>
    <p class="section-intro">Chaque filière combine une production, des métiers, des contraintes de terrain, des débouchés et des choix de consommation. Cette page aide à relier ce que l’on voit dans le paysage avec ce que l’on retrouve dans l’assiette.</p>
    <input id="sector-filter" class="filter w-full rounded-xl border border-emerald-200 bg-white/95 px-3 py-2" type="search" placeholder="Ex: lait, saison, cultures" aria-label="Filtrer les filières" data-sector-filter>
    <div class="grid grid-3">
        <?php foreach ($sectors as $sector): ?>
            <?php
            $searchText = mb_strtolower($sector['label'] . ' ' . $sector['summary'] . ' ' . implode(' ', $sector['enjeux']) . ' ' . implode(' ', $sector['public_actions']));
            if ($search !== '' && !str_contains($searchText, mb_strtolower($search))) {
                continue;
            }
            ?>
            <article class="card" data-sector-card data-search-text="<?= e($searchText) ?>">
                <h3 class="sector-title"><span><?= e($sector['emoji']) ?></span> <?= e($sector['label']) ?></h3>
                <p><?= e($sector['summary']) ?></p>
                <h4>Enjeux</h4>
                <ul class="list-tight">
                    <?php foreach ($sector['enjeux'] as $item): ?>
                        <li><?= e($item) ?></li>
                    <?php endforeach; ?>
                </ul>
                <h4>Que peut faire le citoyen ?</h4>
                <ul class="list-tight">
                    <?php foreach ($sector['public_actions'] as $item): ?>
                        <li><?= e($item) ?></li>
                    <?php endforeach; ?>
                </ul>
            </article>
        <?php endforeach; ?>
    </div>
</section>
