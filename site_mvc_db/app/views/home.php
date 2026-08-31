<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription ?? "Portfolio artistique d'Annie Roger Chamoulaud."); ?>">
    <meta name="author" content="Jonas Vivier">
    <title>ARCH</title>
    <link rel="stylesheet" href="<?php echo rtrim(app_url(), '/'); ?>/styles/style.css?v=<?php echo filemtime(__DIR__ . '/../../public/styles/style.css'); ?>">
</head>
<body class="home-page">
    <div class="header">
        <a class="logo" href="<?php echo rtrim(app_url(), '/'); ?>/arcm" aria-label="ARCH">
            <img src="<?php echo rtrim(app_url(), '/'); ?>/images/logo_arch.png" alt="ARCH">
        </a>
        <nav class="nav">
            <a href="<?php echo rtrim(app_url(), '/'); ?>/expositions">&Eacute;v&eacute;nements</a>
            <a href="<?php echo rtrim(app_url(), '/'); ?>/biographie">Biographie</a>
            <a href="<?php echo rtrim(app_url(), '/'); ?>/contact">Contact</a>
        </nav>
    </div>
    <div class="main-menu">
        <div class="menu-links">
            <a class="menu-peintures" href="<?php echo rtrim(app_url(), '/'); ?>/peinture">Peintures</a>
            <a class="menu-coutures" href="<?php echo rtrim(app_url(), '/'); ?>/couture">Arts textiles</a>
        </div>
    </div>
</body>
</html>
