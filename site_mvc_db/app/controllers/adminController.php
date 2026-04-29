<?php
require_once __DIR__ . '/../controllers/authController.php';
require __DIR__ . '/../models/peintureModel.php';

function admin() {
    requireAdmin();
    $peintures = getPeintures();
    require __DIR__ . '/../views/admin.php';
}

function adminAddPeinture(array $data) {
    requireAdmin();
    addPeinture($data);
    header('Location: /site_mvc_db/public/admin');
    exit;
}

function adminDeletePeinture(int $id) {
    requireAdmin();
    deletePeinture($id);
    header('Location: /site_mvc_db/public/admin');
    exit;
}

function adminUpdatePeinture(array $data) {
    requireAdmin();
    $id = $data['id'] ?? null;
    if ($id) {
        updatePeinture((int)$id, $data);
    }
    header('Location: /site_mvc_db/public/admin');
    exit;
}
