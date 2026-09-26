<?php

require_once __DIR__ . '/env.php';

$isProduction = strtolower((string)env_value('APP_ENV', 'production')) === 'production';

error_reporting(E_ALL);
ini_set('log_errors', '1');
ini_set('display_errors', $isProduction ? '0' : '1');

set_exception_handler(function (Throwable $exception) use ($isProduction): void {
    error_log(sprintf(
        '[Unhandled %s] %s in %s:%d',
        get_class($exception),
        $exception->getMessage(),
        $exception->getFile(),
        $exception->getLine()
    ));

    if (!headers_sent()) {
        http_response_code(500);
        header('Content-Type: text/html; charset=UTF-8');
    }

    if ($isProduction) {
        echo 'Une erreur interne est survenue. Veuillez reessayer plus tard.';
        return;
    }

    echo '<pre>' . htmlspecialchars((string)$exception, ENT_QUOTES, 'UTF-8') . '</pre>';
});
