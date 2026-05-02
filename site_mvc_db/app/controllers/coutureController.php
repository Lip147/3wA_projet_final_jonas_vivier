<?php
// app/controllers/coutureController.php
require __DIR__ . '/../models/coutureModel.php';

function couture() {
    $search = $_GET['search'] ?? '';
    $category = $_GET['category'] ?? '';

    if (!empty($search)) {
        $coutures = getCouturesBySearch($search);
    } elseif (!empty($category)) {
        $coutures = getCouturesByCategory($category);
    } else {
        $coutures = getCoutures();
    }

    $categories = getAllCoutureCategories();

    require_once __DIR__ . '/../views/couture.php';
}
