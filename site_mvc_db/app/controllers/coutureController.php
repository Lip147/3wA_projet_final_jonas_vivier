<?php
// app/controllers/coutureController.php
require __DIR__ . '/../models/coutureModel.php';

function couture() {
    $search = trim($_GET['search'] ?? '');
    $category = trim($_GET['category'] ?? '');
    $technique = trim($_GET['technique'] ?? '');

    $coutures = getCouturesByFilters($search, $category, $technique);
    $categories = getAllCoutureCategories();
    $techniques = getAllCoutureTechniques();

    require_once __DIR__ . '/../views/couture.php';
}
