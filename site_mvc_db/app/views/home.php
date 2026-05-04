<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ARCM</title>
    <style>
        body {
            min-height: 100vh;
            background: #f5f4f4;
            margin: 0;
            font-family: serif;
            position: relative;
        }
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            z-index: 0;
            background-image: var(--home-bg);
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 0.35s ease;
        }
        body:has(.menu-peintures:hover) {
            --home-bg: url("/site_mvc_db/public/images/coucher-de-soleil-surla-foret-arcm.JPG");
        }
        body:has(.menu-coutures:hover) {
            --home-bg: url("/site_mvc_db/public/images/coussinjean.jpeg");
        }
        body:has(.menu-evenements:hover) {
            --home-bg: url("/site_mvc_db/public/images/hotel-sully.jpeg");
        }
        body:has(.menu-peintures:hover)::before,
        body:has(.menu-coutures:hover)::before,
        body:has(.menu-evenements:hover)::before {
            opacity: 1;
        }
        .header { display: flex; justify-content: space-between; align-items: flex-start; padding: 2rem 4rem 0 4rem; position: relative; z-index: 1; }
        .logo { color: #111; font-size: 1.1rem; text-decoration: none; transition: color 0.2s; }
        .logo:hover { color: #888; }
        .nav { display: flex; gap: 2rem; }
        .nav a { color: #111; text-decoration: none; font-size: 1rem; transition: color 0.2s; }
        .nav a:hover, .nav a.is-active { text-decoration: underline; text-underline-offset: 0.35rem; }
        .main-menu { display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 86vh; padding-top: 12rem; box-sizing: border-box; position: relative; z-index: 1; }
        .main-menu a { color: #111; text-decoration: none; font-size: 4rem; margin: 1.5rem 0; transition: color 0.2s; }
        .main-menu a:hover { color: #fff; }
        body:has(.main-menu a:hover) .logo,
        body:has(.main-menu a:hover) .nav a {
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="header">
        <a class="logo" href="/site_mvc_db/public/arcm">ARCM</a>
        <nav class="nav">
            <a href="/site_mvc_db/public/biographie">Biographie</a>
            <a href="/site_mvc_db/public/contact">Contact</a>
        </nav>
    </div>
    <div class="main-menu">
        <a class="menu-peintures" href="/site_mvc_db/public/peinture">Peintures</a>
        <a class="menu-coutures" href="/site_mvc_db/public/couture">Coutures</a>
        <a class="menu-evenements" href="/site_mvc_db/public/expositions">&Eacute;v&eacute;nements</a>
    </div>
</body>
</html>
