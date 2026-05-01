<?php
session_start();

// Détecte le chemin du dossier public
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$publicPos = strpos($scriptName, '/public');
$basePath = $publicPos !== false ? substr($scriptName, 0, $publicPos + 7) : '';

$requestUri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
// Sépare le chemin des paramètres GET
$urlParts = parse_url($requestUri);
$requestPath = $urlParts['path'] ?? '';

// Retire le chemin de base
$request = trim(preg_replace('#^' . preg_quote($basePath, '#') . '#', '', $requestPath), '/');
$segments = explode('/', $request);

// Construit la clé de route (ex: 'admin', 'admin/add', 'admin/delete', 'peinture')
$page = implode('/', array_filter($segments));
$id   = isset($segments[2]) ? $segments[2] : null;

$routes = require '../config/router.php';
if (array_key_exists($page, $routes)) {
    $route = $routes[$page];
    if (!empty($route['controller'])) {
        require_once $route['controller'];
    }
    if (is_callable($route['action'])) {
        $route['action']($id);
    }
} else {
    echo "404";
}
