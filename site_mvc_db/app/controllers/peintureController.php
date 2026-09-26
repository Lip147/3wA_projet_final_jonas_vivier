<?php
require __DIR__ . '/../models/peintureModel.php';
require __DIR__ . '/../views/layout.php';

function peinture() {
    $search = trim($_GET['search'] ?? '');
    $category = trim($_GET['category'] ?? '');
    $technique = trim($_GET['technique'] ?? '');

    $peintures = getPeinturesByFilters($search, $category, $technique);
    $categories = getAllCategories();
    $techniques = getAllPaintingTechniques();

    require_once __DIR__ . '/../views/peinture.php';
}

function showPeinture(int $id) {
    $peinture = getPeintureById($id);
    render('peinture_single', ['peinture' => $peinture]);
}
