<?php
$pageTitle = 'Biographie';
$activePage = 'biographie';
$bodyClass = 'gallery-page';
require __DIR__ . '/partials/header.php';
?>
<style>
    .biography-layout {
        width: min(100% - 5rem, 1320px);
        margin: 0 auto;
        padding: 2.75rem 0 5rem;
    }

    .biography-title {
        margin: 0;
        font-size: clamp(2.7rem, 6.5vw, 6.5rem);
        font-weight: 400;
        line-height: 0.95;
    }

    .biography-heading {
        padding-top: 1rem;
    }

    .biography-content {
        display: grid;
        grid-template-columns: minmax(0, 0.95fr) minmax(340px, 1.2fr);
        gap: clamp(2.5rem, 5vw, 5rem);
        margin-top: 2.5rem;
    }

    .biography-aside {
        display: grid;
        align-content: start;
        gap: 1.65rem;
    }

    .biography-portrait-placeholder {
        display: grid;
        place-items: center;
        justify-self: center;
        width: min(100%, 320px);
        aspect-ratio: 3 / 4;
        border: 1px dashed #6f6f6f;
        color: #8f8f8f;
        font-size: 1rem;
        text-transform: uppercase;
    }

    .biography-text {
        display: grid;
        gap: 0.95rem;
        color: #d8d8d8;
        font-size: 1rem;
        line-height: 1.58;
    }

    .biography-text p {
        margin: 0;
    }

    @media (max-width: 800px) {
        .biography-layout {
            width: min(100% - 2rem, 1180px);
            padding: 2rem 0 3.5rem;
        }

        .biography-heading {
            padding-top: 0;
        }

        .biography-content {
            grid-template-columns: 1fr;
            gap: 1.65rem;
            margin-top: 2rem;
        }
    }
</style>
<main class="biography-layout">
    <section class="biography-heading">
        <h1 class="biography-title">Biographie</h1>
    </section>
    <div class="biography-content">
        <section class="biography-aside" aria-label="Portrait et introduction">
            <div class="biography-portrait-placeholder" role="img" aria-label="Image placeholder portrait">Portrait</div>
            <div class="biography-text">
                <p>Mon parcours d&rsquo;enseignante &agrave; l&rsquo;&eacute;cole primaire m&rsquo;a donn&eacute; la chance, pendant 40 ann&eacute;es, d&rsquo;une pratique des arts avec des &eacute;l&egrave;ves, m&rsquo;obligeant d&rsquo;une part &agrave; approfondir une connaissance puis&eacute;e dans les expositions nationales, locales, les mus&eacute;es, les livres, et d&rsquo;autre part &agrave; d&eacute;couvrir des techniques diversifi&eacute;es pour conduire ces enfants dans l&rsquo;exercice de multiples projets.</p>
                <p>Au jour de la retraite, ma d&eacute;cision est prise de passer de l&rsquo;autre c&ocirc;t&eacute; pour exercer mon propre geste dans l&rsquo;intention d&rsquo;aborder l&rsquo;art abstrait ; je suis confront&eacute;e rapidement &agrave; la difficult&eacute; de la page blanche que je n&rsquo;arrive pas &agrave; transformer.</p>
                <p>C&rsquo;est &agrave; l&rsquo;&Eacute;cole d&rsquo;Arts plastiques de Ch&acirc;tellerault, que je fr&eacute;quente de mani&egrave;re hebdomadaire depuis plus de 10 ans, que je trouve la motivation de produire en m&rsquo;entra&icirc;nant au dessin et &agrave; la peinture. Les professeurs y sont des guides essentiels et les peintres amateurs de la classe &agrave; laquelle je participe sont l&rsquo;&eacute;mulation n&eacute;cessaire dans mon parcours.</p>
            </div>
        </section>
        <section class="biography-text" aria-label="Texte de biographie">
            <p>C&rsquo;est avec un bonheur lib&eacute;rateur que je peins dans un cadre personnel : cadre qui influence mes th&egrave;mes de peinture. J&rsquo;ai la chance de trouver mes inspirations dans un milieu rural int&eacute;ressant et un jardin superbe. J&rsquo;observe continuellement la v&eacute;g&eacute;tation dans sa transformation, le mouvement dans les arbres, l&rsquo;ensemble et le d&eacute;tail. Je n&rsquo;essaie pas de repr&eacute;senter la r&eacute;alit&eacute; mais je l&rsquo;interpr&egrave;te de mani&egrave;re fantaisiste, pr&eacute;f&eacute;rant saisir l&rsquo;&eacute;motion ressentie devant le sujet &agrave; traiter. Je passe d&rsquo;un m&eacute;dium &agrave; l&rsquo;autre suivant le th&egrave;me choisi pour l&rsquo;&oelig;uvre, le format en est parfois d&eacute;terminant. Je r&eacute;alise volontiers le m&ecirc;me tableau avec des m&eacute;diums diff&eacute;rents (huile, acrylique, pastel, encre), mais je m&eacute;lange rarement ceux-ci sur une seule production.</p>
            <p>La peinture n&rsquo;&eacute;tait pas mon activit&eacute; initiale. Depuis mon jeune &acirc;ge, j&rsquo;ai toujours manipul&eacute; les fils, les laines, les tissus et les aiguilles, ce qui m&rsquo;am&egrave;ne depuis quelques ann&eacute;es &agrave; dessiner &agrave; l&rsquo;aiguille et &agrave; explorer les arts textiles, plus particuli&egrave;rement avec le recyclage de jeans dont la mati&egrave;re et la couleur nous offrent des possibilit&eacute;s incroyables de nuances. Le tissage et le piqu&eacute; libre &agrave; la machine &agrave; coudre occupent une place plus importante depuis quelques temps.</p>
            <p>Je fais aussi partie de l&rsquo;association artistique Regards de Ch&acirc;tellerault, qui permet la rencontre entre artistes amateurs. Elle propose, tout au long de l&rsquo;ann&eacute;e, la mise en exposition de notre travail dans le cadre particulier et historique de l&rsquo;H&ocirc;tel Sully de Ch&acirc;tellerault. Ces expositions r&eacute;guli&egrave;res au cours de l&rsquo;ann&eacute;e sont propos&eacute;es sur un th&egrave;me choisi ou libres de toute direction de production. Une revue produite annuellement reprend chacune de ces expositions en publiant les &oelig;uvres des participants.</p>
            <p>Je participe aussi r&eacute;guli&egrave;rement &agrave; d&rsquo;autres expositions.</p>
        </section>
    </div>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
