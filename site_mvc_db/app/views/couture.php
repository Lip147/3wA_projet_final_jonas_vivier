<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription ?? "Portfolio artistique d'Annie Roger-Chamoulaud."); ?>">
    <meta name="author" content="Jonas Vivier">
    <title>Arts textiles</title>
    <link rel="stylesheet" href="<?php echo rtrim(app_url(), '/'); ?>/styles/style.css?v=<?php echo filemtime(__DIR__ . '/../../public/styles/style.css'); ?>">
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
            --filter-sticky-offset: calc(8.25rem + 47px + 1.75rem);
            align-self: start;
            position: sticky;
            top: var(--filter-sticky-offset);
            z-index: 5;
            min-height: 605px;
            border-left: 1px solid rgba(255, 255, 255, 0.42);
            background: #000;
            color: #fff;
            padding: 2.8rem 1.8rem 2.2rem 2rem;
        }
        .paintings-filter h1 {
            margin: 0 0 2.4rem;
            padding-bottom: 1.4rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.38);
            font-size: 1.65rem;
            font-weight: 400;
            line-height: 1.2;
        }
        .filter-form {
            display: grid;
            gap: 2rem;
        }
        .filter-field {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            align-items: start;
        }
        .filter-field__body {
            display: grid;
            gap: 0.55rem;
            min-width: 0;
        }
        .filter-field--search {
            row-gap: 0.75rem;
        }
        .filter-field--search .filter-field__body {
            display: contents;
        }
        .filter-field--search .filter-label {
            grid-column: 1;
        }
        .filter-field--search input {
            grid-column: 1 / -1;
            min-height: 54px;
            padding: 0.75rem 0.8rem;
            transition: background-color 180ms ease, color 180ms ease, border-color 180ms ease;
        }
        .filter-form .filter-field--search input:focus {
            border-bottom-color: #fff;
            outline: 0;
        }
        .filter-field--search:hover input,
        .filter-field--search:focus-within input,
        .filter-field--search.is-filled input {
            background: #fff;
            color: #000;
        }
        .filter-field--search:hover input::placeholder,
        .filter-field--search:focus-within input::placeholder,
        .filter-field--search.is-filled input::placeholder {
            color: rgba(0, 0, 0, 0.58);
        }
        .filter-field--select {
            position: relative;
            row-gap: 0.75rem;
        }
        .filter-field--select::after {
            content: "";
            position: absolute;
            right: 0.2rem;
            bottom: 1.25rem;
            width: 0.4rem;
            height: 0.4rem;
            border-right: 1px solid rgba(255, 255, 255, 0.72);
            border-bottom: 1px solid rgba(255, 255, 255, 0.72);
            pointer-events: none;
            transform: rotate(45deg);
            transition: border-color 180ms ease;
        }
        .filter-field--select:hover::after,
        .filter-field--select:focus-within::after,
        .filter-field--select.is-filled::after {
            border-color: #000;
        }
        .filter-field--select .filter-field__body {
            display: contents;
        }
        .filter-field--select .filter-label {
            grid-column: 1;
        }
        .filter-field--select select {
            grid-column: 1 / -1;
            min-height: 54px;
            border: 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.58);
            padding: 0.75rem 2rem 0.75rem 0.8rem;
            -webkit-appearance: none;
            appearance: none;
            transition: background-color 180ms ease, color 180ms ease, border-color 180ms ease;
        }
        .filter-field--select select:hover {
            border-bottom-color: #fff;
        }
        .filter-form .filter-field--select select:focus {
            border-bottom-color: #fff;
            outline: 0;
        }
        .filter-field--select:hover select,
        .filter-field--select:focus-within select,
        .filter-field--select.is-filled select {
            background: #fff;
            color: #000;
        }
        .filter-label {
            color: rgba(255, 255, 255, 0.68);
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        .filter-form input,
        .filter-form select {
            box-sizing: border-box;
            width: 100%;
            min-height: 44px;
            border: 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.48);
            border-radius: 0;
            background: #000;
            color: #fff;
            padding: 0.55rem 0;
            font: inherit;
        }
        .filter-form input::placeholder {
            color: rgba(255, 255, 255, 0.48);
        }
        .filter-form select option {
            background: #000;
            color: #fff;
        }
        .filter-form input:focus,
        .filter-form select:focus {
            border-color: #fff;
            outline: 1px solid rgba(255, 255, 255, 0.72);
            outline-offset: 4px;
        }
        .filter-actions {
            display: grid;
            gap: 1rem;
            margin-top: 0.75rem;
        }
        .filter-actions button,
        .filter-actions a {
            box-sizing: border-box;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-height: 44px;
            border: 1px solid #fff;
            border-radius: 0;
            background: #fff;
            color: #000;
            text-decoration: none;
            font: inherit;
            cursor: pointer;
            transition: background-color 180ms ease, color 180ms ease;
        }
        .filter-actions button:hover,
        .filter-actions button:focus-visible {
            background: #000;
            color: #fff;
        }
        .filter-actions a {
            justify-self: center;
            width: auto;
            min-height: auto;
            border: 0;
            background: transparent;
            color: rgba(255, 255, 255, 0.62);
            font-size: 0.84rem;
            text-decoration: underline;
            text-decoration-color: transparent;
            text-underline-offset: 0.3rem;
        }
        .filter-actions a:hover,
        .filter-actions a:focus-visible {
            color: #fff;
            text-decoration-color: currentColor;
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 1px;
            align-content: start;
            box-sizing: border-box;
            padding-bottom: 2rem;
            background: #000;
        }
        .gallery-card {
            position: relative;
            overflow: hidden;
            border-radius: 0;
            cursor: pointer;
            aspect-ratio: 4 / 5;
            background: #050505;
            isolation: isolate;
        }
        .gallery-card:hover {
            z-index: 10;
        }
        .gallery-card img {
            position: relative;
            z-index: 1;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: 0;
            filter: grayscale(18%) contrast(1.05);
            transform: scale(1);
            transition: filter 0.45s ease, opacity 0.45s ease, transform 0.6s ease;
        }
        .gallery-card .hover-info {
            position: absolute;
            inset: 0;
            display: block;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.72), rgba(0, 0, 0, 0.1) 38%, rgba(0, 0, 0, 0.88));
            color: #fff;
            opacity: 0;
            pointer-events: none;
            padding: 1rem;
            transition: opacity 0.28s ease;
            z-index: 3;
        }
        .gallery-card:hover .hover-info {
            opacity: 1;
        }
        .gallery-card:hover img {
            filter: grayscale(0%) contrast(1.1) brightness(0.58);
            transform: scale(1.045);
        }
        .hover-info__list {
            display: grid;
            gap: 0.9rem;
            margin: 0;
        }
        .hover-info__item {
            display: grid;
            gap: 0.2rem;
        }
        .hover-info__item dt {
            margin: 0;
            color: rgba(255, 255, 255, 0.62);
            font-size: 0.68rem;
            line-height: 1.2;
            text-transform: uppercase;
        }
        .hover-info__item dd {
            margin: 0;
            font-size: 0.88rem;
            line-height: 1.25;
        }
        .hover-info__item:first-child dd {
            font-size: clamp(1.05rem, 1.35vw, 1.6rem);
            line-height: 1.05;
        }
        .gallery-empty {
            grid-column: 1 / -1;
            color: #888;
            text-align: center;
            margin: 4rem 0;
        }
        .image-lightbox {
            position: fixed;
            inset: 0;
            z-index: 100;
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            background: rgba(0, 0, 0, 0.97);
            padding: clamp(1rem, 3vw, 2.5rem);
        }
        .image-lightbox.is-open {
            display: flex;
        }
        .lightbox-frame {
            display: flex;
            align-items: center;
            justify-content: center;
            max-width: min(86vw, 1180px);
            max-height: 86vh;
            background: transparent;
        }
        .lightbox-frame img {
            width: auto;
            height: auto;
            max-width: min(86vw, 1180px);
            max-height: 86vh;
            display: block;
        }
        .image-lightbox button {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            width: 40px;
            height: 40px;
            border: 0;
            background: transparent;
            color: #fff;
            font-size: 1.35rem;
            line-height: 1;
            cursor: pointer;
            opacity: 0.62;
            transition: opacity 0.2s ease, transform 0.2s ease;
        }
        .image-lightbox button:hover,
        .image-lightbox button:focus-visible {
            background: transparent;
            color: #fff;
            opacity: 1;
            transform: scale(1.05);
        }
        .image-lightbox .lightbox-nav {
            top: 50%;
            right: auto;
            transform: translateY(-50%);
            width: 44px;
            height: 64px;
            font-size: 2.35rem;
        }
        .image-lightbox .lightbox-nav--prev {
            left: max(1rem, calc((100vw - min(86vw, 1180px)) / 2 - 4.5rem));
        }
        .image-lightbox .lightbox-nav--next {
            right: max(1rem, calc((100vw - min(86vw, 1180px)) / 2 - 4.5rem));
        }
        @media (max-width: 1280px) {
            .gallery-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
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
            .filter-form {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
            .filter-actions {
                grid-column: 1 / -1;
                grid-template-columns: minmax(180px, 260px) auto;
                align-items: center;
                justify-content: start;
            }
            .gallery-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                padding-bottom: 2rem;
            }
            .lightbox-frame {
                max-width: calc(100vw - 4rem);
                max-height: 82vh;
            }
            .lightbox-frame img {
                max-width: calc(100vw - 4rem);
                max-height: 82vh;
            }
            .image-lightbox .lightbox-nav--prev {
                left: 1rem;
            }
            .image-lightbox .lightbox-nav--next {
                right: 1rem;
            }
        }
        @media (max-width: 700px) {
            .filter-form {
                grid-template-columns: 1fr;
            }
            .filter-actions {
                grid-column: auto;
                grid-template-columns: 1fr;
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
        <a class="gallery-logo" href="<?php echo rtrim(app_url(), '/'); ?>/home" aria-label="Accueil"></a>
        <div class="gallery-navlinks">
            <a href="<?php echo rtrim(app_url(), '/'); ?>/home">Accueil</a>
            <a href="<?php echo rtrim(app_url(), '/'); ?>/peinture">Peintures</a>
            <a href="<?php echo rtrim(app_url(), '/'); ?>/expositions">Événements</a>
            <a href="<?php echo rtrim(app_url(), '/'); ?>/biographie">Biographie</a>
            <a href="<?php echo rtrim(app_url(), '/'); ?>/contact">Contact</a>
        </div>
    </nav>
    <main class="paintings-layout">
        <aside class="paintings-filter">
            <h1>Filtrer les arts textiles</h1>
            <form class="filter-form" method="get" action="<?php echo rtrim(app_url(), '/'); ?>/couture">
                <label class="filter-field filter-field--search">
                    <span class="filter-field__body">
                        <span class="filter-label">Recherche</span>
                        <input type="text" name="search" placeholder="Nom du textile" value="<?php echo htmlspecialchars($search ?? ''); ?>">
                    </span>
                </label>
                <label class="filter-field filter-field--select">
                    <span class="filter-field__body">
                        <span class="filter-label">Catégorie</span>
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
                    </span>
                </label>
                <label class="filter-field filter-field--select">
                    <span class="filter-field__body">
                        <span class="filter-label">Technique utilisée</span>
                        <select name="technique">
                        <option value="">Toutes les techniques</option>
                        <?php foreach (($techniques ?? []) as $techniqueOption): ?>
                        <option value="<?php echo htmlspecialchars($techniqueOption); ?>" <?php echo (($technique ?? '') === $techniqueOption) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($techniqueOption); ?>
                        </option>
                        <?php endforeach; ?>
                        </select>
                    </span>
                </label>
                <div class="filter-actions">
                    <button type="submit">Filtrer</button>
                    <a href="<?php echo rtrim(app_url(), '/'); ?>/couture">Réinitialiser</a>
                </div>
            </form>
        </aside>
        <section class="gallery-grid" aria-label="Grille des arts textiles">
            <?php if (empty($coutures)): ?>
            <p class="gallery-empty">Aucun textile trouvé.</p>
            <?php else: ?>
            <?php
            $hoverColors = ['#ffc400', '#00a6ff', '#ff4d6d', '#32c46c', '#8f5cff', '#ff7a00'];
            ?>
            <?php foreach ($coutures as $index => $c): ?>
            <?php $thumbnail = mediaThumbnailUrl($c['image_path'] ?? '', $c['image'] ?? ''); ?>
            <div class="gallery-card" style="--hover-color: <?php echo $hoverColors[$index % count($hoverColors)]; ?>;">
                <img
                    class="gallery-image"
                    src="<?php echo htmlspecialchars($thumbnail); ?>"
                    alt="<?php echo htmlspecialchars($c['title']); ?>"
                    loading="lazy"
                    decoding="async"
                    data-full-src="<?php echo htmlspecialchars($c['image']); ?>"
                    data-title="<?php echo htmlspecialchars($c['title']); ?>"
                    data-meta="<?php echo htmlspecialchars($c['meta']); ?>"
                    data-date="<?php echo htmlspecialchars($c['date']); ?>"
                    data-description="<?php echo htmlspecialchars($c['description']); ?>"
                >
                <div class="hover-info">
                    <dl class="hover-info__list">
                        <div class="hover-info__item"><dt>Titre</dt><dd><?php echo htmlspecialchars($c['title']); ?></dd></div>
                        <div class="hover-info__item"><dt>Catégorie</dt><dd><?php echo htmlspecialchars($c['meta'] ?: 'À renseigner'); ?></dd></div>
                        <div class="hover-info__item"><dt>Dimensions</dt><dd><?php echo htmlspecialchars($c['dimensions_or_size'] ?: 'À renseigner'); ?></dd></div>
                        <div class="hover-info__item"><dt>Technique utilisée</dt><dd><?php echo htmlspecialchars($c['material'] ?: 'À renseigner'); ?></dd></div>
                    </dl>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </main>
    <div class="image-lightbox" id="image-lightbox" aria-hidden="true">
        <button type="button" aria-label="Fermer">&times;</button>
        <button class="lightbox-nav lightbox-nav--prev" type="button" aria-label="Image précédente">&#8249;</button>
        <button class="lightbox-nav lightbox-nav--next" type="button" aria-label="Image suivante">&#8250;</button>
        <div class="lightbox-frame">
            <img src="" alt="">
        </div>
    </div>
    <script>
        document.querySelectorAll('.filter-form .filter-field').forEach((field) => {
            const control = field.querySelector('input, select');
            const updateFilledState = () => {
                field.classList.toggle('is-filled', control.value.trim() !== '');
            };

            control.addEventListener('input', updateFilledState);
            control.addEventListener('change', updateFilledState);
            updateFilledState();
        });

        const lightbox = document.getElementById('image-lightbox');
        const lightboxImage = lightbox.querySelector('img');
        const galleryImages = Array.from(document.querySelectorAll('.gallery-image'));
        let currentLightboxIndex = 0;
        const closeLightbox = () => {
            lightbox.classList.remove('is-open');
            lightbox.setAttribute('aria-hidden', 'true');
            lightboxImage.src = '';
            lightboxImage.alt = '';
        };
        const showLightboxImage = (index) => {
            currentLightboxIndex = (index + galleryImages.length) % galleryImages.length;
            const image = galleryImages[currentLightboxIndex];
            lightboxImage.src = image.dataset.fullSrc || image.src;
            lightboxImage.alt = image.alt;
        };

        document.querySelectorAll('.gallery-card').forEach((card, index) => {
            card.addEventListener('click', () => {
                showLightboxImage(index);
                lightbox.classList.add('is-open');
                lightbox.setAttribute('aria-hidden', 'false');
            });
        });

        lightbox.addEventListener('click', (event) => {
            if (event.target.classList.contains('lightbox-nav--prev')) {
                showLightboxImage(currentLightboxIndex - 1);
                return;
            }
            if (event.target.classList.contains('lightbox-nav--next')) {
                showLightboxImage(currentLightboxIndex + 1);
                return;
            }
            if (event.target === lightbox || event.target.getAttribute('aria-label') === 'Fermer') {
                closeLightbox();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeLightbox();
            }
            if (!lightbox.classList.contains('is-open')) {
                return;
            }
            if (event.key === 'ArrowLeft') {
                showLightboxImage(currentLightboxIndex - 1);
            }
            if (event.key === 'ArrowRight') {
                showLightboxImage(currentLightboxIndex + 1);
            }
        });
    </script>
    <?php require __DIR__ . '/partials/legal_footer.php'; ?>
</body>
</html>
