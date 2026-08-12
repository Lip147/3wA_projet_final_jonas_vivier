<style>
    .site-footer {
        box-sizing: border-box;
        width: 100%;
        margin-top: auto;
        padding: 2.5rem max(1.5rem, calc((100% - 1440px) / 2));
        border-top: 1px solid #333;
        background: #050505;
        color: #f5f5f5;
        font-family: Arial, sans-serif;
    }

    .site-footer__inner {
        display: grid;
        grid-template-columns: minmax(0, 1.4fr) minmax(240px, 0.6fr);
        gap: 2rem;
    }

    .site-footer h2,
    .site-footer h3 {
        margin: 0 0 0.85rem;
        font-size: 1rem;
        font-weight: 700;
    }

    .site-footer p,
    .site-footer li {
        margin: 0;
        color: #cfcfcf;
        font-size: 0.92rem;
        line-height: 1.6;
    }

    .site-footer ul {
        display: grid;
        gap: 0.45rem;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .site-footer a {
        color: #fff;
        text-underline-offset: 0.25rem;
    }

    .site-footer__legal {
        display: grid;
        gap: 1rem;
    }

    .site-footer__contact {
        align-self: start;
        display: grid;
        gap: 0.8rem;
    }

    .site-footer__button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: fit-content;
        min-height: 42px;
        padding: 0 1rem;
        border: 1px solid #fff;
        text-decoration: none;
    }

    .site-footer__button:hover {
        background: #fff;
        color: #000;
    }

    @media (max-width: 760px) {
        .site-footer__inner {
            grid-template-columns: 1fr;
        }
    }
</style>
<footer class="site-footer">
    <div class="site-footer__inner">
        <section class="site-footer__legal" aria-labelledby="footer-legal-title">
            <h2 id="footer-legal-title">Mentions légales et protection des données</h2>
            <ul>
                <li>Éditeur du site : Annie Roger-Chamoulaud, informations légales complètes à compléter.</li>
                <li>Les contenus, textes et images présentés sur ce site sont protégés par le droit d’auteur.</li>
                <li>Les données transmises via le formulaire de contact sont utilisées uniquement pour répondre à votre demande.</li>
                <li>Conformément au RGPD et à la loi Informatique et Libertés, vous pouvez demander l’accès, la rectification ou la suppression de vos données.</li>
                <li>Aucun cookie publicitaire ou traceur de mesure d’audience n’est déposé sans consentement préalable.</li>
            </ul>
        </section>
        <section class="site-footer__contact" aria-labelledby="footer-contact-title">
            <h3 id="footer-contact-title">Me contacter</h3>
            <p>Pour toute demande concernant les œuvres, les expositions ou vos données personnelles, utilisez la page de contact.</p>
            <a class="site-footer__button" href="<?php echo rtrim(app_url(), '/'); ?>/contact">Aller au contact</a>
        </section>
    </div>
</footer>
