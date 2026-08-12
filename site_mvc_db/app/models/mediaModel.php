<?php
require_once __DIR__ . '/../../config/database.php';

function mediaEntityConfig(string $entityType): array {
    $configs = [
        'peinture' => ['table' => 'peinture_media', 'id_column' => 'id_peinture'],
        'couture' => ['table' => 'couture_media', 'id_column' => 'id_couture'],
        'evenement' => ['table' => 'evenement_media', 'id_column' => 'id_evenement'],
    ];

    if (!isset($configs[$entityType])) {
        throw new InvalidArgumentException('Type de media inconnu.');
    }

    return $configs[$entityType];
}

function mediaDataFromInput(array $data, ?int $authorId = null): array {
    $filePath = trim($data['image'] ?? '');
    $pathForName = parse_url($filePath, PHP_URL_PATH) ?: $filePath;

    return [
        'file_path' => $filePath,
        'original_name' => $data['media_original_name'] ?? basename($pathForName),
        'extension' => $data['media_extension'] ?? strtolower(pathinfo($pathForName, PATHINFO_EXTENSION)),
        'mime_type' => $data['media_mime_type'] ?? null,
        'size_bytes' => $data['media_size_bytes'] ?? null,
        'width' => $data['media_width'] ?? null,
        'height' => $data['media_height'] ?? null,
        'alt_text' => $data['media_alt_text'] ?? ($data['title'] ?? null),
        'uploaded_by' => $authorId,
    ];
}

function createMedia(array $data): ?int {
    global $pdo;

    $filePath = trim($data['file_path'] ?? '');
    if ($filePath === '') {
        return null;
    }

    $stmt = $pdo->prepare(
        "INSERT INTO medias
            (file_path, original_name, extension, mime_type, size_bytes, width, height, alt_text, uploaded_by)
         VALUES
            (?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->execute([
        $filePath,
        $data['original_name'] ?? null,
        $data['extension'] ?? null,
        $data['mime_type'] ?? null,
        $data['size_bytes'] ?? null,
        $data['width'] ?? null,
        $data['height'] ?? null,
        $data['alt_text'] ?? null,
        $data['uploaded_by'] ?? null,
    ]);

    return (int)$pdo->lastInsertId();
}

function getMediaById(int $id): ?array {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM medias WHERE id_media = ? LIMIT 1");
    $stmt->execute([$id]);
    $media = $stmt->fetch();

    return $media ?: null;
}

function mediaPublicUrl(?int $mediaId): string {
    if (!$mediaId) {
        return '';
    }

    return app_url('media?id=' . $mediaId);
}

function resolveMediaPath(string $filePath): ?string {
    $normalizedPath = str_replace('\\', '/', trim($filePath));
    $baseStorage = realpath(__DIR__ . '/../../storage');
    $basePublicUploads = realpath(__DIR__ . '/../../public/images/uploads');

    if ($normalizedPath === '') {
        return null;
    }

    $candidates = [];

    if (strpos($normalizedPath, 'uploads/') === 0 && $baseStorage !== false) {
        $candidates[] = $baseStorage . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $normalizedPath);
    }

    if (strpos($normalizedPath, '/site_mvc_db/public/images/uploads/') === 0 && $basePublicUploads !== false) {
        $candidates[] = $basePublicUploads . DIRECTORY_SEPARATOR . basename($normalizedPath);
    }

    if (strpos($normalizedPath, '/public/images/uploads/') === 0 && $basePublicUploads !== false) {
        $candidates[] = $basePublicUploads . DIRECTORY_SEPARATOR . basename($normalizedPath);
    }

    foreach ($candidates as $candidate) {
        $realCandidate = realpath($candidate);
        if ($realCandidate === false) {
            continue;
        }

        $allowedBases = array_filter([$baseStorage, $basePublicUploads]);
        foreach ($allowedBases as $allowedBase) {
            if (strpos($realCandidate, $allowedBase . DIRECTORY_SEPARATOR) === 0) {
                return $realCandidate;
            }
        }
    }

    return null;
}

function getPrimaryMediaPathForEntity(string $entityType, int $entityId): string {
    global $pdo;

    $config = mediaEntityConfig($entityType);
    $stmt = $pdo->prepare(
        "SELECT m.file_path
         FROM {$config['table']} link
         INNER JOIN medias m ON m.id_media = link.id_media
         WHERE link.{$config['id_column']} = ?
         ORDER BY link.is_main DESC, link.sort_order ASC, link.id_media ASC
         LIMIT 1"
    );
    $stmt->execute([$entityId]);

    return $stmt->fetchColumn() ?: '';
}

function replacePrimaryMediaForEntity(string $entityType, int $entityId, array $mediaData): void {
    global $pdo;

    $config = mediaEntityConfig($entityType);
    $filePath = trim($mediaData['file_path'] ?? '');
    $currentPath = getPrimaryMediaPathForEntity($entityType, $entityId);

    if ($filePath !== '' && $filePath === $currentPath) {
        return;
    }

    $stmt = $pdo->prepare("DELETE FROM {$config['table']} WHERE {$config['id_column']} = ?");
    $stmt->execute([$entityId]);

    if ($filePath === '') {
        return;
    }

    $mediaId = createMedia($mediaData);
    if ($mediaId === null) {
        return;
    }

    $stmt = $pdo->prepare(
        "INSERT INTO {$config['table']} ({$config['id_column']}, id_media, is_main, sort_order)
         VALUES (?, ?, 1, 0)"
    );
    $stmt->execute([$entityId, $mediaId]);
}
