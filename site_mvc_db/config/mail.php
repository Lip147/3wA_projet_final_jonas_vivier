<?php
require_once __DIR__ . '/env.php';

return [
    'host' => env_value('MAIL_HOST', ''),
    'port' => (int) env_value('MAIL_PORT', 587),
    'encryption' => env_value('MAIL_ENCRYPTION', 'tls'),
    'username' => env_value('MAIL_USERNAME', ''),
    'password' => env_value('MAIL_PASSWORD', ''),

    'from_email' => env_value('MAIL_FROM_EMAIL', ''),
    'from_name' => env_value('MAIL_FROM_NAME', 'Site Annie Roger Chamoulaud'),

    'owner_email' => env_value('MAIL_OWNER_EMAIL', ''),
    'owner_name' => env_value('MAIL_OWNER_NAME', ''),
];
