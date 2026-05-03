<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($pageTitle ?? 'ARCM'); ?></title>
    <link rel="stylesheet" href="/site_mvc_db/public/styles/style.css">
</head>
<body class="<?php echo htmlspecialchars($bodyClass ?? 'gallery-page'); ?>">
<nav class="gallery-navbar">
    <a class="gallery-logo" href="/site_mvc_db/public/home" aria-label="Accueil"></a>
    <div class="gallery-navlinks">
        <a class="<?php echo (($activePage ?? '') === 'home') ? 'is-active' : ''; ?>" href="/site_mvc_db/public/home">Accueil</a>
        <a class="<?php echo (($activePage ?? '') === 'peinture') ? 'is-active' : ''; ?>" href="/site_mvc_db/public/peinture">Peintures</a>
        <a class="<?php echo (($activePage ?? '') === 'couture') ? 'is-active' : ''; ?>" href="/site_mvc_db/public/couture">Coutures</a>
        <a class="<?php echo (($activePage ?? '') === 'expositions') ? 'is-active' : ''; ?>" href="/site_mvc_db/public/expositions">&Eacute;v&eacute;nements</a>
        <a class="<?php echo (($activePage ?? '') === 'biographie') ? 'is-active' : ''; ?>" href="/site_mvc_db/public/biographie">Biographie</a>
        <a class="<?php echo (($activePage ?? '') === 'contact') ? 'is-active' : ''; ?>" href="/site_mvc_db/public/contact">Contact</a>
    </div>
</nav>
