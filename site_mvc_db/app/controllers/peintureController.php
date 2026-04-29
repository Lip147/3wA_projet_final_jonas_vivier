<?php
require __DIR__ . '/../models/peintureModel.php';
require __DIR__ . '/../views/layout.php';

function peinture() {
    $search = $_GET['search'] ?? '';
    $category = $_GET['category'] ?? '';
    
    if (!empty($search)) {
        $peintures = getPeinturesBySearch($search);
    } elseif (!empty($category)) {
        $peintures = getPeinturesByCategory($category);
    } else {
        $peintures = getPeintures();
    }
    
    $categories = getAllCategories();
    
    require_once __DIR__ . '/../views/peinture.php';
}

function showPeinture(int $id) {
    $peinture = getPeintureById($id);
    render('peinture_single', ['peinture' => $peinture]);
}
