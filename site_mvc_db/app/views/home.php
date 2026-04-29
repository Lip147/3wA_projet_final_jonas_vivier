<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ARCM</title>
    <link rel="stylesheet" href="/styles/style.css">
    <style>
        body { background: #f5f4f4; margin: 0; font-family: serif; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; padding: 2rem 4rem 0 4rem; }
        .logo { font-size: 1.1rem; }
        .nav { display: flex; gap: 2rem; }
        .nav a { color: #111; text-decoration: none; font-size: 1rem; }
        .main-menu { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 70vh; }
        .main-menu a { color: #111; text-decoration: none; font-size: 4rem; margin: 1.5rem 0; transition: color 0.2s; }
        .main-menu a:hover { color: #888; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">ARCM</div>
        <nav class="nav">
            <a href="/site_mvc_db/public/">Accueil</a>
            <a href="/site_mvc_db/public/galerie">Galerie photo</a>
            <a href="/site_mvc_db/public/contact">Contact</a>
        </nav>
    </div>
    <div class="main-menu">
        <a href="/site_mvc_db/public/peinture">Peintures</a>
        <a href="/site_mvc_db/public/couture">Coutures</a>
        <a href="/site_mvc_db/public/expositions">Expositions</a>
    </div>
</body>
</html>
