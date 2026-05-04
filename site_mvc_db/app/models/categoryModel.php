<?php
require_once __DIR__ . '/../../config/database.php';

function categoryEntityConfig(string $entityType): array {
    $configs = [
        'peinture' => ['table' => 'peinture_categorie', 'id_column' => 'id_peinture', 'type' => 'peinture'],
        'couture' => ['table' => 'couture_categorie', 'id_column' => 'id_couture', 'type' => 'couture'],
    ];

    if (!isset($configs[$entityType])) {
        throw new InvalidArgumentException('Type de categorie inconnu.');
    }

    return $configs[$entityType];
}

function slugifyCategoryName(string $name): string {
    $slug = strtolower(trim($name));
    $slug = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $slug) ?: $slug;
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim($slug, '-');

    return $slug !== '' ? $slug : 'categorie';
}

function parseCategoryNames(string $value): array {
    $names = preg_split('/[,;]+/', $value) ?: [];
    $names = array_map('trim', $names);
    $names = array_filter($names, fn($name) => $name !== '');

    return array_values(array_unique($names));
}

function findOrCreateCategory(string $name, string $type): int {
    global $pdo;

    $slug = slugifyCategoryName($name);
    $stmt = $pdo->prepare("SELECT id_categorie FROM categories WHERE slug = ? AND type = ? LIMIT 1");
    $stmt->execute([$slug, $type]);
    $id = $stmt->fetchColumn();

    if ($id) {
        return (int)$id;
    }

    $stmt = $pdo->prepare("INSERT INTO categories (name, slug, type) VALUES (?, ?, ?)");
    $stmt->execute([$name, $slug, $type]);

    return (int)$pdo->lastInsertId();
}

function syncCategoriesForEntity(string $entityType, int $entityId, string $categoryValue): void {
    global $pdo;

    $config = categoryEntityConfig($entityType);
    $stmt = $pdo->prepare("DELETE FROM {$config['table']} WHERE {$config['id_column']} = ?");
    $stmt->execute([$entityId]);

    foreach (parseCategoryNames($categoryValue) as $name) {
        $categoryId = findOrCreateCategory($name, $config['type']);
        $stmt = $pdo->prepare(
            "INSERT IGNORE INTO {$config['table']} ({$config['id_column']}, id_categorie)
             VALUES (?, ?)"
        );
        $stmt->execute([$entityId, $categoryId]);
    }
}

function getCategoriesForEntityType(string $entityType): array {
    global $pdo;

    $config = categoryEntityConfig($entityType);
    $stmt = $pdo->query(
        "SELECT DISTINCT c.name AS meta, c.name, c.slug, c.type
         FROM categories c
         INNER JOIN {$config['table']} link ON link.id_categorie = c.id_categorie
         WHERE c.type IN ('{$config['type']}', 'mixte')
         ORDER BY c.name"
    );

    return $stmt->fetchAll();
}
