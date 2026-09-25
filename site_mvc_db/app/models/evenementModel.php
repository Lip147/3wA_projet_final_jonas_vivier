<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/mediaModel.php';

function normalizeEvenementDate($date): ?string {
    $date = trim((string)$date);
    if ($date === '') {
        return null;
    }

    $parsedDate = DateTimeImmutable::createFromFormat('!Y-m-d', $date);
    $errors = DateTimeImmutable::getLastErrors();
    if (
        $parsedDate === false
        || ($errors !== false && ($errors['warning_count'] > 0 || $errors['error_count'] > 0))
        || $parsedDate->format('Y-m-d') !== $date
    ) {
        throw new InvalidArgumentException('La date de l\'événement doit être une date valide.');
    }

    return $date;
}

function formatEvenementDate($date): string {
    $date = trim((string)$date);
    if ($date === '') {
        return '';
    }

    $parsedDate = DateTimeImmutable::createFromFormat('!Y-m-d', $date);
    if ($parsedDate === false) {
        return $date;
    }

    $months = [
        1 => 'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
        'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre',
    ];

    return $parsedDate->format('j') . ' ' . $months[(int)$parsedDate->format('n')] . ' ' . $parsedDate->format('Y');
}

function evenementBaseSelect(string $where = ''): string {
    $mediaBaseUrl = app_url('media?id=');

    return
        "SELECT
            e.id_evenement AS id,
            e.id_evenement,
            e.author_id,
            e.title,
            e.description,
            e.event_date AS date,
            e.location AS meta,
            COALESCE((
                SELECT m.id_media
                FROM evenement_media em
                INNER JOIN medias m ON m.id_media = em.id_media
                WHERE em.id_evenement = e.id_evenement
                ORDER BY em.is_main DESC, em.sort_order ASC, em.id_media ASC
                LIMIT 1
            ), '') AS image_media_id,
            COALESCE((
                SELECT m.file_path
                FROM evenement_media em
                INNER JOIN medias m ON m.id_media = em.id_media
                WHERE em.id_evenement = e.id_evenement
                ORDER BY em.is_main DESC, em.sort_order ASC, em.id_media ASC
                LIMIT 1
            ), '') AS image_path,
            COALESCE((
                SELECT CONCAT('{$mediaBaseUrl}', m.id_media)
                FROM evenement_media em
                INNER JOIN medias m ON m.id_media = em.id_media
                WHERE em.id_evenement = e.id_evenement
                ORDER BY em.is_main DESC, em.sort_order ASC, em.id_media ASC
                LIMIT 1
            ), '') AS image
         FROM evenements e
         {$where}";
}

function getEvenements() {
    global $pdo;

    $stmt = $pdo->query(evenementBaseSelect() . " ORDER BY e.event_date DESC, e.id_evenement DESC");

    return $stmt->fetchAll();
}

function getEvenementsByYear(int $year): array {
    global $pdo;

    $startDate = sprintf('%04d-01-01', $year);
    $endDate = sprintf('%04d-01-01', $year + 1);
    $stmt = $pdo->prepare(
        evenementBaseSelect("WHERE e.event_date >= ? AND e.event_date < ?")
        . " ORDER BY e.event_date DESC, e.id_evenement DESC"
    );
    $stmt->execute([$startDate, $endDate]);

    return $stmt->fetchAll();
}

function getEvenementYears(): array {
    global $pdo;

    $stmt = $pdo->query(
        "SELECT DISTINCT YEAR(event_date) AS event_year
         FROM evenements
         WHERE event_date IS NOT NULL
         ORDER BY event_year ASC"
    );

    return array_map('intval', $stmt->fetchAll(PDO::FETCH_COLUMN));
}

function getEvenementsByMeta(string $meta) {
    global $pdo;

    $stmt = $pdo->prepare(evenementBaseSelect("WHERE e.location = ?") . " ORDER BY e.event_date DESC, e.id_evenement DESC");
    $stmt->execute([$meta]);

    return $stmt->fetchAll();
}

function getAllEvenementMetas(): array {
    global $pdo;

    $stmt = $pdo->query(
        "SELECT DISTINCT location AS meta
         FROM evenements
         WHERE location IS NOT NULL AND location <> ''
         ORDER BY location"
    );

    return $stmt->fetchAll();
}

function addEvenement(array $data) {
    global $pdo;

    $authorId = $data['author_id'] ?? null;
    $pdo->beginTransaction();

    try {
        $stmt = $pdo->prepare(
            "INSERT INTO evenements
                (author_id, title, description, event_date, location)
             VALUES
                (?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $authorId,
            $data['title'] ?? '',
            $data['description'] ?? '',
            normalizeEvenementDate($data['date'] ?? null),
            $data['location'] ?? ($data['meta'] ?? ''),
        ]);

        $id = (int)$pdo->lastInsertId();
        replacePrimaryMediaForEntity('evenement', $id, mediaDataFromInput($data, $authorId ? (int)$authorId : null));

        $pdo->commit();

        return $id;
    } catch (Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
}

function deleteEvenement(int $id) {
    global $pdo;

    $stmt = $pdo->prepare("DELETE FROM evenements WHERE id_evenement = ?");
    $stmt->execute([$id]);
}

function updateEvenement(int $id, array $data) {
    global $pdo;

    $authorId = $data['author_id'] ?? null;
    $pdo->beginTransaction();

    try {
        $stmt = $pdo->prepare(
            "UPDATE evenements
             SET title = ?, description = ?, event_date = ?, location = ?
             WHERE id_evenement = ?"
        );
        $stmt->execute([
            $data['title'] ?? '',
            $data['description'] ?? '',
            normalizeEvenementDate($data['date'] ?? null),
            $data['location'] ?? ($data['meta'] ?? ''),
            $id,
        ]);

        if (array_key_exists('image', $data)) {
            replacePrimaryMediaForEntity('evenement', $id, mediaDataFromInput($data, $authorId ? (int)$authorId : null));
        }

        $pdo->commit();
    } catch (Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
}
