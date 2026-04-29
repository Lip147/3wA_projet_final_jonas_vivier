<?php
require __DIR__ . '/../../config/database.php';

function getPeintures() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM peintures ORDER BY id DESC");
    return $stmt->fetchAll();
}

function getPeinturesByCategory(string $category) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM peintures WHERE meta LIKE ? ORDER BY id DESC");
    $stmt->execute(['%' . $category . '%']);
    return $stmt->fetchAll();
}

function getPeinturesBySearch(string $search) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM peintures WHERE title LIKE ? OR description LIKE ? ORDER BY id DESC");
    $stmt->execute(['%' . $search . '%', '%' . $search . '%']);
    return $stmt->fetchAll();
}

function getAllCategories() {
    global $pdo;
    $stmt = $pdo->query("SELECT DISTINCT meta FROM peintures WHERE meta IS NOT NULL AND meta != '' ORDER BY meta");
    return $stmt->fetchAll();
}

function getPeintureById(int $id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM peintures WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function addPeinture(array $data) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO peintures (image, title, description, date, meta) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['image'] ?? '',
        $data['title'] ?? '',
        $data['description'] ?? '',
        $data['date'] ?? '',
        $data['meta'] ?? ''
    ]);
}

function deletePeinture(int $id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM peintures WHERE id = ?");
    $stmt->execute([$id]);
}

function updatePeinture(int $id, array $data) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE peintures SET image = ?, title = ?, description = ?, date = ?, meta = ? WHERE id = ?");
    $stmt->execute([
        $data['image'] ?? '',
        $data['title'] ?? '',
        $data['description'] ?? '',
        $data['date'] ?? '',
        $data['meta'] ?? '',
        $id
    ]);
}
