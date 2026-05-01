<?php
require __DIR__ . '/../../config/database.php';

function getEvenements() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM evenements ORDER BY id DESC");
    return $stmt->fetchAll();
}

function addEvenement(array $data) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO evenements (image, title, description, date, meta) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['image'] ?? '',
        $data['title'] ?? '',
        $data['description'] ?? '',
        $data['date'] ?? '',
        $data['meta'] ?? ''
    ]);
}

function deleteEvenement(int $id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM evenements WHERE id = ?");
    $stmt->execute([$id]);
}

function updateEvenement(int $id, array $data) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE evenements SET image = ?, title = ?, description = ?, date = ?, meta = ? WHERE id = ?");
    $stmt->execute([
        $data['image'] ?? '',
        $data['title'] ?? '',
        $data['description'] ?? '',
        $data['date'] ?? '',
        $data['meta'] ?? '',
        $id
    ]);
}
