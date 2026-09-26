<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription ?? "Portfolio artistique d'Annie Roger-Chamoulaud."); ?>">
    <meta name="author" content="Jonas Vivier">
    <title>&Eacute;v&eacute;nements</title>
    <link rel="stylesheet" href="<?php echo rtrim(app_url(), '/'); ?>/styles/style.css?v=<?php echo filemtime(__DIR__ . '/../../public/styles/style.css'); ?>">
    <style>
        .events-page {
            background: #000;
            color: #fff;
            min-height: calc(100vh - 8rem);
            padding: 5.5rem 0 7rem;
            overflow: hidden;
        }

        .events-header,
        .events-list {
            width: min(100% - 3rem, 1120px);
            margin: 0 auto;
        }

        .events-header {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(240px, 360px);
            gap: 3rem;
            align-items: end;
            margin-bottom: 5rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.38);
        }

        .events-header h1 {
            margin: 0;
            color: #fff;
            font-size: clamp(3.6rem, 9vw, 7.5rem);
            font-weight: 400;
            line-height: 0.82;
        }

        .events-intro {
            margin: 0;
            color: rgba(255, 255, 255, 0.72);
            font-size: 1rem;
            line-height: 1.65;
        }

        .events-list {
            display: grid;
            gap: 5rem;
            position: relative;
        }

        .events-index {
            position: fixed;
            z-index: 5;
            top: 50%;
            left: clamp(1.25rem, 3vw, 3.5rem);
            display: flex;
            flex-direction: column;
            width: min(290px, 22vw);
            height: min(600px, calc(100vh - 14rem));
            transform: translateY(-50%);
        }

        .events-year-nav {
            display: grid;
            grid-template-columns: 36px minmax(0, 1fr) 36px;
            gap: 0.6rem;
            align-items: center;
            flex: 0 0 auto;
            margin-bottom: 2.25rem;
        }

        .events-year-list {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.5rem;
            min-width: 0;
        }

        .events-year-link {
            padding: 0.55rem 0.25rem;
            border-bottom: 1px solid transparent;
            color: rgba(255, 255, 255, 0.55);
            font-size: 0.92rem;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            transition: color 180ms ease, border-color 180ms ease;
        }

        .events-year-link:hover,
        .events-year-link:focus-visible,
        .events-year-link.is-selected {
            border-color: currentColor;
            color: #fff;
        }

        .events-year-link:focus-visible,
        .events-year-arrow:focus-visible {
            outline: 1px solid rgba(255, 255, 255, 0.7);
            outline-offset: 3px;
        }

        .events-year-arrow {
            display: grid;
            width: 36px;
            height: 36px;
            padding: 0;
            place-items: center;
            border: 0;
            border-radius: 0;
            background: transparent;
            color: #fff;
            font: inherit;
            cursor: pointer;
            transition: opacity 180ms ease;
        }

        .events-year-arrow:hover:not(:disabled) {
            opacity: 0.7;
        }

        .events-year-arrow:disabled {
            opacity: 0.22;
            cursor: default;
        }

        .events-index-list {
            position: absolute;
            top: 50%;
            left: 0;
            display: grid;
            gap: 2.2rem;
            width: 100%;
            max-height: min(420px, calc(100vh - 16rem));
            margin: 0 0 0 0.45rem;
            padding: 0.35rem 0 0.35rem 1.45rem;
            border-left: 1px solid rgba(255, 255, 255, 0.48);
            list-style: none;
            min-height: 0;
            overflow-y: auto;
            transform: translateY(-50%);
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
        }

        .events-index-item {
            position: relative;
            min-width: 0;
        }

        .events-index-item::before {
            content: "";
            position: absolute;
            top: 0.48rem;
            left: calc(-1.45rem - 5.5px);
            width: 10px;
            height: 10px;
            border: 1px solid #000;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.55);
            box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.12);
            transition: background-color 180ms ease, box-shadow 180ms ease, transform 180ms ease;
        }

        .events-index-item.is-active::before {
            background: #fff;
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.18);
            transform: scale(1.15);
        }

        .events-index-link {
            display: block;
            width: fit-content;
            max-width: 100%;
            color: rgba(255, 255, 255, 0.62);
            font-size: 0.96rem;
            font-weight: 700;
            line-height: 1.4;
            text-decoration: underline;
            text-decoration-color: transparent;
            text-decoration-thickness: 1px;
            text-underline-offset: 0.35rem;
            overflow-wrap: anywhere;
            transition: color 180ms ease, text-decoration-color 180ms ease;
        }

        .events-index-link:hover,
        .events-index-link:focus-visible,
        .events-index-item.is-active .events-index-link {
            color: #fff;
            text-decoration-color: currentColor;
        }

        .events-index-link:focus-visible {
            outline: 1px solid rgba(255, 255, 255, 0.7);
            outline-offset: 0.45rem;
        }

        .events-list::before {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            left: 50%;
            width: 1px;
            background: rgba(255, 255, 255, 0.16);
            transform: translateX(-50%);
        }

        .event-card {
            position: relative;
            display: grid;
            grid-template-columns: minmax(280px, 0.8fr) minmax(0, 1.2fr);
            gap: clamp(2rem, 5vw, 5rem);
            align-items: center;
            background: #000;
            padding: 0;
            scroll-margin-top: 7rem;
        }

        .event-card--image-left {
            grid-template-columns: minmax(0, 1.2fr) minmax(280px, 0.8fr);
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
            gap: 1.1rem;
            align-items: start;
            position: relative;
            z-index: 1;
        }

        .event-number {
            color: rgba(255, 255, 255, 0.45);
            font-size: 0.75rem;
            line-height: 1;
        }

        .event-title {
            max-width: 100%;
            margin: 0;
            color: #fff;
            font-size: clamp(2rem, 4vw, 3.4rem);
            font-weight: 400;
            line-height: 1.05;
        }

        .event-date {
            display: inline-flex;
            width: fit-content;
            max-width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.65);
            padding: 0.45rem 0.75rem;
            color: #fff;
            font-size: 0.88rem;
            line-height: 1.2;
        }

        .event-description {
            width: min(100%, 520px);
            color: rgba(255, 255, 255, 0.76);
            font-size: 1.02rem;
            line-height: 1.7;
        }

        .event-description p {
            margin: 0;
        }

        .event-meta {
            display: inline-flex;
            width: fit-content;
            max-width: 100%;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.28);
            color: rgba(255, 255, 255, 0.58);
            font-size: 0.82rem;
        }

        .event-media {
            position: relative;
            aspect-ratio: 4 / 3;
            border: 1px solid rgba(255, 255, 255, 0.35);
            overflow: hidden;
        }

        .event-media::after {
            content: "";
            position: absolute;
            inset: 0;
            border: 8px solid #000;
            pointer-events: none;
        }

        .event-media img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: saturate(0.78) contrast(1.04);
            transition: transform 600ms ease, filter 600ms ease;
        }

        .event-card:hover .event-media img {
            transform: scale(1.035);
            filter: saturate(1) contrast(1.02);
        }

        .event-media-placeholder {
            display: grid;
            place-items: center;
            height: 100%;
            min-height: 260px;
            color: rgba(255, 255, 255, 0.45);
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        .events-empty {
            margin: 0;
            border: 1px solid rgba(255, 255, 255, 0.35);
            background: #000;
            color: #fff;
            padding: 2rem;
            text-align: center;
        }

        @media (max-width: 1199px) {
            .events-index {
                position: static;
                display: block;
                width: min(100% - 3rem, 1120px);
                height: auto;
                max-height: none;
                margin: -2rem auto 4rem;
                overflow: visible;
                transform: none;
            }

            .events-index-list {
                position: static;
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 1.15rem 2rem;
                width: auto;
                max-height: none;
                overflow: visible;
                transform: none;
            }

            .events-year-nav {
                width: min(100%, 420px);
            }
        }

        @media (max-width: 760px) {
            .events-page {
                padding: 3.5rem 0 5rem;
            }

            .events-header {
                grid-template-columns: 1fr;
                gap: 1.75rem;
                margin-bottom: 3.5rem;
            }

            .events-index {
                margin-top: -1.5rem;
                margin-bottom: 3.5rem;
            }

            .events-index-list {
                grid-template-columns: 1fr;
                gap: 1.25rem;
            }

            .events-header h1 {
                font-size: clamp(3.2rem, 18vw, 5.4rem);
            }

            .events-list {
                gap: 4rem;
            }

            .events-list::before {
                display: none;
            }

            .event-card,
            .event-card--image-left {
                grid-template-columns: 1fr;
                gap: 1.75rem;
            }

            .event-card .event-media,
            .event-card--image-left .event-media {
                order: 1;
            }

            .event-card .event-content,
            .event-card--image-left .event-content {
                order: 2;
            }

            .event-card--image-left .event-content {
                align-items: start;
                text-align: left;
            }

            .event-title {
                font-size: clamp(1.8rem, 9vw, 2.7rem);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .event-media img,
            .events-index-item::before,
            .events-index-link,
            .events-year-link,
            .events-year-arrow {
                transition: none;
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
            <a href="<?php echo rtrim(app_url(), '/'); ?>/couture">Arts textiles</a>
            <a href="<?php echo rtrim(app_url(), '/'); ?>/biographie">Biographie</a>
            <a href="<?php echo rtrim(app_url(), '/'); ?>/contact">Contact</a>
        </div>
    </nav>
    <main class="events-page">
        <header class="events-header">
            <h1>&Eacute;v&eacute;nements</h1>
            <p class="events-intro">Expositions, rencontres et rendez-vous autour du travail d&rsquo;Annie Roger-Chamoulaud.</p>
        </header>

        <?php if (!empty($evenements)): ?>
        <nav class="events-index" aria-label="Navigation des événements">
            <?php
            $selectedYearIndex = array_search($selectedYear, $eventYears, true);
            $yearWindowStart = min(
                max(0, (int)$selectedYearIndex - 1),
                max(0, count($eventYears) - 3)
            );
            ?>
            <div class="events-year-nav" aria-label="Choisir une année">
                <button class="events-year-arrow events-year-arrow--older" type="button" aria-label="Afficher les années plus anciennes" title="Années plus anciennes">&#8592;</button>
                <div class="events-year-list">
                    <?php foreach ($eventYears as $yearIndex => $year): ?>
                    <a class="events-year-link<?php echo $year === $selectedYear ? ' is-selected' : ''; ?>"
                       href="<?php echo rtrim(app_url(), '/'); ?>/expositions?year=<?php echo (int)$year; ?>"
                       data-year-index="<?php echo (int)$yearIndex; ?>"
                       <?php echo ($yearIndex < $yearWindowStart || $yearIndex >= $yearWindowStart + 3) ? 'hidden' : ''; ?>
                       <?php echo $year === $selectedYear ? 'aria-current="page"' : ''; ?>><?php echo (int)$year; ?></a>
                    <?php endforeach; ?>
                </div>
                <button class="events-year-arrow events-year-arrow--newer" type="button" aria-label="Afficher les années plus récentes" title="Années plus récentes">&#8594;</button>
            </div>
            <ol class="events-index-list">
                <?php foreach ($evenements as $index => $event): ?>
                <li class="events-index-item<?php echo $index === 0 ? ' is-active' : ''; ?>">
                    <a class="events-index-link" href="#event-<?php echo (int)$event['id']; ?>"<?php echo $index === 0 ? ' aria-current="true"' : ''; ?>><?php echo htmlspecialchars($event['title']); ?></a>
                </li>
                <?php endforeach; ?>
            </ol>
        </nav>
        <?php endif; ?>

        <section class="events-list" aria-label="Liste des &eacute;v&eacute;nements">
            <?php if (empty($evenements)): ?>
            <p class="events-empty">Aucun &eacute;v&eacute;nement enregistr&eacute; pour le moment.</p>
            <?php else: ?>
            <?php foreach ($evenements as $index => $event): ?>
            <?php $isImageLeft = $index % 2 === 1; ?>
            <article id="event-<?php echo (int)$event['id']; ?>" class="event-card <?php echo $isImageLeft ? 'event-card--image-left' : 'event-card--image-right'; ?>">
                <div class="event-content">
                    <span class="event-number" aria-hidden="true"><?php echo str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT); ?></span>
                    <h2 class="event-title"><?php echo htmlspecialchars($event['title']); ?></h2>

                    <?php if (!empty($event['date'])): ?>
                    <time class="event-date" datetime="<?php echo htmlspecialchars($event['date']); ?>"><?php echo htmlspecialchars(formatEvenementDate($event['date'])); ?></time>
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
    <script>
        const eventCards = document.querySelectorAll('.event-card[id]');
        const eventLinks = document.querySelectorAll('.events-index-link');
        const yearLinks = Array.from(document.querySelectorAll('.events-year-link'));
        const newerYearsButton = document.querySelector('.events-year-arrow--newer');
        const olderYearsButton = document.querySelector('.events-year-arrow--older');

        if (yearLinks.length > 0 && newerYearsButton && olderYearsButton) {
            const selectedYearIndex = yearLinks.findIndex((link) => link.classList.contains('is-selected'));
            const maximumWindowStart = Math.max(0, yearLinks.length - 3);
            let yearWindowStart = Math.min(Math.max(0, selectedYearIndex - 1), maximumWindowStart);

            const renderYearWindow = () => {
                yearLinks.forEach((link, index) => {
                    link.hidden = index < yearWindowStart || index >= yearWindowStart + 3;
                });
                olderYearsButton.disabled = yearWindowStart === 0;
                newerYearsButton.disabled = yearWindowStart === maximumWindowStart;
            };

            olderYearsButton.addEventListener('click', () => {
                yearWindowStart = Math.max(0, yearWindowStart - 1);
                renderYearWindow();
            });

            newerYearsButton.addEventListener('click', () => {
                yearWindowStart = Math.min(maximumWindowStart, yearWindowStart + 1);
                renderYearWindow();
            });

            renderYearWindow();
        }

        if ('IntersectionObserver' in window && eventCards.length > 0) {
            const setActiveEvent = (eventId) => {
                eventLinks.forEach((link) => {
                    const isActive = link.hash === `#${eventId}`;
                    link.parentElement.classList.toggle('is-active', isActive);

                    if (isActive) {
                        link.setAttribute('aria-current', 'true');
                    } else {
                        link.removeAttribute('aria-current');
                    }
                });
            };

            const observer = new IntersectionObserver((entries) => {
                const visibleCard = entries
                    .filter((entry) => entry.isIntersecting)
                    .sort((first, second) => second.intersectionRatio - first.intersectionRatio)[0];

                if (visibleCard) {
                    setActiveEvent(visibleCard.target.id);
                }
            }, {
                rootMargin: '-25% 0px -45% 0px',
                threshold: [0, 0.25, 0.5],
            });

            eventCards.forEach((card) => observer.observe(card));
        }
    </script>
</body>
</html>
