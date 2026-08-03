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
            <a href="/site_mvc_db/public/couture">Arts textiles</a>
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
                <span>Nom <span class="required-mark" aria-hidden="true">*</span></span>
                <input type="text" name="name" placeholder="Votre nom" required>
            </label>
            <label>
                <span>E-mail <span class="required-mark" aria-hidden="true">*</span></span>
                <input type="email" name="email" placeholder="votre@email.com" required>
            </label>
            <label>
                <span>Sujet <span class="required-mark" aria-hidden="true">*</span></span>
                <input type="text" name="subject" placeholder="Objet du message" required>
            </label>
            <label>
                <span>Message <span class="required-mark" aria-hidden="true">*</span></span>
                <textarea name="message" placeholder="Votre message" required></textarea>
            </label>
            <button type="submit">Envoyer</button>
        </form>
    </main>
    <script>
        const contactForm = document.querySelector('.contact-form');

        if (contactForm) {
            const requiredFields = contactForm.querySelectorAll('[required]');

            requiredFields.forEach((field) => {
                const updateValidationMessage = () => {
                    field.setCustomValidity('');

                    if (field.validity.valueMissing) {
                        field.setCustomValidity('Ce champ est obligatoire.');
                    } else if (field.validity.typeMismatch) {
                        field.setCustomValidity('Veuillez saisir une adresse e-mail valide.');
                    }
                };

                field.addEventListener('invalid', updateValidationMessage);
                field.addEventListener('input', updateValidationMessage);
            });

            contactForm.addEventListener('submit', (event) => {
                requiredFields.forEach((field) => {
                    field.setCustomValidity('');

                    if (field.validity.valueMissing) {
                        field.setCustomValidity('Ce champ est obligatoire.');
                    } else if (field.validity.typeMismatch) {
                        field.setCustomValidity('Veuillez saisir une adresse e-mail valide.');
                    }
                });

                if (!contactForm.checkValidity()) {
                    event.preventDefault();
                    contactForm.reportValidity();
                }
            });
        }
    </script>
    <?php require __DIR__ . '/partials/legal_footer.php'; ?>
</body>
</html>
