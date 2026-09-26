<?php
$pageTitle = 'Biographie';
$activePage = 'biographie';
$bodyClass = 'gallery-page';
require __DIR__ . '/partials/header.php';
?>
<style>
    .biography-layout {
        width: min(100% - 6rem, 1380px);
        margin: 0 auto;
        padding: 2.25rem 0 6rem;
    }

    .biography-hero {
        display: grid;
        grid-template-columns: minmax(0, 1.25fr) minmax(360px, 0.9fr);
        align-items: center;
        gap: clamp(3rem, 7vw, 7rem);
        min-height: 620px;
    }

    .biography-intro {
        padding: 1rem 0 2rem;
    }

    .biography-kicker {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        margin: 0 0 2.25rem;
        color: #a8b59a;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }

    .biography-kicker::before {
        width: 2.5rem;
        height: 1px;
        background: currentColor;
        content: '';
    }

    .biography-title {
        max-width: 760px;
        margin: 0;
        font-size: 4.9rem;
        font-weight: 400;
        line-height: 0.94;
        letter-spacing: 0;
    }

    .biography-lead {
        max-width: 700px;
        margin: 2.5rem 0 0;
        color: #dedede;
        font-size: 0.98rem;
        line-height: 1.65;
    }

    .biography-disciplines {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem 1.7rem;
        margin: 2.5rem 0 0;
        padding: 1.2rem 0 0;
        border-top: 1px solid #303030;
        color: #a5a5a5;
        font-size: 0.8rem;
        text-transform: uppercase;
    }

    .biography-portrait {
        margin: 0;
    }

    .biography-portrait img {
        display: block;
        width: 100%;
        aspect-ratio: 4 / 5;
        object-fit: cover;
        object-position: center;
    }

    .biography-portrait figcaption {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        margin-top: 0.9rem;
        color: #a5a5a5;
        font-size: 0.78rem;
        line-height: 1.4;
    }

    .biography-text-section {
        margin-top: 5.5rem;
        padding-top: 2.75rem;
        border-top: 1px solid #303030;
    }

    .biography-text-heading {
        display: grid;
        grid-template-columns: minmax(180px, 0.7fr) minmax(0, 1.3fr);
        gap: 3rem;
        align-items: baseline;
        margin-bottom: 3.25rem;
    }

    .biography-text-heading h2 {
        margin: 0;
        font-size: 2rem;
        font-weight: 400;
        line-height: 1.1;
    }

    .biography-text-heading p {
        max-width: 650px;
        margin: 0;
        color: #a5a5a5;
        font-size: 0.9rem;
        line-height: 1.55;
    }

    .biography-text {
        column-count: 2;
        column-gap: clamp(3rem, 6vw, 6rem);
        column-fill: balance;
        color: #d8d8d8;
        font-size: 1rem;
        line-height: 1.7;
    }

    .biography-text p {
        max-width: 600px;
        margin: 0 0 2.75rem;
        break-inside: avoid;
    }

    .biography-text p:last-child {
        margin-bottom: 0;
        color: #f2f2f2;
        font-size: 1.15rem;
    }

    .biography-workshop {
        display: block;
        width: 100%;
        max-width: 600px;
        aspect-ratio: 16 / 9;
        margin: 2rem 0 0;
        object-fit: cover;
        object-position: center;
        break-inside: avoid;
    }

    @media (max-width: 1000px) {
        .biography-hero {
            grid-template-columns: minmax(0, 1fr) minmax(300px, 0.8fr);
            gap: 3rem;
            min-height: 560px;
        }

        .biography-title {
            font-size: 3.8rem;
        }
    }

    @media (max-width: 760px) {
        .biography-layout {
            width: min(100% - 2rem, 680px);
            padding: 2rem 0 4rem;
        }

        .biography-hero {
            grid-template-columns: 1fr;
            gap: 2.5rem;
            min-height: 0;
        }

        .biography-intro {
            padding: 0;
        }

        .biography-kicker {
            margin-bottom: 1.4rem;
        }

        .biography-title {
            font-size: 3.1rem;
        }

        .biography-lead {
            margin-top: 1.8rem;
            font-size: 1rem;
        }

        .biography-disciplines {
            margin-top: 2rem;
        }

        .biography-portrait img {
            aspect-ratio: 4 / 4.8;
        }

        .biography-text-section {
            margin-top: 4rem;
            padding-top: 2rem;
        }

        .biography-text-heading {
            grid-template-columns: 1fr;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .biography-text-heading h2 {
            font-size: 1.65rem;
        }

        .biography-text {
            column-count: 1;
            font-size: 0.98rem;
        }

        .biography-text p {
            max-width: none;
            margin-bottom: 1.35rem;
        }
    }
</style>

<main class="biography-layout">
    <section class="biography-hero" aria-labelledby="biography-title">
        <div class="biography-intro">
            <p class="biography-kicker">Biographie</p>
            <h1 class="biography-title" id="biography-title">Annie<br>Roger-<br>Chamoulaud</h1>
            <p class="biography-lead">Je n&rsquo;essaie pas de repr&eacute;senter la r&eacute;alit&eacute;, mais je l&rsquo;interpr&egrave;te de mani&egrave;re fantaisiste, pr&eacute;f&eacute;rant saisir l&rsquo;&eacute;motion ressentie devant le sujet.</p>
            <p class="biography-disciplines">
                <span>Peinture</span>
                <span>Dessin</span>
                <span>Arts textiles</span>
            </p>
        </div>

        <figure class="biography-portrait">
            <img src="<?php echo rtrim(app_url(), '/'); ?>/images/photo_annie_roger_travaillant.png" alt="Annie Roger-Chamoulaud travaillant dans un jardin">
        </figure>
    </section>

    <section class="biography-text-section" aria-labelledby="biography-text-title">
        <div class="biography-text-heading">
            <h2 id="biography-text-title">Un parcours entre transmission et cr&eacute;ation</h2>
        </div>

        <div class="biography-text">
            <p>Mon parcours d&rsquo;enseignante &agrave; l&rsquo;&eacute;cole primaire m&rsquo;a donn&eacute; la chance, pendant 40 ann&eacute;es, d&rsquo;une pratique des arts avec des &eacute;l&egrave;ves, m&rsquo;obligeant d&rsquo;une part &agrave; approfondir une connaissance puis&eacute;e dans les expositions nationales, locales, les mus&eacute;es, les livres, et d&rsquo;autre part &agrave; d&eacute;couvrir des techniques diversifi&eacute;es pour conduire ces enfants dans l&rsquo;exercice de multiples projets.</p>
            <p>Au jour de la retraite, ma d&eacute;cision est prise de passer de l&rsquo;autre c&ocirc;t&eacute; pour exercer mon propre geste dans l&rsquo;intention d&rsquo;aborder l&rsquo;art abstrait ; je suis confront&eacute;e rapidement &agrave; la difficult&eacute; de la page blanche que je n&rsquo;arrive pas &agrave; transformer.</p>
            <p>C&rsquo;est &agrave; l&rsquo;&Eacute;cole d&rsquo;Arts plastiques de Ch&acirc;tellerault, que je fr&eacute;quente de mani&egrave;re hebdomadaire depuis plus de 10 ans, que je trouve la motivation de produire en m&rsquo;entra&icirc;nant au dessin et &agrave; la peinture. Les professeurs y sont des guides essentiels et les peintres amateurs de la classe &agrave; laquelle je participe sont l&rsquo;&eacute;mulation n&eacute;cessaire dans mon parcours.</p>
            <p>C&rsquo;est avec un bonheur lib&eacute;rateur que je peins dans un cadre personnel : cadre qui influence mes th&egrave;mes de peinture. J&rsquo;ai la chance de trouver mes inspirations dans un milieu rural int&eacute;ressant et un jardin superbe. J&rsquo;observe continuellement la v&eacute;g&eacute;tation dans sa transformation, le mouvement dans les arbres, l&rsquo;ensemble et le d&eacute;tail. Je n&rsquo;essaie pas de repr&eacute;senter la r&eacute;alit&eacute; mais je l&rsquo;interpr&egrave;te de mani&egrave;re fantaisiste, pr&eacute;f&eacute;rant saisir l&rsquo;&eacute;motion ressentie devant le sujet &agrave; traiter. Je passe d&rsquo;un m&eacute;dium &agrave; l&rsquo;autre suivant le th&egrave;me choisi pour l&rsquo;&oelig;uvre, le format en est parfois d&eacute;terminant. Je r&eacute;alise volontiers le m&ecirc;me tableau avec des m&eacute;diums diff&eacute;rents (huile, acrylique, pastel, encre), mais je m&eacute;lange rarement ceux-ci sur une seule production.</p>
            <p>La peinture n&rsquo;&eacute;tait pas mon activit&eacute; initiale. Depuis mon jeune &acirc;ge, j&rsquo;ai toujours manipul&eacute; les fils, les laines, les tissus et les aiguilles, ce qui m&rsquo;am&egrave;ne depuis quelques ann&eacute;es &agrave; dessiner &agrave; l&rsquo;aiguille et &agrave; explorer les arts textiles, plus particuli&egrave;rement avec le recyclage de jeans dont la mati&egrave;re et la couleur nous offrent des possibilit&eacute;s incroyables de nuances. Le tissage et le piqu&eacute; libre &agrave; la machine &agrave; coudre occupent une place plus importante depuis quelque temps.</p>
            <p>Je fais aussi partie de l&rsquo;association artistique Regards de Ch&acirc;tellerault, qui permet la rencontre entre artistes amateurs. Elle propose, tout au long de l&rsquo;ann&eacute;e, la mise en exposition de notre travail dans le cadre particulier et historique de l&rsquo;H&ocirc;tel Sully de Ch&acirc;tellerault. Ces expositions r&eacute;guli&egrave;res au cours de l&rsquo;ann&eacute;e sont propos&eacute;es sur un th&egrave;me choisi ou libres de toute direction de production. Une revue produite annuellement reprend chacune de ces expositions en publiant les &oelig;uvres des participants.</p>
            <p>Je participe aussi r&eacute;guli&egrave;rement &agrave; d&rsquo;autres expositions.</p>
            <img class="biography-workshop" src="<?php echo rtrim(app_url(), '/'); ?>/images/atelier_annie_roger.png" alt="Atelier de peinture et d&rsquo;arts textiles d&rsquo;Annie Roger-Chamoulaud">
        </div>
    </section>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
