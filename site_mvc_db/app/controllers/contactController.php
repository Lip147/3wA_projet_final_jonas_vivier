<?php
// app/controllers/contactController.php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

function contactConfigInt(string $key, int $default): int {
    $value = (int)env_value($key, $default);

    return $value > 0 ? $value : $default;
}

function contactStringInput(string $key): string {
    $value = $_POST[$key] ?? '';

    return is_string($value) ? trim($value) : '';
}

function contactCreateFormToken(): string {
    $now = microtime(true);
    $forms = isset($_SESSION['contact_forms']) && is_array($_SESSION['contact_forms'])
        ? $_SESSION['contact_forms']
        : [];

    $forms = array_filter(
        $forms,
        static fn($startedAt) => is_numeric($startedAt) && ($now - (float)$startedAt) <= 7200
    );

    $token = bin2hex(random_bytes(32));
    $forms[$token] = $now;
    $_SESSION['contact_forms'] = array_slice($forms, -10, null, true);

    return $token;
}

function contactValidateFormTiming(string $token): ?string {
    $forms = isset($_SESSION['contact_forms']) && is_array($_SESSION['contact_forms'])
        ? $_SESSION['contact_forms']
        : [];
    $startedAt = $forms[$token] ?? null;

    if ($token !== '') {
        unset($_SESSION['contact_forms'][$token]);
    }

    if (!is_numeric($startedAt)) {
        return 'Le formulaire a expiré. Rechargez la page puis réessayez.';
    }

    $elapsed = microtime(true) - (float)$startedAt;
    if ($elapsed < contactConfigInt('CONTACT_MIN_SECONDS', 3)) {
        return 'Veuillez patienter quelques secondes avant d’envoyer le formulaire.';
    }

    if ($elapsed > 7200) {
        return 'Le formulaire a expiré. Rechargez la page puis réessayez.';
    }

    return null;
}

function contactCleanupRateLimits(?int $now = null, ?int $window = null): void {
    $now ??= time();
    $window ??= contactConfigInt('CONTACT_RATE_WINDOW_SECONDS', 900);
    $rateLimitDir = __DIR__ . '/../../storage/rate_limits';

    if (!is_dir($rateLimitDir)) {
        return;
    }

    foreach (glob($rateLimitDir . '/contact_*.json') ?: [] as $staleFile) {
        if (is_file($staleFile) && filemtime($staleFile) < ($now - $window)) {
            @unlink($staleFile);
        }
    }
}

function contactConsumeRateLimit(): bool {
    $now = time();
    $window = contactConfigInt('CONTACT_RATE_WINDOW_SECONDS', 900);
    $sessionLimit = contactConfigInt('CONTACT_SESSION_LIMIT', 3);
    $ipLimit = contactConfigInt('CONTACT_IP_LIMIT', 5);

    $secret = (string)env_value('CONTACT_RATE_LIMIT_SECRET', '');
    if (strlen($secret) < 32) {
        error_log('[Contact] CONTACT_RATE_LIMIT_SECRET must contain at least 32 characters.');
        return false;
    }

    $rateLimitDir = __DIR__ . '/../../storage/rate_limits';
    if (!is_dir($rateLimitDir) && !mkdir($rateLimitDir, 0775, true) && !is_dir($rateLimitDir)) {
        error_log('[Contact] Unable to create the rate-limit directory.');
        return false;
    }

    contactCleanupRateLimits($now, $window);

    $sessionAttempts = isset($_SESSION['contact_attempts']) && is_array($_SESSION['contact_attempts'])
        ? $_SESSION['contact_attempts']
        : [];
    $sessionAttempts = array_values(array_filter(
        $sessionAttempts,
        static fn($timestamp) => is_int($timestamp) && $timestamp > ($now - $window)
    ));

    if (count($sessionAttempts) >= $sessionLimit) {
        $_SESSION['contact_attempts'] = $sessionAttempts;
        return false;
    }

    $ipAddress = isset($_SERVER['REMOTE_ADDR']) && is_string($_SERVER['REMOTE_ADDR'])
        ? $_SERVER['REMOTE_ADDR']
        : 'unknown';
    $ipIdentifier = hash_hmac('sha256', $ipAddress, $secret);
    $rateLimitFile = $rateLimitDir . '/contact_' . $ipIdentifier . '.json';
    $handle = fopen($rateLimitFile, 'c+');

    if ($handle === false || !flock($handle, LOCK_EX)) {
        if (is_resource($handle)) {
            fclose($handle);
        }
        error_log('[Contact] Unable to lock the IP rate-limit file.');
        return false;
    }

    @chmod($rateLimitFile, 0600);
    rewind($handle);
    $storedAttempts = json_decode(stream_get_contents($handle) ?: '[]', true);
    $ipAttempts = is_array($storedAttempts) ? $storedAttempts : [];
    $ipAttempts = array_values(array_filter(
        $ipAttempts,
        static fn($timestamp) => is_int($timestamp) && $timestamp > ($now - $window)
    ));

    $allowed = count($ipAttempts) < $ipLimit;
    if ($allowed) {
        $ipAttempts[] = $now;
        $sessionAttempts[] = $now;
        $_SESSION['contact_attempts'] = $sessionAttempts;
    }

    ftruncate($handle, 0);
    rewind($handle);
    fwrite($handle, json_encode($ipAttempts));
    fflush($handle);
    flock($handle, LOCK_UN);
    fclose($handle);

    return $allowed;
}

function contact() {
    contactCleanupRateLimits();

    $contactErrors = [];
    $contactSuccess = false;
    $contactData = [
        'name' => '',
        'email' => '',
        'subject' => '',
        'message' => '',
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $honeypot = contactStringInput('company_website');
        if ($honeypot !== '') {
            $contactSuccess = true;
            $contactFormToken = contactCreateFormToken();
            require_once __DIR__ . '/../views/contact.php';
            return;
        }

        $formToken = contactStringInput('contact_token');
        $timingError = contactValidateFormTiming($formToken);
        if ($timingError !== null) {
            $contactErrors[] = $timingError;
        }

        $contactData = [
            'name' => contactStringInput('name'),
            'email' => contactStringInput('email'),
            'subject' => contactStringInput('subject'),
            'message' => contactStringInput('message'),
        ];

        if ($contactData['name'] === '') {
            $contactErrors[] = 'Le nom est obligatoire.';
        } elseif (strlen($contactData['name']) > 100) {
            $contactErrors[] = 'Le nom est trop long.';
        }

        if (!filter_var($contactData['email'], FILTER_VALIDATE_EMAIL)) {
            $contactErrors[] = 'Veuillez saisir une adresse e-mail valide.';
        } elseif (strlen($contactData['email']) > 254) {
            $contactErrors[] = 'L’adresse e-mail est trop longue.';
        }

        if ($contactData['subject'] === '') {
            $contactErrors[] = 'Le sujet est obligatoire.';
        } elseif (strlen($contactData['subject']) > 150) {
            $contactErrors[] = 'Le sujet est trop long.';
        }

        if ($contactData['message'] === '') {
            $contactErrors[] = 'Le message est obligatoire.';
        }

        if (strlen($contactData['message']) > 5000) {
            $contactErrors[] = 'Le message est trop long.';
        }

        if (empty($contactErrors) && !contactConsumeRateLimit()) {
            $contactErrors[] = 'Trop de messages ont été envoyés. Veuillez réessayer dans quinze minutes.';
        }

        if (empty($contactErrors)) {
            $sendResult = sendContactMail($contactData);

            if ($sendResult === true) {
                $contactSuccess = true;
                $contactData = [
                    'name' => '',
                    'email' => '',
                    'subject' => '',
                    'message' => '',
                ];
            } else {
                $contactErrors[] = $sendResult;
            }
        }
    }

    $contactFormToken = contactCreateFormToken();
    require_once __DIR__ . '/../views/contact.php';
}

function sendContactMail(array $contactData) {
    $autoloadPath = __DIR__ . '/../../vendor/autoload.php';

    if (!file_exists($autoloadPath)) {
        return 'PHPMailer n\'est pas encore installé. Lancez composer install dans le dossier site_mvc_db.';
    }

    require_once $autoloadPath;

    $mailConfig = require __DIR__ . '/../../config/mail.php';

    try {
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host = $mailConfig['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $mailConfig['username'];
        $mail->Password = $mailConfig['password'];
        $mail->SMTPSecure = $mailConfig['encryption'];
        $mail->Port = $mailConfig['port'];

        $mail->setFrom($mailConfig['from_email'], $mailConfig['from_name']);
        $mail->addAddress($mailConfig['owner_email'], $mailConfig['owner_name']);
        $mail->addReplyTo($contactData['email'], $contactData['name']);

        $mail->Subject = '[Site web] ' . $contactData['subject'];
        $mail->Body = implode("\n", [
            'Nouveau message depuis le formulaire de contact.',
            '',
            'Nom : ' . $contactData['name'],
            'E-mail : ' . $contactData['email'],
            'Sujet : ' . $contactData['subject'],
            '',
            'Message :',
            $contactData['message'],
        ]);

        $mail->send();
        return true;
    } catch (Exception $exception) {
        return 'Le message n\'a pas pu être envoyé. Vérifiez la configuration SMTP.';
    }
}
