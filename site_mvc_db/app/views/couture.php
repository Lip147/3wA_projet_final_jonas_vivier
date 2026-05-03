<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Coutures</title>
    <link rel="stylesheet" href="/site_mvc_db/public/styles/style.css">
    <style>
        .paintings-layout {
            box-sizing: border-box;
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
            box-sizing: border-box;
            width: 100%;
            min-height: 44px;
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
            box-sizing: border-box;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
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
            align-content: start;
            box-sizing: border-box;
            padding-bottom: 2rem;
            background: #000;
        }
        .gallery-card {
            position: relative;
            overflow: visible;
            border-radius: 8px;
            cursor: pointer;
            aspect-ratio: 1 / 1;
            background: #111;
        }
        .gallery-card:hover {
            z-index: 50;
        }
        .gallery-card img {
            position: relative;
            z-index: 4;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: 8px;
            transition: filter 0.3s;
        }
        .gallery-card .hover-info {
            position: absolute;
            inset: -5rem -1.6rem -8.5rem;
            background: var(--hover-color, #ffc400);
            color: #fff;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
            z-index: 2;
        }
        .gallery-card:hover .hover-info {
            opacity: 1;
        }
        .gallery-card:hover img {
            filter: none;
        }
        .hover-info__top,
        .hover-info__bottom {
            position: absolute;
            left: 1rem;
            right: 1rem;
            z-index: 5;
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            font-size: 0.95rem;
            line-height: 1.2;
        }
        .hover-info__top {
            top: 2.4rem;
            align-items: flex-start;
        }
        .hover-info__bottom {
            bottom: 2.6rem;
            align-items: flex-end;
        }
        .hover-info__title {
            max-width: 58%;
            max-height: 4.8rem;
            overflow: hidden;
            font-size: clamp(0.95rem, 1.1vw, 1.15rem);
            line-height: 1.15;
        }
        .hover-info__meta {
            max-width: 38%;
            text-align: right;
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
                padding-bottom: 2rem;
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
            <a href="/site_mvc_db/public/biographie">Biographie</a>
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
            <?php
            $hoverColors = ['#ffc400', '#00a6ff', '#ff4d6d', '#32c46c', '#8f5cff', '#ff7a00'];
            ?>
            <?php foreach ($coutures as $index => $c): ?>
            <div class="gallery-card" style="--hover-color: <?php echo $hoverColors[$index % count($hoverColors)]; ?>;">
                <img src="<?php echo htmlspecialchars($c['image']); ?>" alt="<?php echo htmlspecialchars($c['title']); ?>">
                <div class="hover-info">
                    <div class="hover-info__top">
                        <span><?php echo htmlspecialchars($c['title']); ?></span>
                        <span><?php echo htmlspecialchars($c['date']); ?></span>
                    </div>
                    <div class="hover-info__bottom">
                        <strong class="hover-info__title"><?php echo htmlspecialchars($c['description']); ?></strong>
                        <span class="hover-info__meta"><?php echo htmlspecialchars($c['meta']); ?></span>
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
