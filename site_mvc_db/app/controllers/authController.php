<?php
// app/controllers/authController.php
require_once __DIR__ . '/../../config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function login() {
    global $pdo;

    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = $_POST['user'] ?? '';
        $pass = $_POST['pass'] ?? '';

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1");
        $stmt->execute([$user, $user]);
        $account = $stmt->fetch();

        if ($account && password_verify($pass, $account['password_hash'])) {
            $_SESSION['is_admin'] = true;
            $_SESSION['user_id'] = (int)$account['id_user'];
            $_SESSION['username'] = $account['username'];
            $_SESSION['role'] = $account['role'];

            header('Location: /site_mvc_db/public/admin');
            exit;
        }

        $error = 'Identifiants invalides';
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

function currentAdminId(): ?int {
    return !empty($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
}
