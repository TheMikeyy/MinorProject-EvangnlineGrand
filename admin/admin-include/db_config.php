<?php
/*
 * Évangéline Grand - shared core.
 * Loaded by EVERY public page and EVERY admin page:
 *   - connects to MySQL
 *   - provides the helper functions (setting(), e(), upload_image(), csrf, login check...)
 *
 * Database login details: Updated to use direct XAMPP defaults for easy migration.
 */

// Time zone used for "today", check-in rules and timestamps. Change it if the hotel is elsewhere.
date_default_timezone_set('Asia/Kolkata');

// true on https:// pages, also when the hosting platform terminates https in front of PHP
function is_https(): bool {
    return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
}

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0, 'path' => '/', 'httponly' => true, 'samesite' => 'Lax',
        'secure'   => is_https(),
    ]);
    session_start();
}

define('SITE_ROOT', dirname(__DIR__, 2));          // the folder that contains index.php
define('UPLOAD_DIR', SITE_ROOT . '/images/uploads/');
define('UPLOAD_URL', 'images/uploads/');            // what is stored in the database
define('MAX_UPLOAD_BYTES', 8 * 1024 * 1024);        // 8 MB per image

// Hardcoded XAMPP Defaults for seamless transfer between PC1 and PC2
$db_host = '127.0.0.1';
$db_port = 3306;
$db_name = 'evangelinewebsite'; // Ensure your imported database matches this exactly
$db_user = 'root';
$db_pass = ''; // Default XAMPP has no password

$db_options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO(
        "mysql:host={$db_host};port={$db_port};dbname={$db_name};charset=utf8mb4",
        $db_user,
        $db_pass,
        $db_options
    );
} catch (PDOException $ex) {
    error_log('Evangeline DB connection failed: ' . $ex->getMessage());
    http_response_code(500);
    exit('<h3 style="font-family:sans-serif">Could not connect to the database.</h3>'
       . '<p style="font-family:sans-serif">Check that MySQL is running (XAMPP) and that the database '
       . '<b>evangelinewebsite</b> has been imported. Connection settings are at the top of '
       . '<code>admin/admin-include/db_config.php</code>.</p>');
}

/* ------------------------------------------------------------------ */
/* Small database helpers                                              */
/* ------------------------------------------------------------------ */
function run(string $sql, array $params = []): PDOStatement {
    global $pdo;
    $st = $pdo->prepare($sql);
    $st->execute($params);
    return $st;
}
function rows(string $sql, array $params = []): array { return run($sql, $params)->fetchAll(); }
function row(string $sql, array $params = []): ?array {
    $r = run($sql, $params)->fetch();
    return $r === false ? null : $r;
}
function value(string $sql, array $params = []) { return run($sql, $params)->fetchColumn(); }

/* ------------------------------------------------------------------ */
/* Output helpers                                                      */
/* ------------------------------------------------------------------ */
function e($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

/* Make a stored image path safe to print in HTML / CSS (relative paths only). */
function asset($path): string {
    $path = str_replace(['\\', '..', "'", '"', '(', ')', '<', '>', ' '], ['/', '', '', '', '', '', '', '', '%20'], (string)$path);
    return ltrim($path, '/');
}

/* ------------------------------------------------------------------ */
/* Site settings (text + images edited from Admin > Site Content)       */
/* ------------------------------------------------------------------ */
function site_config(): array {
    static $cfg = null;
    if ($cfg === null) { $cfg = require __DIR__ . '/fields.php'; }
    return $cfg;
}
function site_defaults(): array {
    static $d = null;
    if ($d === null) {
        $d = [];
        foreach (site_config() as $tab) {
            foreach ($tab['groups'] as $g) {
                foreach ($g['fields'] as $f) { $d[$f['key']] = $f['default']; }
            }
        }
    }
    return $d;
}
function setting(string $key, string $fallback = ''): string {
    static $saved = null;
    if ($saved === null) {
        $saved = [];
        foreach (rows('SELECT setting_key, setting_value FROM site_settings') as $r) {
            $saved[$r['setting_key']] = $r['setting_value'];
        }
    }
    if (array_key_exists($key, $saved)) { return (string)$saved[$key]; }
    $defaults = site_defaults();
    return array_key_exists($key, $defaults) ? (string)$defaults[$key] : $fallback;
}
/* image setting -> safe relative path */
function img(string $key): string { return asset(setting($key)); }

/* ------------------------------------------------------------------ */
/* Formatting helpers used by the public pages                         */
/* ------------------------------------------------------------------ */
function inr($n): string {          // 1234567 -> 12,34,567 (Indian digit grouping)
    $n = (string)(int)$n;
    if (strlen($n) <= 3) { return $n; }
    $last3 = substr($n, -3);
    $rest  = substr($n, 0, -3);
    $rest  = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest);
    return $rest . ',' . $last3;
}
function price_line($min, $max): string {
    $min = (int)$min; $max = (int)$max;
    if ($max > $min) { return '₹' . inr($min) . ' – ₹' . inr($max) . ' per night'; }
    return '₹' . inr($min) . ' per night';
}
function stars_html($rating): string {   // 3.5 -> 3 full stars + 1 half star
    $rating = (float)$rating;
    $full = (int)floor($rating);
    $half = ($rating - $full) >= 0.5;
    return str_repeat('<i class="bi bi-star-fill"></i>', $full) . ($half ? '<i class="bi bi-star-half"></i>' : '');
}
function tel_href(string $phone): string { return 'tel:' . preg_replace('/[^0-9+]/', '', $phone); }
function lines(?string $text): array {    // textarea (one item per line) -> array
    $out = [];
    foreach (preg_split('/\R/', (string)$text) as $l) {
        $l = trim($l);
        if ($l !== '') { $out[] = $l; }
    }
    return $out;
}
function social_url(string $key): string {
    $u = trim(setting($key));
    return preg_match('#^https?://#i', $u) ? $u : '#';
}

/* ready-to-print attributes for a social link:  href="..."  (+ opens in a new tab when a real link is set) */
function social_attrs(string $key): string {
    $u = social_url($key);
    return 'href="' . e($u) . '"' . ($u === '#' ? '' : ' target="_blank" rel="noopener"');
}
/* "6 Adults" / "1 Adult" / "4 Children" / "1 Child" */
function adults_text($n): string   { $n = (int)$n; return $n . ($n === 1 ? ' Adult' : ' Adults'); }
function children_text($n): string { $n = (int)$n; return $n . ($n === 1 ? ' Child' : ' Children'); }

/* ------------------------------------------------------------------ */
/* Flash messages (one-time notices after saving)                      */
/* ------------------------------------------------------------------ */
function flash_set(string $type, string $msg): void { $_SESSION['flash'][] = ['type' => $type, 'msg' => $msg]; }
function flash_take(): array { $f = $_SESSION['flash'] ?? []; unset($_SESSION['flash']); return $f; }
function redirect(string $url): void { header('Location: ' . $url); exit; }
