<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription ?? "Portfolio artistique d'Annie Roger Chamoulaud."); ?>">
    <meta name="author" content="Jonas Vivier">
    <title><?php echo htmlspecialchars($pageTitle ?? 'ARCH'); ?></title>
    <link rel="stylesheet" href="<?php echo rtrim(app_url(), '/'); ?>/styles/style.css">
</head>
<body class="<?php echo htmlspecialchars($bodyClass ?? 'gallery-page'); ?>">
<nav class="gallery-navbar">
    <a class="gallery-logo" href="<?php echo rtrim(app_url(), '/'); ?>/home" aria-label="Accueil"></a>
    <div class="gallery-navlinks">
        <?php if (($activePage ?? '') !== 'home'): ?>
        <a href="<?php echo rtrim(app_url(), '/'); ?>/home">Accueil</a>
        <?php endif; ?>
        <?php if (($activePage ?? '') !== 'peinture'): ?>
        <a href="<?php echo rtrim(app_url(), '/'); ?>/peinture">Peintures</a>
        <?php endif; ?>
        <?php if (($activePage ?? '') !== 'couture'): ?>
        <a href="<?php echo rtrim(app_url(), '/'); ?>/couture">Arts textiles</a>
        <?php endif; ?>
        <?php if (($activePage ?? '') !== 'expositions'): ?>
        <a href="<?php echo rtrim(app_url(), '/'); ?>/expositions">&Eacute;v&eacute;nements</a>
        <?php endif; ?>
        <?php if (($activePage ?? '') !== 'biographie'): ?>
        <a href="<?php echo rtrim(app_url(), '/'); ?>/biographie">Biographie</a>
        <?php endif; ?>
        <?php if (($activePage ?? '') !== 'contact'): ?>
        <a href="<?php echo rtrim(app_url(), '/'); ?>/contact">Contact</a>
        <?php endif; ?>
    </div>
</nav>
