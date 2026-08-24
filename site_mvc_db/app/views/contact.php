<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription ?? "Portfolio artistique d'Annie Roger Chamoulaud."); ?>">
    <meta name="author" content="Jonas Vivier">
    <title>Contact</title>
    <link rel="stylesheet" href="<?php echo rtrim(app_url(), '/'); ?>/styles/style.css">
</head>
<body class="gallery-page">
    <nav class="gallery-navbar">
        <a class="gallery-logo" href="<?php echo rtrim(app_url(), '/'); ?>/home" aria-label="Accueil"></a>
        <div class="gallery-navlinks">
            <a href="<?php echo rtrim(app_url(), '/'); ?>/home">Accueil</a>
            <a href="<?php echo rtrim(app_url(), '/'); ?>/peinture">Peintures</a>
            <a href="<?php echo rtrim(app_url(), '/'); ?>/couture">Arts textiles</a>
            <a href="<?php echo rtrim(app_url(), '/'); ?>/expositions">&Eacute;venements</a>
            <a href="<?php echo rtrim(app_url(), '/'); ?>/biographie">Biographie</a>
        </div>
    </nav>
    <main class="contact-layout">
        <section class="contact-intro">
            <h1>Contact</h1>
            <p>Formulaire temporaire pour préparer la future prise de contact.</p>
        </section>
        <form class="contact-form" action="<?php echo rtrim(app_url(), '/'); ?>/contact" method="post">
            <?php if (!empty($contactSuccess)): ?>
                <p class="contact-alert contact-alert-success">Votre message a bien &eacute;t&eacute; envoy&eacute;.</p>
            <?php endif; ?>

            <?php if (!empty($contactErrors)): ?>
                <div class="contact-alert contact-alert-error" role="alert">
                    <?php foreach ($contactErrors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <label>
                <span>Nom <span class="required-mark" aria-hidden="true">*</span></span>
                <input type="text" name="name" placeholder="Votre nom" value="<?php echo htmlspecialchars($contactData['name'] ?? ''); ?>" required>
            </label>
            <label>
                <span>E-mail <span class="required-mark" aria-hidden="true">*</span></span>
                <input type="email" name="email" placeholder="votre@email.com" value="<?php echo htmlspecialchars($contactData['email'] ?? ''); ?>" required>
            </label>
            <label>
                <span>Sujet <span class="required-mark" aria-hidden="true">*</span></span>
                <input type="text" name="subject" placeholder="Objet du message" value="<?php echo htmlspecialchars($contactData['subject'] ?? ''); ?>" required>
            </label>
            <label>
                <span>Message <span class="required-mark" aria-hidden="true">*</span></span>
                <textarea name="message" placeholder="Votre message" required><?php echo htmlspecialchars($contactData['message'] ?? ''); ?></textarea>
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
