<?php
function render($view, $data = []) {
    extract($data);
    require __DIR__ . '/partials/header.php';
    require __DIR__ . "/$view.php";
    require __DIR__ . '/partials/footer.php';
}
