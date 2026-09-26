<?php
require_once __DIR__ . '/../config/errors.php';
require_once __DIR__ . '/../config/html.php';
require_once __DIR__ . '/../config/session.php';
header('Content-Type: text/html; charset=UTF-8');
require_once __DIR__ . '/../config/csrf.php';

// Détecte le chemin du dossier public
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$publicPos = strpos($scriptName, '/public');
$basePath = $publicPos !== false ? substr($scriptName, 0, $publicPos + 7) : '';

function app_url(string $path = ''): string {
    global $basePath;

    $path = '/' . ltrim($path, '/');
    return rtrim($basePath, '/') . $path;
}

function redirect_to(string $path): void {
    header('Location: ' . app_url($path));
    exit;
}

$requestUri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
// Sépare le chemin des paramètres GET
$urlParts = parse_url($requestUri);
$requestPath = $urlParts['path'] ?? '';

// Retire le chemin de base
$request = trim(preg_replace('#^' . preg_quote($basePath, '#') . '#', '', $requestPath), '/');
$segments = $request === '' ? [] : explode('/', $request);

// Construit la clé de route (ex: 'admin', 'admin/add', 'admin/delete', 'peinture')
$page = implode('/', $segments);
$id = null;

// La route de detail /peinture/{id} utilise la route "peinture" avec un identifiant.
if (
    count($segments) === 2
    && $segments[0] === 'peinture'
    && preg_match('/^[1-9][0-9]*$/', $segments[1])
) {
    $page = 'peinture';
    $id = (int)$segments[1];
}

$routes = require __DIR__ . '/../config/router.php';
if (array_key_exists($page, $routes)) {
    $route = $routes[$page];

    if (
        ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'
        && ($page === 'admin' || str_starts_with($page, 'admin/'))
    ) {
        verify_csrf();
    }

    if (!empty($route['controller'])) {
        require_once $route['controller'];
    }
    if (is_callable($route['action'])) {
        $route['action']($id);
    }
} else {
    echo "404";
}
