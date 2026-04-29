<?php
// app/controllers/authController.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function login() {
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = $_POST['user'] ?? '';
        $pass = $_POST['pass'] ?? '';
        // Identifiants simples à modifier selon besoin
        if ($user === 'admin' && $pass === 'admin123') {
            $_SESSION['is_admin'] = true;
            header('Location: /site_mvc_db/public/admin');
            exit;
        } else {
            $error = 'Identifiants invalides';
        }
    }
    require __DIR__ . '/../views/login.php';
}

function logout() {
    session_destroy();
    header('Location: /site_mvc_db/public/login');
    exit;
}

function requireAdmin() {
    if (empty($_SESSION['is_admin'])) {
        header('Location: /site_mvc_db/public/login');
        exit;
    }
}
