<?php
// app/controllers/authController.php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/session.php';

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
            session_regenerate_id(true);
            unset($_SESSION['csrf_token']);

            $_SESSION['is_admin'] = true;
            $_SESSION['user_id'] = (int)$account['id_user'];
            $_SESSION['username'] = $account['username'];
            $_SESSION['role'] = $account['role'];

            redirect_to('admin');
        }

        $error = 'Identifiants invalides.';
    }

    require __DIR__ . '/../views/login.php';
}

function logout() {
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();

        setcookie(session_name(), '', [
            'expires' => time() - 42000,
            'path' => $params['path'],
            'domain' => $params['domain'],
            'secure' => $params['secure'],
            'httponly' => $params['httponly'],
            'samesite' => $params['samesite'] ?? 'Lax',
        ]);
    }

    session_destroy();
    redirect_to('login');
}

function requireAdmin() {
    if (empty($_SESSION['is_admin'])) {
        redirect_to('login');
    }
}

function currentAdminId(): ?int {
    return !empty($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
}
