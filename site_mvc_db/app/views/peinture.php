<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php echo htmlspecialchars($pageDescription ?? "Portfolio artistique d'Annie Roger Chamoulaud."); ?>">
	<meta name="author" content="Jonas Vivier">
	<title>Peintures</title>
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
			display: grid;
			align-content: space-between;
			gap: 1rem;
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
		.hover-info__top,
		.hover-info__bottom {
			display: flex;
			justify-content: space-between;
			gap: 1rem;
			font-size: 0.82rem;
			line-height: 1.2;
			text-transform: uppercase;
		}
		.hover-info__top {
			align-items: flex-start;
		}
		.hover-info__bottom {
			display: grid;
			gap: 0.9rem;
			align-items: end;
		}
		.hover-info__title {
			max-width: 100%;
			max-height: 5.2rem;
			overflow: hidden;
			font-size: clamp(1.05rem, 1.35vw, 1.6rem);
			font-weight: 400;
			line-height: 1.05;
			text-transform: none;
		}
		.hover-info__meta {
			max-width: 100%;
			color: rgba(255, 255, 255, 0.78);
			text-align: left;
			text-transform: uppercase;
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
			box-sizing: border-box;
			display: grid;
			place-items: center;
			width: min(86vw, 1180px);
			height: min(70vh, 780px);
			background: transparent;
			overflow: hidden;
		}
		.lightbox-frame img {
			width: 100%;
			height: 100%;
			object-fit: contain;
			display: block;
		}
		.lightbox-band {
			box-sizing: border-box;
			display: flex;
			justify-content: space-between;
			align-items: flex-start;
			gap: 2.5rem;
			width: min(86vw, 1180px);
			background: transparent;
			color: #fff;
			border: 0;
			padding: 0.85rem 0;
			font-size: 0.74rem;
			line-height: 1.3;
			letter-spacing: 0.04em;
			text-transform: uppercase;
		}
		.lightbox-band--top {
			border-bottom: 1px solid rgba(255, 255, 255, 0.14);
		}
		.lightbox-band--bottom {
			border-top: 1px solid rgba(255, 255, 255, 0.14);
			color: rgba(255, 255, 255, 0.58);
		}
		.lightbox-band--top span:first-child {
			max-width: 70%;
			font-size: clamp(1.05rem, 1.65vw, 1.75rem);
			line-height: 1.1;
			letter-spacing: 0;
			text-transform: none;
		}
		.lightbox-band--bottom span:last-child {
			max-width: 70%;
			letter-spacing: 0;
			text-transform: none;
		}
		.lightbox-band span:last-child {
			text-align: right;
			color: rgba(255, 255, 255, 0.5);
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
			.gallery-grid {
				grid-template-columns: repeat(3, minmax(0, 1fr));
				padding-bottom: 2rem;
			}
			.lightbox-frame {
				width: min(100% - 2rem, 760px);
				height: 62vh;
			}
			.lightbox-band {
				width: min(100% - 2rem, 760px);
			}
			.lightbox-band {
				display: grid;
				gap: 0.35rem;
			}
			.lightbox-band span:last-child {
				text-align: left;
			}
			.image-lightbox .lightbox-nav--prev {
				left: 1rem;
			}
			.image-lightbox .lightbox-nav--next {
				right: 1rem;
			}
		}
		@media (max-width: 700px) {
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
			<a href="<?php echo rtrim(app_url(), '/'); ?>/couture">Arts textiles</a>
			<a href="<?php echo rtrim(app_url(), '/'); ?>/expositions">&Eacute;venements</a>
			<a href="<?php echo rtrim(app_url(), '/'); ?>/biographie">Biographie</a>
			<a href="<?php echo rtrim(app_url(), '/'); ?>/contact">Contact</a>
		</div>
	</nav>
	<main class="paintings-layout">
		<aside class="paintings-filter">
			<h1>Barre de recherche</h1>
			<form class="filter-form" method="get" action="<?php echo rtrim(app_url(), '/'); ?>/peinture">
				<label>
					Recherche
					<input type="text" name="search" placeholder="Nom de la peinture" value="<?php echo htmlspecialchars($search ?? ''); ?>">
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
					<a href="<?php echo rtrim(app_url(), '/'); ?>/peinture">Réinitialiser</a>
				</div>
			</form>
		</aside>
		<section class="gallery-grid" aria-label="Grille des peintures">
			<?php if (empty($peintures)): ?>
			<p class="gallery-empty">Aucune peinture trouvée.</p>
			<?php else: ?>
			<?php
			$hoverColors = ['#ffc400', '#00a6ff', '#ff4d6d', '#32c46c', '#8f5cff', '#ff7a00'];
			?>
			<?php foreach ($peintures as $index => $p): ?>
			<?php $thumbnail = mediaThumbnailUrl($p['image_path'] ?? '', $p['image'] ?? ''); ?>
			<div class="gallery-card" style="--hover-color: <?php echo $hoverColors[$index % count($hoverColors)]; ?>;">
				<img
					class="gallery-image"
					src="<?php echo htmlspecialchars($thumbnail); ?>"
					alt="<?php echo htmlspecialchars($p['title']); ?>"
					loading="lazy"
					decoding="async"
					data-full-src="<?php echo htmlspecialchars($p['image']); ?>"
					data-title="<?php echo htmlspecialchars($p['title']); ?>"
					data-meta="<?php echo htmlspecialchars($p['meta']); ?>"
					data-date="<?php echo htmlspecialchars($p['date']); ?>"
					data-description="<?php echo htmlspecialchars($p['description']); ?>"
				>
				<div class="hover-info">
					<div class="hover-info__top">
						<span><?php echo htmlspecialchars($p['title']); ?></span>
						<span><?php echo htmlspecialchars($p['date']); ?></span>
					</div>
					<div class="hover-info__bottom">
						<strong class="hover-info__title"><?php echo htmlspecialchars($p['description']); ?></strong>
						<span class="hover-info__meta"><?php echo htmlspecialchars($p['meta']); ?></span>
					</div>
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
		<div class="lightbox-band lightbox-band--top">
			<span data-lightbox-title></span>
			<span data-lightbox-meta></span>
		</div>
		<div class="lightbox-frame">
			<img src="" alt="">
		</div>
		<div class="lightbox-band lightbox-band--bottom">
			<span data-lightbox-date></span>
			<span data-lightbox-description></span>
		</div>
	</div>
	<script>
		const lightbox = document.getElementById('image-lightbox');
		const lightboxImage = lightbox.querySelector('img');
		const galleryImages = Array.from(document.querySelectorAll('.gallery-image'));
		let currentLightboxIndex = 0;
		const lightboxTitle = lightbox.querySelector('[data-lightbox-title]');
		const lightboxMeta = lightbox.querySelector('[data-lightbox-meta]');
		const lightboxDate = lightbox.querySelector('[data-lightbox-date]');
		const lightboxDescription = lightbox.querySelector('[data-lightbox-description]');
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
			lightbox.style.setProperty('--lightbox-color', image.closest('.gallery-card').style.getPropertyValue('--hover-color'));
			lightboxTitle.textContent = image.dataset.title || '';
			lightboxMeta.textContent = image.dataset.meta || '';
			lightboxDate.textContent = image.dataset.date || '';
			lightboxDescription.textContent = image.dataset.description || '';
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
