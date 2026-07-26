<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ARCH</title>
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
        body:has(.menu-peintures:hover)::before,
        body:has(.menu-coutures:hover)::before {
            opacity: 1;
        }
        .header { display: flex; justify-content: space-between; align-items: flex-start; padding: 2rem 4rem 0 4rem; position: relative; z-index: 1; }
        .logo { color: #111; font-size: 1.1rem; text-decoration: none; transition: color 0.2s; }
        .logo:hover { color: #888; }
        .nav { display: flex; gap: 2rem; }
        .nav a { color: #111; text-decoration: none; font-size: 1rem; transition: color 0.2s; }
        .nav a:hover, .nav a.is-active { text-decoration: underline; text-underline-offset: 0.35rem; }
        .main-menu {
            display: grid;
            place-items: center;
            min-height: 86vh;
            padding: 5rem clamp(1rem, 5vw, 5rem) 4rem;
            box-sizing: border-box;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }
        .menu-links {
            position: relative;
            z-index: 3;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2.5rem;
            margin-top: 5rem;
        }
        .main-menu a { color: #111; text-decoration: none; font-size: 4rem; margin: 0; transition: color 0.2s; }
        .main-menu a:hover { color: #fff; }
        body:has(.main-menu a:hover) .logo,
        body:has(.main-menu a:hover) .nav a {
            color: #fff;
        }
        @media (max-width: 900px) {
            .header {
                flex-direction: column;
                gap: 1.5rem;
                padding: 1.5rem;
            }
            .nav {
                flex-wrap: wrap;
                gap: 1rem 1.5rem;
            }
            .main-menu {
                display: flex;
                flex-direction: column;
                min-height: auto;
                padding: 3rem 1.5rem 5rem;
                gap: 1.5rem;
                overflow: visible;
            }
            .menu-links {
                order: 2;
                gap: 1.5rem;
                margin-top: 0;
            }
            .main-menu a {
                font-size: clamp(3rem, 15vw, 4rem);
            }
        }
    </style>
</head>
<body>
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
