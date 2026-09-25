<?php
// app/controllers/expositionsController.php
require_once __DIR__ . '/../models/evenementModel.php';

function expositions() {
    $eventYears = getEvenementYears();
    $requestedYear = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT);
    $selectedYear = in_array($requestedYear, $eventYears, true)
        ? $requestedYear
        : ($eventYears !== [] ? $eventYears[count($eventYears) - 1] : null);
    $evenements = $selectedYear !== null ? getEvenementsByYear($selectedYear) : [];
    require_once __DIR__ . '/../views/expositions.php';
}
