<?php
// app/controllers/expositionsController.php
require_once __DIR__ . '/../models/evenementModel.php';

function expositions() {
    $evenements = array_reverse(getEvenements());
    require_once __DIR__ . '/../views/expositions.php';
}
