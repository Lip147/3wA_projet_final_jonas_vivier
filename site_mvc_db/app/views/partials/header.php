<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($pageTitle ?? 'ARCH'); ?></title>
    <link rel="stylesheet" href="/site_mvc_db/public/styles/style.css">
</head>
<body class="<?php echo htmlspecialchars($bodyClass ?? 'gallery-page'); ?>">
<nav class="gallery-navbar">
    <a class="gallery-logo" href="/site_mvc_db/public/home" aria-label="Accueil"></a>
    <div class="gallery-navlinks">
        <?php if (($activePage ?? '') !== 'home'): ?>
        <a href="/site_mvc_db/public/home">Accueil</a>
        <?php endif; ?>
        <?php if (($activePage ?? '') !== 'peinture'): ?>
        <a href="/site_mvc_db/public/peinture">Peintures</a>
        <?php endif; ?>
        <?php if (($activePage ?? '') !== 'couture'): ?>
        <a href="/site_mvc_db/public/couture">Arts textiles</a>
        <?php endif; ?>
        <?php if (($activePage ?? '') !== 'expositions'): ?>
        <a href="/site_mvc_db/public/expositions">&Eacute;v&eacute;nements</a>
        <?php endif; ?>
        <?php if (($activePage ?? '') !== 'biographie'): ?>
        <a href="/site_mvc_db/public/biographie">Biographie</a>
        <?php endif; ?>
        <?php if (($activePage ?? '') !== 'contact'): ?>
        <a href="/site_mvc_db/public/contact">Contact</a>
        <?php endif; ?>
    </div>
</nav>
