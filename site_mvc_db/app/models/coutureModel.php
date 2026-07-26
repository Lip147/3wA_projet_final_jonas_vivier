<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/categoryModel.php';
require_once __DIR__ . '/mediaModel.php';

function coutureBaseSelect(string $where = ''): string {
    return
        "SELECT
            c.id_couture AS id,
            c.id_couture,
            c.author_id,
            c.title,
            c.description,
            c.creation_date AS date,
            c.dimensions_or_size,
            c.material,
            COALESCE((
                SELECT m.id_media
                FROM couture_media cm
                INNER JOIN medias m ON m.id_media = cm.id_media
                WHERE cm.id_couture = c.id_couture
                ORDER BY cm.is_main DESC, cm.sort_order ASC, cm.id_media ASC
                LIMIT 1
            ), '') AS image_media_id,
            COALESCE((
                SELECT m.file_path
                FROM couture_media cm
                INNER JOIN medias m ON m.id_media = cm.id_media
                WHERE cm.id_couture = c.id_couture
                ORDER BY cm.is_main DESC, cm.sort_order ASC, cm.id_media ASC
                LIMIT 1
            ), '') AS image_path,
            COALESCE((
                SELECT CONCAT('/site_mvc_db/public/media?id=', m.id_media)
                FROM couture_media cm
                INNER JOIN medias m ON m.id_media = cm.id_media
                WHERE cm.id_couture = c.id_couture
                ORDER BY cm.is_main DESC, cm.sort_order ASC, cm.id_media ASC
                LIMIT 1
            ), '') AS image,
            COALESCE((
                SELECT GROUP_CONCAT(cat.name ORDER BY cat.name SEPARATOR ', ')
                FROM couture_categorie cc
                INNER JOIN categories cat ON cat.id_categorie = cc.id_categorie
                WHERE cc.id_couture = c.id_couture
            ), '') AS meta
         FROM coutures c
         {$where}";
}

function getCoutures() {
    global $pdo;

    $stmt = $pdo->query(coutureBaseSelect() . " ORDER BY c.id_couture DESC");

    return $stmt->fetchAll();
}

function getCouturesByCategory(string $category) {
    global $pdo;

    $stmt = $pdo->prepare(
        coutureBaseSelect(
            "WHERE EXISTS (
                SELECT 1
                FROM couture_categorie cc
                INNER JOIN categories cat ON cat.id_categorie = cc.id_categorie
                WHERE cc.id_couture = c.id_couture
                AND (cat.name = ? OR cat.slug = ?)
            )"
        ) . " ORDER BY c.id_couture DESC"
    );
    $stmt->execute([$category, slugifyCategoryName($category)]);

    return $stmt->fetchAll();
}

function getCouturesBySearch(string $search) {
    global $pdo;

    $stmt = $pdo->prepare(
        coutureBaseSelect(
            "WHERE c.title LIKE ?
             OR c.description LIKE ?"
        ) . " ORDER BY c.id_couture DESC"
    );
    $searchTerm = '%' . $search . '%';
    $stmt->execute([$searchTerm, $searchTerm]);

    return $stmt->fetchAll();
}

function getAllCoutureCategories() {
    return getCategoriesForEntityType('couture');
}

function addCouture(array $data) {
    global $pdo;

    $authorId = $data['author_id'] ?? null;
    $pdo->beginTransaction();

    try {
        $stmt = $pdo->prepare(
            "INSERT INTO coutures
                (author_id, title, description, creation_date, dimensions_or_size, material)
             VALUES
                (?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $authorId,
            $data['title'] ?? '',
            $data['description'] ?? '',
            $data['date'] ?? '',
            $data['dimensions_or_size'] ?? '',
            $data['material'] ?? '',
        ]);

        $id = (int)$pdo->lastInsertId();
        syncCategoriesForEntity('couture', $id, $data['meta'] ?? '');
        replacePrimaryMediaForEntity('couture', $id, mediaDataFromInput($data, $authorId ? (int)$authorId : null));

        $pdo->commit();

        return $id;
    } catch (Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
}

function deleteCouture(int $id) {
    global $pdo;

    $stmt = $pdo->prepare("DELETE FROM coutures WHERE id_couture = ?");
    $stmt->execute([$id]);
}

function updateCouture(int $id, array $data) {
    global $pdo;

    $authorId = $data['author_id'] ?? null;
    $pdo->beginTransaction();

    try {
        $stmt = $pdo->prepare(
            "UPDATE coutures
             SET title = ?, description = ?, creation_date = ?, dimensions_or_size = ?, material = ?
             WHERE id_couture = ?"
        );
        $stmt->execute([
            $data['title'] ?? '',
            $data['description'] ?? '',
            $data['date'] ?? '',
            $data['dimensions_or_size'] ?? '',
            $data['material'] ?? '',
            $id,
        ]);

        syncCategoriesForEntity('couture', $id, $data['meta'] ?? '');

        if (array_key_exists('image', $data)) {
            replacePrimaryMediaForEntity('couture', $id, mediaDataFromInput($data, $authorId ? (int)$authorId : null));
        }

        $pdo->commit();
    } catch (Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
}
