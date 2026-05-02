<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Peintures</title>
	<link rel="stylesheet" href="/site_mvc_db/public/styles/style.css">
	<style>
		.gallery-grid {
			display: grid;
			grid-template-columns: repeat(4, 1fr);
			gap: 2rem;
			padding: 3rem;
			background: #000;
		}
		.gallery-card {
			position: relative;
			overflow: hidden;
			border-radius: 8px;
			box-shadow: 0 2px 16px rgba(0,0,0,0.5);
			cursor: pointer;
			min-height: 350px;
			background: #111;
		}
		.gallery-card img {
			width: 100%;
			height: 350px;
			object-fit: cover;
			display: block;
			transition: filter 0.3s;
		}
		.gallery-card .hover-info {
			position: absolute;
			top: 0; left: 0; right: 0; bottom: 0;
			background: #ffc400;
			color: #222;
			opacity: 0;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			padding: 2rem 1rem 1rem 1rem;
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
			margin: 0 0 1rem 0;
			font-size: 1.5rem;
		}
		.hover-info p {
			margin: 0.2rem 0;
			font-size: 1rem;
		}
		.hover-info .meta {
			margin-top: 1.5rem;
			font-size: 0.95rem;
			color: #444;
		}
	</style>
</head>
<body class="gallery-page">
	<nav class="gallery-navbar">
		<a class="gallery-logo" href="/site_mvc_db/public/home" aria-label="Accueil"></a>
		<div class="gallery-navlinks">
			<a class="is-active" href="/site_mvc_db/public/peinture">Peintures</a>
			<a href="/site_mvc_db/public/couture">Coutures</a>
			<a href="/site_mvc_db/public/expositions">&Eacute;venements</a>
			<a href="/site_mvc_db/public/contact">Contact</a>
		</div>
	</nav>
	<div style="background:#000;padding:2rem 3rem;border-bottom:1px solid #333;">
		<div style="max-width:1200px;margin:0 auto;display:flex;gap:1rem;flex-wrap:wrap;">
			<form method="get" action="/site_mvc_db/public/peinture" style="display:flex;gap:1rem;align-items:center;flex:1;">
				<input type="text" name="search" placeholder="Rechercher par nom..." value="<?php echo htmlspecialchars($search ?? ''); ?>" style="padding:0.5rem;border:1px solid #555;background:#222;color:#fff;border-radius:4px;flex:1;max-width:300px;">
				<button type="submit" style="padding:0.5rem 1rem;background:#ffc400;color:#222;border:none;border-radius:4px;cursor:pointer;font-weight:bold;">Rechercher</button>
			</form>
			<form method="get" action="/site_mvc_db/public/peinture" style="display:flex;gap:1rem;align-items:center;">
				<select name="category" style="padding:0.5rem;border:1px solid #555;background:#222;color:#fff;border-radius:4px;">
					<option value="">Toutes les catégories</option>
					<?php if (!empty($categories)): ?>
					<?php foreach ($categories as $cat): ?>
					<option value="<?php echo htmlspecialchars($cat['meta']); ?>" <?php echo (($category ?? '') === $cat['meta']) ? 'selected' : ''; ?>>
						<?php echo htmlspecialchars($cat['meta']); ?>
					</option>
					<?php endforeach; ?>
					<?php endif; ?>
				</select>
				<button type="submit" style="padding:0.5rem 1rem;background:#ffc400;color:#222;border:none;border-radius:4px;cursor:pointer;font-weight:bold;">Filtrer</button>
			</form>
		</div>
	</div>
	<div class="gallery-grid">
		<?php if (empty($peintures)): ?>
		<p style="color:#666;text-align:center;">Aucune peinture trouvée.</p>
		<?php else: ?>
		<?php foreach ($peintures as $p): ?>
		<div class="gallery-card">
			<img src="<?php echo $p['image']; ?>" alt="<?php echo htmlspecialchars($p['title']); ?>">
			<div class="hover-info">
				<div style="align-self: flex-start; font-size: 1rem; margin-bottom: 0.5rem;">
					<?php echo htmlspecialchars($p['description']); ?>
				</div>
				<div style="align-self: flex-end; font-size: 0.95rem; margin-bottom: 0.5rem;">
					<?php echo htmlspecialchars($p['date']); ?>
				</div>
				<h2><?php echo htmlspecialchars($p['title']); ?></h2>
				<div class="meta" style="align-self: flex-end; text-align: right;">
					<?php echo htmlspecialchars($p['meta']); ?>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
		<?php endif; ?>
	</div>
</body>
</html>
