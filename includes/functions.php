<?php

declare(strict_types=1);

/**
 * @param scalar|null $value
 */
function e(string|int|float|bool|null $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function currentPage(): string
{
    $page = $_GET['page'] ?? 'accueil';
    if (!is_string($page)) {
        return 'accueil';
    }

    $allowed = ['accueil', 'filieres', 'ressources', 'ressource'];
    return in_array($page, $allowed, true) ? $page : 'accueil';
}
