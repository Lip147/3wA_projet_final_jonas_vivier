<?php

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

function prompt(string $label): string
{
    fwrite(STDOUT, $label . ': ');

    return trim((string)fgets(STDIN));
}

$username = trim((string)(getenv('ADMIN_USERNAME') ?: prompt('Nom utilisateur')));
$email = trim((string)(getenv('ADMIN_EMAIL') ?: prompt('Adresse email')));
$password = getenv('ADMIN_PASSWORD');

if ($username === '' || strlen($username) > 100) {
    fwrite(STDERR, "Le nom utilisateur est obligatoire et limite a 100 caracteres.\n");
    exit(1);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255) {
    fwrite(STDERR, "Adresse email invalide.\n");
    exit(1);
}

if (!is_string($password) || strlen($password) < 14) {
    fwrite(STDERR, "Definissez ADMIN_PASSWORD avec un mot de passe temporaire d'au moins 14 caracteres.\n");
    exit(1);
}

require_once __DIR__ . '/../config/database.php';

$existingAccount = $pdo->prepare(
    'SELECT id_user FROM users WHERE username = ? OR email = ? LIMIT 1'
);
$existingAccount->execute([$username, $email]);

if ($existingAccount->fetch()) {
    fwrite(STDERR, "Un compte utilise deja ce nom ou cette adresse email.\n");
    exit(1);
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);
unset($password);
putenv('ADMIN_PASSWORD');
unset($_ENV['ADMIN_PASSWORD'], $_SERVER['ADMIN_PASSWORD']);

try {
    $statement = $pdo->prepare(
        'INSERT INTO users (username, email, password_hash, role) VALUES (?, ?, ?, ?)'
    );
    $statement->execute([$username, $email, $passwordHash, 'super_admin']);
} catch (PDOException $exception) {
    error_log('[Create admin] ' . $exception->getMessage());
    fwrite(STDERR, "Impossible de creer le compte. Consultez les journaux PHP.\n");
    exit(1);
}

fwrite(STDOUT, "Compte super administrateur cree.\n");
