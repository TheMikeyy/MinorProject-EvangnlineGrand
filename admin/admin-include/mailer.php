<?php
/*
 * E-MAIL  -  one single place.
 *
 * Every e-mail the website wants to send (booking received, booking confirmed, password reset,
 * new contact message ...) goes through send_mail(). Right now e-mail sending is NOT connected,
 * so every message is simply saved in the database and appears in  Admin > Email Log.
 * Nothing is lost, and nothing breaks.
 *
 * WHEN YOU ARE READY TO SEND REAL E-MAILS:
 *   Option A (simple):   set the environment variable MAIL_MODE=mail   (uses PHP mail(); needs a mail server)
 *   Option B (SMTP):     put PHPMailer / your provider's code inside deliver_mail() below. That is the only
 *                        function you need to change. It must return [true, ''] on success or [false, 'reason'].
 *
 * Who receives alerts about new bookings and messages?  Admin > Site Content > Bookings & Email > "Alert e-mail".
 */
define('MAIL_MODE', getenv('MAIL_MODE') ?: 'log');   // 'log' = only save to the Email Log (default)

function deliver_mail(string $to, string $subject, string $body): array {
    if (MAIL_MODE === 'mail') {
        $from = getenv('MAIL_FROM') ?: setting('email');
        $from = preg_replace('/[\r\n]+/', '', $from);
        $headers = "From: " . setting('hotel_name') . " <$from>\r\nContent-Type: text/plain; charset=UTF-8\r\nMIME-Version: 1.0";
        $ok = @mail($to, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, $headers);
        return $ok ? [true, ''] : [false, 'PHP mail() could not send the message (no mail server configured?).'];
    }
    // ---> PUT YOUR SMTP / PHPMailer CODE HERE <---
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
        $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        $dir   = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
        $dir   = preg_replace('#/admin$#', '', $dir);
        $base  = ($https ? 'https://' : 'http://') . $host . $dir;
    }
    return rtrim($base, '/') . '/' . ltrim($path, '/');
}
