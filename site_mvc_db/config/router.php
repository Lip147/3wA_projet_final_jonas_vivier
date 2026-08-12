<?php
// config/router.php
// Definit les routes de l'application sous forme de tableau associatif.

$controllerDir = __DIR__ . '/../app/controllers';

return [
    'login' => [
        'controller' => $controllerDir . '/authController.php',
        'action' => function() { login(); }
    ],
    'logout' => [
        'controller' => $controllerDir . '/authController.php',
        'action' => function() { logout(); }
    ],
    '' => [
        'controller' => $controllerDir . '/arcmController.php',
        'action' => function() { arcm(); }
    ],
    'arcm' => [
        'controller' => $controllerDir . '/arcmController.php',
        'action' => function() { arcm(); }
    ],
    'home' => [
        'controller' => $controllerDir . '/homeController.php',
        'action' => function() { home(); }
    ],
    'peinture' => [
        'controller' => $controllerDir . '/peintureController.php',
        'action' => function($id = null) {
            if ($id) showPeinture($id);
            else peinture();
        }
    ],
    'couture' => [
        'controller' => $controllerDir . '/coutureController.php',
        'action' => function() { couture(); }
    ],
    'expositions' => [
        'controller' => $controllerDir . '/expositionsController.php',
        'action' => function() { expositions(); }
    ],
    'galerie' => [
        'controller' => $controllerDir . '/galerieController.php',
        'action' => function() { galerie(); }
    ],
    'biographie' => [
        'controller' => $controllerDir . '/biographieController.php',
        'action' => function() { biographie(); }
    ],
    'contact' => [
        'controller' => $controllerDir . '/contactController.php',
        'action' => function() { contact(); }
    ],
    'media' => [
        'controller' => $controllerDir . '/mediaController.php',
        'action' => function() { media(); }
    ],
    'admin' => [
        'controller' => $controllerDir . '/adminController.php',
        'action' => function() { admin(); }
    ],
    'admin/coutures' => [
        'controller' => $controllerDir . '/adminController.php',
        'action' => function() { adminCoutures(); }
    ],
    'admin/coutures/add' => [
        'controller' => $controllerDir . '/adminController.php',
        'action' => function() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') adminAddCouture($_POST);
            else redirect_to('admin/coutures');
        }
    ],
    'admin/coutures/delete' => [
        'controller' => $controllerDir . '/adminController.php',
        'action' => function() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) adminDeleteCouture((int)$_POST['id']);
            else redirect_to('admin/coutures');
        }
    ],
    'admin/coutures/update' => [
        'controller' => $controllerDir . '/adminController.php',
        'action' => function() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') adminUpdateCouture($_POST);
            else redirect_to('admin/coutures');
        }
    ],
    'admin/evenements' => [
        'controller' => $controllerDir . '/adminController.php',
        'action' => function() { adminEvenements(); }
    ],
    'admin/evenements/add' => [
        'controller' => $controllerDir . '/adminController.php',
        'action' => function() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') adminAddEvenement($_POST);
            else redirect_to('admin/evenements');
        }
    ],
    'admin/evenements/delete' => [
        'controller' => $controllerDir . '/adminController.php',
        'action' => function() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) adminDeleteEvenement((int)$_POST['id']);
            else redirect_to('admin/evenements');
        }
    ],
    'admin/evenements/update' => [
        'controller' => $controllerDir . '/adminController.php',
        'action' => function() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') adminUpdateEvenement($_POST);
            else redirect_to('admin/evenements');
        }
    ],
    'admin/add' => [
        'controller' => $controllerDir . '/adminController.php',
        'action' => function() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') adminAddPeinture($_POST);
            else redirect_to('admin');
        }
    ],
    'admin/delete' => [
        'controller' => $controllerDir . '/adminController.php',
        'action' => function() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) adminDeletePeinture((int)$_POST['id']);
            else redirect_to('admin');
        }
    ],
    'admin/update' => [
        'controller' => $controllerDir . '/adminController.php',
        'action' => function() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') adminUpdatePeinture($_POST);
            else redirect_to('admin');
        }
    ],
];
