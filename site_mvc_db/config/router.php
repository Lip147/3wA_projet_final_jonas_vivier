<?php
// config/router.php
// Définit les routes de l'application sous forme de tableau associatif

return [
    'login' => [
        'controller' => '../app/controllers/authController.php',
        'action' => function() { login(); }
    ],
    'logout' => [
        'controller' => '../app/controllers/authController.php',
        'action' => function() { logout(); }
    ],
    '' => [
        'controller' => '../app/controllers/arcmController.php',
        'action' => function() { arcm(); }
    ],
    'arcm' => [
        'controller' => '../app/controllers/arcmController.php',
        'action' => function() { arcm(); }
    ],
    'home' => [
        'controller' => '../app/controllers/homeController.php',
        'action' => function() { home(); }
    ],
    'peinture' => [
        'controller' => '../app/controllers/peintureController.php',
        'action' => function($id = null) {
            if ($id) showPeinture($id);
            else peinture();
        }
    ],
    'couture' => [
        'controller' => '../app/controllers/coutureController.php',
        'action' => function() { couture(); }
    ],
    'expositions' => [
        'controller' => '../app/controllers/expositionsController.php',
        'action' => function() { expositions(); }
    ],
    'galerie' => [
        'controller' => '../app/controllers/galerieController.php',
        'action' => function() { galerie(); }
    ],
    'contact' => [
        'controller' => '../app/controllers/contactController.php',
        'action' => function() { contact(); }
    ],
    'admin' => [
        'controller' => '../app/controllers/adminController.php',
        'action' => function() { admin(); }
    ],
    'admin/add' => [
        'controller' => '../app/controllers/adminController.php',
        'action' => function() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') adminAddPeinture($_POST);
            else header('Location: /site_mvc_db/public/admin');
        }
    ],
    'admin/delete' => [
        'controller' => '../app/controllers/adminController.php',
        'action' => function() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) adminDeletePeinture((int)$_POST['id']);
            else header('Location: /site_mvc_db/public/admin');
        }
    ],
    'admin/update' => [
        'controller' => '../app/controllers/adminController.php',
        'action' => function() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') adminUpdatePeinture($_POST);
            else header('Location: /site_mvc_db/public/admin');
        }
    ],
];
