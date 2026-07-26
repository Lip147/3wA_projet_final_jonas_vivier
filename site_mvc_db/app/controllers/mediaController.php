<?php
require_once __DIR__ . '/../models/mediaModel.php';

function media() {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($id <= 0) {
        http_response_code(404);
        exit;
    }

    $media = getMediaById($id);
    if (!$media) {
        http_response_code(404);
        exit;
    }

    $filePath = trim($media['file_path'] ?? '');
    if (preg_match('#^https?://#i', $filePath)) {
        header('Location: ' . $filePath, true, 302);
        exit;
    }

    $absolutePath = resolveMediaPath($filePath);
    if ($absolutePath === null || !is_file($absolutePath)) {
        http_response_code(404);
        exit;
    }

    header_remove('Content-Type');
    header('Content-Type: ' . ($media['mime_type'] ?: mime_content_type($absolutePath) ?: 'application/octet-stream'));
    header('Content-Length: ' . filesize($absolutePath));
    header('Cache-Control: public, max-age=86400');
    readfile($absolutePath);
    exit;
}
