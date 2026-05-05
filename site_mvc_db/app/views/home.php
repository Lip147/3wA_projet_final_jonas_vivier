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
            --home-scene-offset: 2rem;
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
            transform: translateY(var(--home-scene-offset));
        }
        .main-menu a { color: #111; text-decoration: none; font-size: 4rem; margin: 0; transition: color 0.2s; }
        .main-menu a:hover { color: #fff; }
        .home-photo {
            position: absolute;
            z-index: 3;
            display: block;
            width: clamp(12rem, 17vw, 17.5rem);
            height: auto;
            pointer-events: none;
            transition: opacity 0.25s ease;
            transform: translateY(var(--home-scene-offset));
        }
        .home-photo--top { top: 8%; left: 31%; }
        .home-photo--left { top: 39%; left: 19%; width: clamp(13rem, 19vw, 19rem); }
        .home-photo--right { top: 57%; right: 17%; width: clamp(9rem, 12vw, 12.5rem); }
        .home-arrows {
            position: absolute;
            inset: 0;
            z-index: 2;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: visible;
            transition: opacity 0.25s ease;
            transform: translateY(var(--home-scene-offset));
        }
        .home-arrows > path {
            fill: none;
            stroke: #111;
            stroke-width: 2.2;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-dasharray: 12 18;
        }
        body:has(.main-menu a:hover) .logo,
        body:has(.main-menu a:hover) .nav a {
            color: #fff;
        }
        body:has(.main-menu a:hover) .home-photo,
        body:has(.main-menu a:hover) .home-arrows {
            opacity: 0;
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
                --home-scene-offset: 0;
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
            .home-photo {
                position: static;
                width: min(78vw, 20rem);
            }
            .home-photo--top { order: 1; }
            .home-photo--left { order: 3; }
            .home-photo--right { order: 4; }
            .home-arrows {
                display: none;
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
        <img class="home-photo home-photo--top" src="/site_mvc_db/public/images/home/maison-rue.jpg" alt="">
        <img class="home-photo home-photo--left" src="/site_mvc_db/public/images/home/petite-foret.jpg" alt="">
        <img class="home-photo home-photo--right" src="/site_mvc_db/public/images/home/sac-jean-carreau.png" alt="">
        <svg class="home-arrows" viewBox="0 0 1000 700" aria-hidden="true" focusable="false">
            <defs>
                <marker id="arrow-head" viewBox="0 0 12 12" refX="10" refY="6" markerWidth="14" markerHeight="14" orient="auto-start-reverse">
                    <path d="M2 2 L10 6 L2 10" fill="none" stroke="#111" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"></path>
                </marker>
            </defs>
            <path d="M630 360 C610 312 548 275 492 252" marker-end="url(#arrow-head)"></path>
            <path d="M505 410 C465 438 420 435 378 418" marker-end="url(#arrow-head)"></path>
            <path d="M560 535 C625 575 710 590 765 625" marker-end="url(#arrow-head)"></path>
        </svg>
        <div class="menu-links">
            <a class="menu-peintures" href="/site_mvc_db/public/peinture">Peintures</a>
            <a class="menu-coutures" href="/site_mvc_db/public/couture">Arts textiles</a>
        </div>
    </div>
</body>
</html>
