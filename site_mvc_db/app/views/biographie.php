<?php
$pageTitle = 'Biographie';
$activePage = 'biographie';
$bodyClass = 'gallery-page';
require __DIR__ . '/partials/header.php';
?>
<style>
    .biography-layout {
        display: grid;
        grid-template-columns: minmax(0, 0.9fr) minmax(320px, 1.1fr);
        gap: 10rem;
        width: min(100% - 6rem, 1180px);
        margin: 0 auto;
        padding: 3rem 0 6rem;
    }

    .biography-title {
        margin: 0;
        font-size: clamp(3rem, 8vw, 8rem);
        font-weight: 400;
        line-height: 0.95;
    }

    .biography-heading {
        padding-top: 1rem;
    }

    .biography-portrait-placeholder {
        display: grid;
        place-items: center;
        width: min(100%, 320px);
        aspect-ratio: 3 / 4;
        margin-top: 2.5rem;
        border: 1px dashed #6f6f6f;
        color: #8f8f8f;
        font-size: 1rem;
        text-transform: uppercase;
    }

    .biography-text {
        display: grid;
        gap: 0;
        color: #d8d8d8;
        font-size: 1.08rem;
        line-height: 1.7;
    }

    .biography-text p {
        margin: 0;
    }

    @media (max-width: 800px) {
        .biography-layout {
            grid-template-columns: 1fr;
            width: min(100% - 2rem, 1180px);
            gap: 2rem;
            padding: 2rem 0 4rem;
        }

        .biography-heading {
            padding-top: 0;
        }
    }
</style>
<main class="biography-layout">
    <section class="biography-heading">
        <h1 class="biography-title">Biographie</h1>
        <div class="biography-portrait-placeholder" role="img" aria-label="Image placeholder portrait">Portrait</div>
    </section>
    <section class="biography-text" aria-label="Texte de biographie">
        <p>Annie Roger-Chamoulaud d&eacute;veloppe un univers plastique entre peinture, mati&egrave;re et composition textile.</p>
        <p>Cette page est pr&ecirc;te &agrave; accueillir le texte biographique complet, le parcours artistique, les inspirations, les expositions marquantes et les informations que tu souhaites mettre en avant.</p>
        <p>Le contenu pourra ensuite &ecirc;tre enrichi avec une image, une chronologie ou des sections plus d&eacute;taill&eacute;es selon la direction visuelle du site.</p>
    </section>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
