<section aria-labelledby="filieres-title" class="shadow-soft">
    <h2 id="filieres-title"><?= e(t('sectors.title')) ?></h2>
    <p class="section-intro"><?= e(t('sectors.intro')) ?></p>
    <input id="sector-filter" class="filter w-full rounded-xl border border-emerald-200 bg-white/95 px-3 py-2" type="search" placeholder="<?= e(t('sectors.filter_placeholder')) ?>" aria-label="<?= e(t('sectors.filter_aria')) ?>" data-sector-filter>
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
                <h4><?= e(t('sectors.issues')) ?></h4>
                <ul class="list-tight">
                    <?php foreach ($sector['enjeux'] as $item): ?>
                        <li><?= e($item) ?></li>
                    <?php endforeach; ?>
                </ul>
                <h4><?= e(t('sectors.public_actions')) ?></h4>
                <ul class="list-tight">
                    <?php foreach ($sector['public_actions'] as $item): ?>
                        <li><?= e($item) ?></li>
                    <?php endforeach; ?>
                </ul>
            </article>
        <?php endforeach; ?>
    </div>
</section>
