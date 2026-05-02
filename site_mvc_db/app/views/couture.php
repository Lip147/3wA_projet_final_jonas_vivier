<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Coutures</title>
    <link rel="stylesheet" href="/site_mvc_db/public/styles/style.css">
    <style>
        .paintings-layout {
            display: grid;
            grid-template-columns: minmax(220px, 270px) minmax(0, 1fr);
            gap: 2.75rem;
            width: min(100% - 3rem, 1920px);
            margin: 0 auto;
            padding: 1.75rem 0 4rem;
        }
        .paintings-filter {
            align-self: start;
            position: sticky;
            top: calc(8.25rem + 47px + 1.75rem);
            z-index: 10;
            min-height: 605px;
            background: #fff;
            color: #000;
            padding: 4rem 1.8rem 2rem;
        }
        .paintings-filter h1 {
            margin: 0 0 2rem;
            font-size: clamp(1.8rem, 2.5vw, 2.6rem);
            font-weight: 400;
            line-height: 1.15;
        }
        .filter-form {
            display: grid;
            gap: 1.25rem;
        }
        .filter-form label {
            display: grid;
            gap: 0.45rem;
            font-size: 0.95rem;
        }
        .filter-form input,
        .filter-form select {
            width: 100%;
            border: 1px solid #111;
            background: #fff;
            color: #000;
            padding: 0.75rem;
            font: inherit;
        }
        .filter-form input:focus,
        .filter-form select:focus {
            outline: 2px solid #000;
            outline-offset: 2px;
        }
        .filter-actions {
            display: grid;
            gap: 0.75rem;
            margin-top: 0.5rem;
        }
        .filter-actions button,
        .filter-actions a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            border: 1px solid #000;
            background: #000;
            color: #fff;
            text-decoration: none;
            font: inherit;
            cursor: pointer;
        }
        .filter-actions a {
            background: #fff;
            color: #000;
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 2rem;
            background: #000;
        }
        .gallery-card {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.5);
            cursor: pointer;
            aspect-ratio: 1 / 1;
            background: #111;
        }
        .gallery-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: filter 0.3s;
        }
        .gallery-card .hover-info {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #ffc400;
            color: #222;
            opacity: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem 1rem;
            transition: opacity 0.3s;
            z-index: 2;
        }
        .gallery-card:hover .hover-info {
            opacity: 1;
        }
        .gallery-card:hover img {
            filter: blur(2px) brightness(0.7);
        }
        .hover-info h2 {
            margin: 0 0 1rem;
            font-size: 1.5rem;
        }
        .hover-info .meta {
            margin-top: 1.5rem;
            font-size: 0.95rem;
            color: #444;
        }
        .gallery-empty {
            grid-column: 1 / -1;
            color: #888;
            text-align: center;
            margin: 4rem 0;
        }
        @media (max-width: 900px) {
            .paintings-layout {
                grid-template-columns: 1fr;
                width: min(100% - 2rem, 1920px);
            }
            .paintings-filter {
                position: static;
                min-height: auto;
                padding: 2rem;
            }
            .gallery-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        @media (max-width: 540px) {
            .gallery-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="gallery-page">
    <nav class="gallery-navbar">
        <a class="gallery-logo" href="/site_mvc_db/public/home" aria-label="Accueil"></a>
        <div class="gallery-navlinks">
            <a href="/site_mvc_db/public/home">Accueil</a>
            <a href="/site_mvc_db/public/peinture">Peintures</a>
            <a class="is-active" href="/site_mvc_db/public/couture">Coutures</a>
            <a href="/site_mvc_db/public/expositions">Événements</a>
            <a href="/site_mvc_db/public/contact">Contact</a>
        </div>
    </nav>
    <main class="paintings-layout">
        <aside class="paintings-filter">
            <h1>Barre de recherche</h1>
            <form class="filter-form" method="get" action="/site_mvc_db/public/couture">
                <label>
                    Recherche
                    <input type="text" name="search" placeholder="Nom de la couture" value="<?php echo htmlspecialchars($search ?? ''); ?>">
                </label>
                <label>
                    Catégorie
                    <select name="category">
                        <option value="">Toutes les catégories</option>
                        <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo htmlspecialchars($cat['meta']); ?>" <?php echo (($category ?? '') === $cat['meta']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['meta']); ?>
                        </option>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </label>
                <div class="filter-actions">
                    <button type="submit">Filtrer</button>
                    <a href="/site_mvc_db/public/couture">Réinitialiser</a>
                </div>
            </form>
        </aside>
        <section class="gallery-grid" aria-label="Grille des coutures">
            <?php if (empty($coutures)): ?>
            <p class="gallery-empty">Aucune couture trouvée.</p>
            <?php else: ?>
            <?php foreach ($coutures as $c): ?>
            <div class="gallery-card">
                <img src="<?php echo htmlspecialchars($c['image']); ?>" alt="<?php echo htmlspecialchars($c['title']); ?>">
                <div class="hover-info">
                    <div style="align-self: flex-start; font-size: 1rem; margin-bottom: 0.5rem;">
                        <?php echo htmlspecialchars($c['description']); ?>
                    </div>
                    <div style="align-self: flex-end; font-size: 0.95rem; margin-bottom: 0.5rem;">
                        <?php echo htmlspecialchars($c['date']); ?>
                    </div>
                    <h2><?php echo htmlspecialchars($c['title']); ?></h2>
                    <div class="meta" style="align-self: flex-end; text-align: right;">
                        <?php echo htmlspecialchars($c['meta']); ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </main>
    <?php require __DIR__ . '/partials/legal_footer.php'; ?>
</body>
</html>
