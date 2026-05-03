<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>&Eacute;v&eacute;nements</title>
    <link rel="stylesheet" href="/site_mvc_db/public/styles/style.css">
    <style>
        .events-page {
            background: #000;
            color: #fff;
            min-height: calc(100vh - 8rem);
            padding: 5rem 0 6rem;
        }

        .events-header,
        .events-list {
            width: min(100% - 3rem, 920px);
            margin: 0 auto;
        }

        .events-header {
            margin-bottom: 2.5rem;
        }

        .events-header h1 {
            margin: 0;
            color: #fff;
            font-size: clamp(2.6rem, 6vw, 5rem);
            font-weight: 400;
            line-height: 0.95;
        }

        .events-list {
            display: grid;
            gap: 2rem;
        }

        .event-card {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 210px;
            gap: 3rem;
            align-items: center;
            min-height: 210px;
            border: 4px solid #fff;
            background: #000;
            padding: 1.5rem 2rem;
        }

        .event-card--image-left {
            grid-template-columns: 210px minmax(0, 1fr);
        }

        .event-card--image-left .event-media {
            order: 1;
        }

        .event-card--image-left .event-content {
            order: 2;
            align-items: flex-end;
            text-align: right;
        }

        .event-content {
            display: grid;
            gap: 1rem;
            align-items: start;
        }

        .event-title,
        .event-date,
        .event-description,
        .event-meta {
            border: 4px solid #fff;
            background: #000;
            color: #fff;
        }

        .event-title {
            display: inline-flex;
            width: fit-content;
            max-width: 100%;
            margin: 0;
            padding: 0.1rem 1.6rem;
            font-size: clamp(1.35rem, 2vw, 1.75rem);
            font-weight: 400;
            line-height: 1.2;
        }

        .event-date {
            display: inline-flex;
            width: fit-content;
            max-width: 100%;
            padding: 0.1rem 0.45rem;
            font-size: 1.25rem;
            line-height: 1.2;
        }

        .event-description {
            box-sizing: border-box;
            width: min(100%, 470px);
            min-height: 86px;
            padding: 1.2rem;
            font-size: 1.1rem;
            line-height: 1.45;
        }

        .event-description p {
            margin: 0;
        }

        .event-meta {
            display: inline-flex;
            width: fit-content;
            max-width: 100%;
            padding: 0.15rem 0.6rem;
            color: #fff;
            font-size: 0.95rem;
        }

        .event-media {
            align-self: stretch;
            min-height: 170px;
            border: 4px solid #fff;
            overflow: hidden;
        }

        .event-media img {
            display: block;
            width: 100%;
            height: 100%;
            min-height: 170px;
            object-fit: cover;
        }

        .event-media-placeholder {
            display: grid;
            place-items: center;
            height: 100%;
            min-height: 170px;
            color: #fff;
            font-size: 1.4rem;
        }

        .events-empty {
            margin: 0;
            border: 4px solid #fff;
            background: #000;
            color: #fff;
            padding: 2rem;
            text-align: center;
        }

        @media (max-width: 760px) {
            .events-page {
                padding: 3rem 0 4rem;
            }

            .event-card,
            .event-card--image-left {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                padding: 1.2rem;
            }

            .event-card--image-left .event-media,
            .event-card--image-left .event-content {
                order: initial;
            }

            .event-card--image-left .event-content {
                align-items: start;
                text-align: left;
            }

            .event-media {
                min-height: 220px;
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
            <a href="/site_mvc_db/public/couture">Coutures</a>
            <a class="is-active" href="/site_mvc_db/public/expositions">&Eacute;v&eacute;nements</a>
            <a href="/site_mvc_db/public/biographie">Biographie</a>
            <a href="/site_mvc_db/public/contact">Contact</a>
        </div>
    </nav>
    <main class="events-page">
        <header class="events-header">
            <h1>&Eacute;v&eacute;nements</h1>
        </header>

        <section class="events-list" aria-label="Liste des &eacute;v&eacute;nements">
            <?php if (empty($evenements)): ?>
            <p class="events-empty">Aucun &eacute;v&eacute;nement enregistr&eacute; pour le moment.</p>
            <?php else: ?>
            <?php foreach ($evenements as $index => $event): ?>
            <?php $isImageLeft = $index % 2 === 1; ?>
            <article class="event-card <?php echo $isImageLeft ? 'event-card--image-left' : 'event-card--image-right'; ?>">
                <div class="event-content">
                    <h2 class="event-title"><?php echo htmlspecialchars($event['title']); ?></h2>

                    <?php if (!empty($event['date'])): ?>
                    <time class="event-date"><?php echo htmlspecialchars($event['date']); ?></time>
                    <?php endif; ?>

                    <?php if (!empty($event['description'])): ?>
                    <div class="event-description">
                        <p><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($event['meta'])): ?>
                    <div class="event-meta"><?php echo htmlspecialchars($event['meta']); ?></div>
                    <?php endif; ?>
                </div>

                <div class="event-media">
                    <?php if (!empty($event['image'])): ?>
                    <img src="<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>">
                    <?php else: ?>
                    <div class="event-media-placeholder">Photo</div>
                    <?php endif; ?>
                </div>
            </article>
            <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </main>
    <?php require __DIR__ . '/partials/legal_footer.php'; ?>
</body>
</html>
