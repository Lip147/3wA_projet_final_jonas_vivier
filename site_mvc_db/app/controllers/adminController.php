<?php
require_once __DIR__ . '/../controllers/authController.php';
require __DIR__ . '/../models/peintureModel.php';
require __DIR__ . '/../models/coutureModel.php';
require __DIR__ . '/../models/evenementModel.php';

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

function adminCoutures() {
    requireAdmin();
    $coutures = getCoutures();
    require __DIR__ . '/../views/admin_coutures.php';
}

function adminAddCouture(array $data) {
    requireAdmin();
    addCouture($data);
    header('Location: /site_mvc_db/public/admin/coutures');
    exit;
}

function adminDeleteCouture(int $id) {
    requireAdmin();
    deleteCouture($id);
    header('Location: /site_mvc_db/public/admin/coutures');
    exit;
}

function adminUpdateCouture(array $data) {
    requireAdmin();
    $id = $data['id'] ?? null;
    if ($id) {
        updateCouture((int)$id, $data);
    }
    header('Location: /site_mvc_db/public/admin/coutures');
    exit;
}

function adminEvenements() {
    requireAdmin();
    $evenements = getEvenements();
    require __DIR__ . '/../views/admin_evenements.php';
}

function adminAddEvenement(array $data) {
    requireAdmin();
    addEvenement($data);
    header('Location: /site_mvc_db/public/admin/evenements');
    exit;
}

function adminDeleteEvenement(int $id) {
    requireAdmin();
    deleteEvenement($id);
    header('Location: /site_mvc_db/public/admin/evenements');
    exit;
}

function adminUpdateEvenement(array $data) {
    requireAdmin();
    $id = $data['id'] ?? null;
    if ($id) {
        updateEvenement((int)$id, $data);
    }
    header('Location: /site_mvc_db/public/admin/evenements');
    exit;
}
