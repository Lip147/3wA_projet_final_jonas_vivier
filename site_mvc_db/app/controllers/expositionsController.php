<?php
// app/controllers/expositionsController.php
require_once __DIR__ . '/../models/evenementModel.php';

function expositions() {
    $eventYears = getEvenementYears();
    $showUpcoming = ($_GET['filter'] ?? '') === 'upcoming';
    $requestedYear = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT);
    $selectedYear = !$showUpcoming && in_array($requestedYear, $eventYears, true)
        ? $requestedYear
        : (!$showUpcoming && $eventYears !== [] ? $eventYears[count($eventYears) - 1] : null);
    $evenements = $showUpcoming
        ? getUpcomingEvenements()
        : ($selectedYear !== null ? getEvenementsByYear($selectedYear) : []);
    require_once __DIR__ . '/../views/expositions.php';
}
