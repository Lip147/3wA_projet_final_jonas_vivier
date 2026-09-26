<?php

require_once __DIR__ . '/env.php';

if (session_status() === PHP_SESSION_NONE) {
    $secureCookie = filter_var(
        env_value('SESSION_SECURE', 'false'),
        FILTER_VALIDATE_BOOLEAN
    );

    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');

    session_name('arcm_session');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $secureCookie,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    session_start();
}
