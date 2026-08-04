<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription ?? "Portfolio artistique d'Annie Roger Chamoulaud."); ?>">
    <meta name="author" content="Jonas Vivier">
    <title>ARCH</title>
    <link rel="stylesheet" href="/site_mvc_db/public/styles/style.css?v=<?php echo filemtime(__DIR__ . '/../../public/styles/style.css'); ?>">
</head>
<body class="home-page">
    <div class="header">
        <a class="logo" href="/site_mvc_db/public/arcm">ARCH</a>
        <nav class="nav">
            <a href="/site_mvc_db/public/expositions">&Eacute;v&eacute;nements</a>
            <a href="/site_mvc_db/public/biographie">Biographie</a>
            <a href="/site_mvc_db/public/contact">Contact</a>
        </nav>
    </div>
    <div class="main-menu">
        <div class="menu-links">
            <a class="menu-peintures" href="/site_mvc_db/public/peinture">Peintures</a>
            <a class="menu-coutures" href="/site_mvc_db/public/couture">Arts textiles</a>
        </div>
    </div>
</body>
</html>
