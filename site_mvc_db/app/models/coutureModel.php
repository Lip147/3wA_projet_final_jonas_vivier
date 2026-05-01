<?php
require __DIR__ . '/../../config/database.php';

function getCoutures() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM coutures ORDER BY id DESC");
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
