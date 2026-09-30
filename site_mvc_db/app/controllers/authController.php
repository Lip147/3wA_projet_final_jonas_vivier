<?php
// app/controllers/authController.php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/session.php';

function loginConfigInt(string $key, int $default): int {
    $value = (int)env_value($key, $default);

    return $value > 0 ? $value : $default;
}

function loginRateLimitFile(): ?string {
    $secret = (string)env_value('LOGIN_RATE_LIMIT_SECRET', '');
    if (strlen($secret) < 32) {
        error_log('[Auth] LOGIN_RATE_LIMIT_SECRET must contain at least 32 characters.');
        return null;
    }

    $rateLimitDir = __DIR__ . '/../../storage/rate_limits';
    if (!is_dir($rateLimitDir) && !mkdir($rateLimitDir, 0775, true) && !is_dir($rateLimitDir)) {
        error_log('[Auth] Unable to create the rate-limit directory.');
        return null;
    }

    $ipAddress = isset($_SERVER['REMOTE_ADDR']) && is_string($_SERVER['REMOTE_ADDR'])
        ? $_SERVER['REMOTE_ADDR']
        : 'unknown';
    $ipIdentifier = hash_hmac('sha256', $ipAddress, $secret);

    return $rateLimitDir . '/login_' . $ipIdentifier . '.json';
}

function loginConsumeAttempt(): bool {
    $now = time();
    $window = loginConfigInt('LOGIN_RATE_WINDOW_SECONDS', 900);
    $sessionLimit = loginConfigInt('LOGIN_SESSION_LIMIT', 5);
    $ipLimit = loginConfigInt('LOGIN_IP_LIMIT', 10);

    $sessionAttempts = isset($_SESSION['login_attempts']) && is_array($_SESSION['login_attempts'])
        ? $_SESSION['login_attempts']
        : [];
    $sessionAttempts = array_values(array_filter(
        $sessionAttempts,
        static fn($timestamp) => is_int($timestamp) && $timestamp > ($now - $window)
    ));

    if (count($sessionAttempts) >= $sessionLimit) {
        $_SESSION['login_attempts'] = $sessionAttempts;
        return false;
    }

    $rateLimitFile = loginRateLimitFile();
    if ($rateLimitFile === null) {
        return false;
    }

    $handle = fopen($rateLimitFile, 'c+');
    if ($handle === false || !flock($handle, LOCK_EX)) {
        if (is_resource($handle)) {
            fclose($handle);
        }
        error_log('[Auth] Unable to lock the login rate-limit file.');
        return false;
    }

    @chmod($rateLimitFile, 0600);
    rewind($handle);
    $storedAttempts = json_decode(stream_get_contents($handle) ?: '[]', true);
    $ipAttempts = is_array($storedAttempts) ? $storedAttempts : [];
    $ipAttempts = array_values(array_filter(
        $ipAttempts,
        static fn($timestamp) => is_int($timestamp) && $timestamp > ($now - $window)
    ));

    $allowed = count($ipAttempts) < $ipLimit;
    if ($allowed) {
        $ipAttempts[] = $now;
        $sessionAttempts[] = $now;
        $_SESSION['login_attempts'] = $sessionAttempts;
    }

    ftruncate($handle, 0);
    rewind($handle);
    fwrite($handle, json_encode($ipAttempts));
    fflush($handle);
    flock($handle, LOCK_UN);
    fclose($handle);

    foreach (glob(dirname($rateLimitFile) . '/login_*.json') ?: [] as $staleFile) {
        if (is_file($staleFile) && filemtime($staleFile) < ($now - $window)) {
            @unlink($staleFile);
        }
    }

    return $allowed;
}

function loginClearAttempts(): void {
    unset($_SESSION['login_attempts']);

    $rateLimitFile = loginRateLimitFile();
    if ($rateLimitFile !== null && is_file($rateLimitFile)) {
        @unlink($rateLimitFile);
    }
}

function login() {
    global $pdo;

    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = isset($_POST['user']) && is_string($_POST['user']) ? trim($_POST['user']) : '';
        $pass = isset($_POST['pass']) && is_string($_POST['pass']) ? $_POST['pass'] : '';

        if (!loginConsumeAttempt()) {
            $error = 'Trop de tentatives de connexion. Veuillez reessayer dans quinze minutes.';
            require __DIR__ . '/../views/login.php';
            return;
        }

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1");
        $stmt->execute([$user, $user]);
        $account = $stmt->fetch();

        if ($account && password_verify($pass, $account['password_hash'])) {
            loginClearAttempts();
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
