<?php
/*
 * Copy this file to  mail-config.php  (same folder) and fill in your values.
 * mail-config.php holds a secret key: NEVER upload it to GitHub (it is listed in .gitignore).
 * On Render use Environment variables with the same names instead.
 */
return [
    'MAIL_MODE'      => 'brevo',
    'BREVO_API_KEY'  => 'paste-your-brevo-api-key-here',
    'MAIL_FROM'      => 'the-sender-address-you-verified-in-brevo@example.com',
    'MAIL_FROM_NAME' => 'Évangéline Grand',
];
