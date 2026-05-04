<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/categoryModel.php';
require_once __DIR__ . '/mediaModel.php';

function peintureBaseSelect(string $where = ''): string {
    return
        "SELECT
            p.id_peinture AS id,
            p.id_peinture,
            p.author_id,
            p.title,
            p.description,
            p.creation_date AS date,
            p.dimensions,
            p.dimensions AS dimension,
            p.technique,
            COALESCE((
                SELECT m.file_path
                FROM peinture_media pm
                INNER JOIN medias m ON m.id_media = pm.id_media
                WHERE pm.id_peinture = p.id_peinture
                ORDER BY pm.is_main DESC, pm.sort_order ASC, pm.id_media ASC
                LIMIT 1
            ), '') AS image,
            COALESCE((
                SELECT GROUP_CONCAT(c.name ORDER BY c.name SEPARATOR ', ')
                FROM peinture_categorie pc
                INNER JOIN categories c ON c.id_categorie = pc.id_categorie
                WHERE pc.id_peinture = p.id_peinture
            ), '') AS meta
         FROM peintures p
         {$where}";
}

function getPeintures() {
    global $pdo;

    $stmt = $pdo->query(peintureBaseSelect() . " ORDER BY p.id_peinture DESC");

    return $stmt->fetchAll();
}

function getPeinturesByCategory(string $category) {
    global $pdo;

    $stmt = $pdo->prepare(
        peintureBaseSelect(
            "WHERE EXISTS (
                SELECT 1
                FROM peinture_categorie pc
                INNER JOIN categories c ON c.id_categorie = pc.id_categorie
                WHERE pc.id_peinture = p.id_peinture
                AND (c.name = ? OR c.slug = ?)
            )"
        ) . " ORDER BY p.id_peinture DESC"
    );
    $stmt->execute([$category, slugifyCategoryName($category)]);

    return $stmt->fetchAll();
}

function getPeinturesBySearch(string $search) {
    global $pdo;

    $stmt = $pdo->prepare(
        peintureBaseSelect(
            "WHERE p.title LIKE ?
             OR p.description LIKE ?"
        ) . " ORDER BY p.id_peinture DESC"
    );
    $searchTerm = '%' . $search . '%';
    $stmt->execute([$searchTerm, $searchTerm]);

    return $stmt->fetchAll();
}

function getAllCategories() {
    return getCategoriesForEntityType('peinture');
}

function getPeintureById(int $id) {
    global $pdo;

    $stmt = $pdo->prepare(peintureBaseSelect("WHERE p.id_peinture = ?") . " LIMIT 1");
    $stmt->execute([$id]);

    return $stmt->fetch();
}

function addPeinture(array $data) {
    global $pdo;

    $authorId = $data['author_id'] ?? null;
    $pdo->beginTransaction();

    try {
        $stmt = $pdo->prepare(
            "INSERT INTO peintures
                (author_id, title, description, creation_date, dimensions, technique)
             VALUES
                (?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $authorId,
            $data['title'] ?? '',
            $data['description'] ?? '',
            $data['date'] ?? '',
            $data['dimensions'] ?? '',
            $data['technique'] ?? '',
        ]);

        $id = (int)$pdo->lastInsertId();
        syncCategoriesForEntity('peinture', $id, $data['meta'] ?? '');
        replacePrimaryMediaForEntity('peinture', $id, mediaDataFromInput($data, $authorId ? (int)$authorId : null));

        $pdo->commit();

        return $id;
    } catch (Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
}

function deletePeinture(int $id) {
    global $pdo;

    $stmt = $pdo->prepare("DELETE FROM peintures WHERE id_peinture = ?");
    $stmt->execute([$id]);
}

function updatePeinture(int $id, array $data) {
    global $pdo;

    $authorId = $data['author_id'] ?? null;
    $pdo->beginTransaction();

    try {
        $stmt = $pdo->prepare(
            "UPDATE peintures
             SET title = ?, description = ?, creation_date = ?, dimensions = ?, technique = ?
             WHERE id_peinture = ?"
        );
        $stmt->execute([
            $data['title'] ?? '',
            $data['description'] ?? '',
            $data['date'] ?? '',
            $data['dimensions'] ?? '',
            $data['technique'] ?? '',
            $id,
        ]);

        syncCategoriesForEntity('peinture', $id, $data['meta'] ?? '');

        if (array_key_exists('image', $data)) {
            replacePrimaryMediaForEntity('peinture', $id, mediaDataFromInput($data, $authorId ? (int)$authorId : null));
        }

        $pdo->commit();
    } catch (Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
}
