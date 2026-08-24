<?php
// app/controllers/contactController.php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

function contact() {
    $contactErrors = [];
    $contactSuccess = false;
    $contactData = [
        'name' => '',
        'email' => '',
        'subject' => '',
        'message' => '',
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $contactData = [
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'subject' => trim($_POST['subject'] ?? ''),
            'message' => trim($_POST['message'] ?? ''),
        ];

        if ($contactData['name'] === '') {
            $contactErrors[] = 'Le nom est obligatoire.';
        }

        if (!filter_var($contactData['email'], FILTER_VALIDATE_EMAIL)) {
            $contactErrors[] = 'Veuillez saisir une adresse e-mail valide.';
        }

        if ($contactData['subject'] === '') {
            $contactErrors[] = 'Le sujet est obligatoire.';
        }

        if ($contactData['message'] === '') {
            $contactErrors[] = 'Le message est obligatoire.';
        }

        if (strlen($contactData['message']) > 5000) {
            $contactErrors[] = 'Le message est trop long.';
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

    require_once __DIR__ . '/../views/contact.php';
}

function sendContactMail(array $contactData) {
    $autoloadPath = __DIR__ . '/../../vendor/autoload.php';

    if (!file_exists($autoloadPath)) {
        return 'PHPMailer n\'est pas encore installe. Lancez composer install dans le dossier site_mvc_db.';
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
        return 'Le message n\'a pas pu etre envoye. Verifiez la configuration SMTP.';
    }
}
