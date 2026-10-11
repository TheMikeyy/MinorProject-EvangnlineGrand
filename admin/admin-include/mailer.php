<?php
/*
 * E-MAIL  -  one single place.
 *
 * Every e-mail the website creates (booking received / confirmed, welcome, password reset, alerts for
 * the hotel ...) goes through send_mail() and is also saved in  Admin > Email Log.
 *
 * MAIL_MODE decides what happens:
 *   log    (default) only save in the Email Log, nothing is sent
 *   brevo  send for real through Brevo's web API (free plan: 300 e-mails/day). Works on Render's free plan,
 *          which blocks normal SMTP ports (25, 465, 587) - the API uses port 443.
 *   mail   PHP mail() (needs a mail server on the machine)
 *
 * Settings (set them as Render environment variables, OR copy mail-config.sample.php to mail-config.php):
 *   MAIL_MODE=brevo   BREVO_API_KEY=...   MAIL_FROM=your-verified-sender@example.com   MAIL_FROM_NAME=optional
 * Who receives alerts about new bookings/messages: Admin > Site Content > Bookings & Email > "Alert e-mail".
 */
function mail_cfg(string $key, string $default = ''): string {
    static $file = null;
    if ($file === null) { $p = __DIR__ . '/mail-config.php'; $file = is_file($p) ? (array)(require $p) : []; }
    $v = getenv($key);
    if ($v !== false && $v !== '') { return (string)$v; }
    return (string)($file[$key] ?? $default);
}
define('MAIL_MODE', mail_cfg('MAIL_MODE', 'log'));

/* tiny HTTPS POST helper: returns [http status, response text, error text] */
function http_post_json(string $url, string $payload, array $headers): array {
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [CURLOPT_POST => true, CURLOPT_POSTFIELDS => $payload, CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 15, CURLOPT_CONNECTTIMEOUT => 8]);
        $resp = curl_exec($ch); $err = curl_error($ch); $code = (int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE); curl_close($ch);
        return [$code, (string)$resp, $err];
    }
    $ctx = stream_context_create(['http' => ['method' => 'POST', 'header' => implode("\r\n", $headers), 'content' => $payload, 'timeout' => 15, 'ignore_errors' => true]]);
    $resp = @file_get_contents($url, false, $ctx);
    $code = 0;
    if (isset($http_response_header[0]) && preg_match('#HTTP/\S+\s+(\d+)#', $http_response_header[0], $mm)) { $code = (int)$mm[1]; }
    return [$code, (string)$resp, $resp === false ? 'Could not connect to the e-mail service.' : ''];
}

function deliver_mail(string $to, string $subject, string $body): array {
    $from     = preg_replace('/[\r\n]+/', '', mail_cfg('MAIL_FROM') ?: setting('email'));
    $fromName = preg_replace('/[\r\n]+/', ' ', mail_cfg('MAIL_FROM_NAME') ?: setting('hotel_name'));

    if (MAIL_MODE === 'brevo') {
        $key = mail_cfg('BREVO_API_KEY');
        if ($key === '')                                  { return [false, 'BREVO_API_KEY is not set.']; }
        if (!filter_var($from, FILTER_VALIDATE_EMAIL))    { return [false, 'MAIL_FROM must be a valid sender e-mail that you verified in Brevo.']; }
        $payload = json_encode(['sender' => ['name' => $fromName, 'email' => $from], 'to' => [['email' => $to]], 'subject' => $subject, 'textContent' => $body], JSON_UNESCAPED_UNICODE);
        [$code, $resp, $err] = http_post_json(mail_cfg('BREVO_API_URL', 'https://api.brevo.com/v3/smtp/email'), $payload,
            ['accept: application/json', 'content-type: application/json', 'api-key: ' . $key]);
        if ($code >= 200 && $code < 300) { return [true, '']; }
        return [false, $err !== '' ? $err : ('Brevo answered HTTP ' . $code . ': ' . mb_substr($resp, 0, 200))];
    }
    if (MAIL_MODE === 'mail') {
        $headers = "From: $fromName <$from>\r\nContent-Type: text/plain; charset=UTF-8\r\nMIME-Version: 1.0";
        $ok = @mail($to, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, $headers);
        return $ok ? [true, ''] : [false, 'PHP mail() could not send the message (no mail server configured?).'];
    }
    return [false, 'E-mail sending is not set up yet.'];
}

function send_mail(string $to, string $subject, string $body): bool {
    $to      = trim(preg_replace('/[\r\n]+/', '', $to));
    $subject = trim(preg_replace('/[\r\n]+/', ' ', $subject));
    if ($to === '' || !filter_var($to, FILTER_VALIDATE_EMAIL)) { return false; }

    $id = null;
    try {
        run('INSERT INTO email_log (to_email, subject, body, status) VALUES (?, ?, ?, ?)', [$to, mb_substr($subject, 0, 200), $body, 'queued']);
        $id = (int)$GLOBALS['pdo']->lastInsertId();
    } catch (Throwable $ex) { error_log('email_log insert failed: ' . $ex->getMessage()); }

    [$ok, $err] = deliver_mail($to, $subject, $body);
    if ($id) {
        if ($ok) { run("UPDATE email_log SET status = 'sent', error = NULL WHERE id = ?", [$id]); }
        elseif (MAIL_MODE !== 'log') { run("UPDATE email_log SET status = 'failed', error = ? WHERE id = ?", [mb_substr($err, 0, 250), $id]); }
    }
    return $ok;
}

/* alert the hotel (booking requests, contact messages ...) */
function notify_admin(string $subject, string $body): void {
    $to = trim(setting('notify_email')) ?: trim(setting('email'));
    if ($to !== '') { send_mail($to, '[' . setting('hotel_name') . '] ' . $subject, $body); }
}

/* absolute link to a page of this website (used inside e-mails) */
function site_url(string $path = ''): string {
    $base = getenv('SITE_URL');
    if (!$base) {
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        if (!preg_match('/^[A-Za-z0-9.\-]+(:\d+)?$/', $host)) { $host = 'localhost'; }
        $https = is_https();
        $dir   = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
        $dir   = preg_replace('#/admin$#', '', $dir);
        $base  = ($https ? 'https://' : 'http://') . $host . $dir;
    }
    return rtrim($base, '/') . '/' . ltrim($path, '/');
}
