<?php

require_once __DIR__ . '/env.php';

function configure_session_storage(): void
{
    $configuredPath = trim((string)env_value('SESSION_SAVE_PATH', ''));
    if ($configuredPath === '') {
        return;
    }

    $isAbsolutePath = preg_match('#^(?:[A-Za-z]:[\\\\/]|[\\\\/]{2}|/)#', $configuredPath) === 1;
    $sessionPath = $isAbsolutePath
        ? $configuredPath
        : __DIR__ . '/../' . ltrim(str_replace('\\', '/', $configuredPath), '/');

    if (!is_dir($sessionPath) && !mkdir($sessionPath, 0770, true) && !is_dir($sessionPath)) {
        throw new RuntimeException('Le dossier des sessions ne peut pas etre cree.');
    }

    $resolvedSessionPath = realpath($sessionPath);
    if ($resolvedSessionPath === false || !is_writable($resolvedSessionPath)) {
        throw new RuntimeException('Le dossier des sessions ne peut pas etre utilise en ecriture.');
    }

    $publicPath = realpath(__DIR__ . '/../public');
    $normalizedSessionPath = strtolower(str_replace('\\', '/', $resolvedSessionPath));
    $normalizedPublicPath = $publicPath === false
        ? ''
        : strtolower(str_replace('\\', '/', $publicPath));

    if (
        $normalizedPublicPath !== ''
        && (
            $normalizedSessionPath === $normalizedPublicPath
            || str_starts_with($normalizedSessionPath, $normalizedPublicPath . '/')
        )
    ) {
        throw new RuntimeException('Le dossier des sessions doit rester hors du dossier public.');
    }

    @chmod($resolvedSessionPath, 0770);
    if (session_save_path($resolvedSessionPath) === false) {
        throw new RuntimeException('Le chemin de stockage des sessions ne peut pas etre configure.');
    }
}

if (session_status() === PHP_SESSION_NONE) {
    configure_session_storage();

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
