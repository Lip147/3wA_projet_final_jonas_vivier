<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion admin</title>
    <style>
        body { background: #f5f5f5; font-family: Arial, sans-serif; }
        .login-box { max-width: 350px; margin: 6rem auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #0001; padding: 2rem; }
        h1 { text-align: center; }
        form { display: flex; flex-direction: column; gap: 1rem; }
        input { padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 0.5rem; background: #222; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #444; }
        .error { color: #c00; text-align: center; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>Connexion admin</h1>
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="user" placeholder="Nom d'utilisateur" required>
            <input type="password" name="pass" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
    </div>
    <?php require __DIR__ . '/partials/legal_footer.php'; ?>
</body>
</html>
