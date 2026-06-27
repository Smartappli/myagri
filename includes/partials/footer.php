</main>
<footer>
    <div class="container">
        <p>MyAgri - öffentliches Informationsportal zur Landwirtschaft.</p>
        <nav aria-label="Technische und redaktionelle Links">
            <ul class="footer-links">
                <li><a href="?page=ressources">Ressources</a></li>
                <li><a href="?page=dossiers">Dossiers</a></li>
                <li><a href="?page=glossaire">Glossar</a></li>
                <li><a href="api.php">API JSON</a></li>
                <li><a href="llms.txt">LLM-Zusammenfassung</a></li>
                <li><a href="sitemap.xml">Sitemap</a></li>
            </ul>
        </nav>
        <p class="meta">Letzte Aktualisierung: <?= e($site['updated_at']) ?></p>
    </div>
</footer>


<script src="assets/js/main.js" defer></script>
</body>
</html>
