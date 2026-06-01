</main>
<footer>
    <div class="container">
        <p>MyAgri — portail d'information agricole grand public.</p>
        <nav aria-label="Liens techniques et éditoriaux">
            <ul class="footer-links">
                <li><a href="?page=ressources">Ressources</a></li>
                <li><a href="?page=dossiers">Dossiers</a></li>
                <li><a href="?page=glossaire">Glossaire</a></li>
                <li><a href="api.php">API JSON</a></li>
                <li><a href="llms.txt">Résumé LLM</a></li>
                <li><a href="sitemap.xml">Sitemap</a></li>
            </ul>
        </nav>
        <p class="meta">Dernière mise à jour : <?= e($site['updated_at']) ?></p>
    </div>
</footer>


<script src="assets/js/main.js" defer></script>
</body>
</html>
