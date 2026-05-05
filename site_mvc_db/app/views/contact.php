<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <link rel="stylesheet" href="/site_mvc_db/public/styles/style.css">
</head>
<body class="gallery-page">
    <nav class="gallery-navbar">
        <a class="gallery-logo" href="/site_mvc_db/public/home" aria-label="Accueil"></a>
        <div class="gallery-navlinks">
            <a href="/site_mvc_db/public/home">Accueil</a>
            <a href="/site_mvc_db/public/peinture">Peintures</a>
            <a href="/site_mvc_db/public/couture">Textiles</a>
            <a href="/site_mvc_db/public/expositions">&Eacute;venements</a>
            <a href="/site_mvc_db/public/biographie">Biographie</a>
        </div>
    </nav>
    <main class="contact-layout">
        <section class="contact-intro">
            <h1>Contact</h1>
            <p>Formulaire temporaire pour préparer la future prise de contact.</p>
        </section>
        <form class="contact-form" action="#" method="post">
            <label>
                Nom
                <input type="text" name="name" placeholder="Votre nom">
            </label>
            <label>
                E-mail
                <input type="email" name="email" placeholder="votre@email.com">
            </label>
            <label>
                Sujet
                <input type="text" name="subject" placeholder="Objet du message">
            </label>
            <label>
                Message
                <textarea name="message" placeholder="Votre message"></textarea>
            </label>
            <button type="button">Envoyer</button>
        </form>
    </main>
    <?php require __DIR__ . '/partials/legal_footer.php'; ?>
</body>
</html>
