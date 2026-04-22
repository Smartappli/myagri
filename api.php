<?php

declare(strict_types=1);

require __DIR__ . '/includes/data.php';

$data = getPortalData();
$section = $_GET['section'] ?? null;

header('Content-Type: application/json; charset=utf-8');

if (!is_string($section) || $section === '') {
    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    exit;
}

if (!array_key_exists($section, $data)) {
    http_response_code(404);
    echo json_encode([
        'error' => 'Section inconnue',
        'available_sections' => array_keys($data),
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    exit;
}

echo json_encode([
    'section' => $section,
    'data' => $data[$section],
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
