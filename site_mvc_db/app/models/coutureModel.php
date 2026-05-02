<?php
require __DIR__ . '/../../config/database.php';

function getCoutures() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM coutures ORDER BY id DESC");
    return $stmt->fetchAll();
}

function getCouturesByCategory(string $category) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM coutures WHERE meta LIKE ? ORDER BY id DESC");
    $stmt->execute(['%' . $category . '%']);
    return $stmt->fetchAll();
}

function getCouturesBySearch(string $search) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM coutures WHERE title LIKE ? OR description LIKE ? ORDER BY id DESC");
    $stmt->execute(['%' . $search . '%', '%' . $search . '%']);
    return $stmt->fetchAll();
}

function getAllCoutureCategories() {
    global $pdo;
    $stmt = $pdo->query("SELECT DISTINCT meta FROM coutures WHERE meta IS NOT NULL AND meta != '' ORDER BY meta");
    return $stmt->fetchAll();
}

function addCouture(array $data) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO coutures (image, title, description, date, meta) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['image'] ?? '',
        $data['title'] ?? '',
        $data['description'] ?? '',
        $data['date'] ?? '',
        $data['meta'] ?? ''
    ]);
}

function deleteCouture(int $id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM coutures WHERE id = ?");
    $stmt->execute([$id]);
}

function updateCouture(int $id, array $data) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE coutures SET image = ?, title = ?, description = ?, date = ?, meta = ? WHERE id = ?");
    $stmt->execute([
        $data['image'] ?? '',
        $data['title'] ?? '',
        $data['description'] ?? '',
        $data['date'] ?? '',
        $data['meta'] ?? '',
        $id
    ]);
}
