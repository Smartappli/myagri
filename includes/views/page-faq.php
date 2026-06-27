<section aria-labelledby="faq-title" class="shadow-soft">
    <h2 id="faq-title">Bürger-FAQ</h2>
    <div class="grid">
        <?php foreach ($faq as $index => $item): ?>
            <?php
            $answerText = mb_strtolower($item['q'] . ' ' . $item['a']);
            if ($search !== '' && !str_contains($answerText, mb_strtolower($search))) {
                continue;
            }
            $answerId = 'faq-' . $index;
            ?>
            <article class="faq-item shadow-sm ring-1 ring-emerald-100">
                <button class="faq-button" type="button" aria-expanded="false" aria-controls="<?= e($answerId) ?>" data-faq-button>
                    <?= e($item['q']) ?>
                </button>
                <p id="<?= e($answerId) ?>" hidden><?= e($item['a']) ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>
