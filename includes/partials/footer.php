</main>
<footer>
    <div class="container">
        <p><?= e(t('footer.description')) ?></p>
        <nav aria-label="<?= e(t('footer.nav_aria')) ?>">
            <ul class="footer-links">
                <li><a href="<?= e(localizedUrl(['page' => 'ressources'])) ?>"><?= e(t('nav.resources')) ?></a></li>
                <li><a href="<?= e(localizedUrl(['page' => 'dossiers'])) ?>"><?= e(t('nav.dossiers')) ?></a></li>
                <li><a href="<?= e(localizedUrl(['page' => 'glossaire'])) ?>"><?= e(t('nav.glossary')) ?></a></li>
                <li><a href="api.php?lang=<?= e(currentLanguage()) ?>">API JSON</a></li>
                <li><a href="llms.txt"><?= e(t('footer.llms')) ?></a></li>
                <li><a href="sitemap.xml">Sitemap</a></li>
            </ul>
        </nav>
        <p class="meta"><?= e(t('footer.last_update')) ?>: <?= e($site['updated_at']) ?></p>
    </div>
</footer>


<script src="assets/js/main.js" defer></script>
</body>
</html>
