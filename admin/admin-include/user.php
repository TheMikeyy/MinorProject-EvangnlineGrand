<?php
/* Guest accounts: login state, safe redirects, throttling, small UI helpers. */

function current_user(bool $refresh = false): ?array {
    static $loaded = false, $user = null;
    if ($refresh) { $loaded = false; $user = null; }
    if ($loaded) { return $user; }
    $loaded = true;
    $id = (int)($_SESSION['user_id'] ?? 0);
    if ($id <= 0) { $id = remember_autologin(); }          // "keep me logged in" cookie
    if ($id > 0) {
        $u = row('SELECT * FROM users WHERE id = ?', [$id]);
        if ($u && (int)$u['is_active'] === 1) { $user = $u; }
        else { unset($_SESSION['user_id']); }      // deleted or disabled by the hotel: signed out at once
    }
    return $user;
}
function is_user(): bool { return current_user() !== null; }

function login_user(array $u): void {
    session_regenerate_id(true);
    $_SESSION['user_id'] = (int)$u['id'];
    run('UPDATE users SET last_login_at = NOW() WHERE id = ?', [(int)$u['id']]);
    current_user(true);
}
function logout_user(): void {
    remember_forget();
    unset($_SESSION['user_id']);
    session_regenerate_id(true);
    current_user(true);
}

/* Pages that need a guest account: show the login pop-up and come back afterwards. */
function require_user(): array {
    $u = current_user();
    if ($u) { return $u; }
    $_SESSION['auth_modal'] = ['which' => 'login', 'errors' => ['Please log in to continue.'], 'old' => [], 'return' => $_SERVER['REQUEST_URI'] ?? 'index.php'];
    redirect('index.php');
}

/* only ever redirect to a page of this site (never to another website) */
function safe_return($url, string $default = 'index.php'): string {
    $url = trim((string)$url);
    if ($url === '' || strlen($url) > 300) { return $default; }
    if (preg_match('/[\x00-\x1F\x7F\\\\]/', $url)) { return $default; }
    if (preg_match('#^[a-z][a-z0-9+.\-]*:#i', $url) || strpos($url, '//') === 0) { return $default; }
    $path = (string)parse_url($url, PHP_URL_PATH);
    if ($path === '' || (substr($path, -4) !== '.php' && substr($path, -1) !== '/')) { return $default; }
    if (in_array(basename($path), ['auth.php', 'logout.php', 'availability.php'], true) || strpos($path, '/admin/') !== false) { return $default; }
    return $url;
}

/* one-time pop-up notices on the public website (separate from the admin "flash" messages) */
function toast_set(string $type, string $msg): void { $_SESSION['toasts'][] = ['type' => $type, 'msg' => $msg]; }
function toast_take(): array { $t = $_SESSION['toasts'] ?? []; unset($_SESSION['toasts']); return $t; }

function client_ip(): string {
    $ip = (string)($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
    return substr($ip, 0, 45);
}

/* ---- login throttling (works even if the attacker throws away cookies) ---- */
function login_throttled(string $email): bool {
    run('DELETE FROM login_attempts WHERE created_at < (NOW() - INTERVAL 1 DAY)');
    $byIp    = (int)value('SELECT COUNT(*) FROM login_attempts WHERE ip = ? AND created_at > (NOW() - INTERVAL 15 MINUTE)', [client_ip()]);
    $byEmail = (int)value('SELECT COUNT(*) FROM login_attempts WHERE email = ? AND created_at > (NOW() - INTERVAL 15 MINUTE)', [mb_strtolower($email)]);
    return $byIp >= 20 || $byEmail >= 6;
}
function login_fail_record(string $email): void { run('INSERT INTO login_attempts (ip, email) VALUES (?, ?)', [client_ip(), mb_strtolower(mb_substr($email, 0, 150))]); }
function login_fail_clear(string $email): void { run('DELETE FROM login_attempts WHERE email = ?', [mb_strtolower($email)]); }

/* ---- profile picture / initials ---- */
function user_avatar(array $u, int $size = 30): string {
    $style = 'width:' . $size . 'px;height:' . $size . 'px;font-size:' . round($size * 0.45) . 'px';
    if (!empty($u['picture'])) {
        return '<img class="user-avatar" style="' . $style . '" src="' . e(asset($u['picture'])) . '" alt="">';
    }
    return '<span class="user-avatar user-avatar-initial" style="' . $style . '">' . e(mb_strtoupper(mb_substr(trim($u['name']) ?: '?', 0, 1))) . '</span>';
}

/* ---- validation shared by signup / profile / admin ---- */
function valid_phone(string $p): bool   { return (bool)preg_match('/^[0-9+\-\s()]{7,20}$/', $p); }
function valid_pincode(string $p): bool { return (bool)preg_match('/^[0-9A-Za-z\- ]{3,10}$/', $p); }
function parse_dob(string $s): ?DateTimeImmutable { return parse_date($s); }
function is_adult(DateTimeImmutable $dob): bool {
    return $dob <= (new DateTimeImmutable('today'))->modify('-18 years') && $dob >= new DateTimeImmutable('1900-01-01');
}


/* ---- "Keep me logged in for 30 days" (a random token in a cookie; only its hash is stored) ---- */
function remember_cookie_set(string $value, int $expires): void {
    if (headers_sent()) { return; }
    setcookie('eg_remember', $value, ['expires' => $expires, 'path' => '/', 'httponly' => true, 'samesite' => 'Lax',
        'secure' => is_https()]);
}
function remember_issue(int $userId): void {
    $sel = bin2hex(random_bytes(9)); $val = bin2hex(random_bytes(32));
    run('DELETE FROM user_tokens WHERE expires_at < NOW()');
    run('INSERT INTO user_tokens (user_id, selector, token_hash, expires_at) VALUES (?, ?, ?, NOW() + INTERVAL 30 DAY)', [$userId, $sel, hash('sha256', $val)]);
    remember_cookie_set($sel . ':' . $val, time() + 30 * 86400);
}
/* returns the user id when a valid cookie is found (and signs the guest in), otherwise 0 */
function remember_autologin(): int {
    $c = (string)($_COOKIE['eg_remember'] ?? '');
    if (!preg_match('/^([a-f0-9]{18}):([a-f0-9]{64})$/', $c, $m)) { return 0; }
    $t = row('SELECT * FROM user_tokens WHERE selector = ? AND expires_at > NOW()', [$m[1]]);
    if (!$t || !hash_equals($t['token_hash'], hash('sha256', $m[2]))) { remember_cookie_set('', time() - 3600); return 0; }
    $u = row('SELECT id FROM users WHERE id = ? AND is_active = 1', [$t['user_id']]);
    if (!$u) { run('DELETE FROM user_tokens WHERE id = ?', [$t['id']]); remember_cookie_set('', time() - 3600); return 0; }
    if (session_status() === PHP_SESSION_ACTIVE && !headers_sent()) { session_regenerate_id(true); }
    $_SESSION['user_id'] = (int)$u['id'];
    return (int)$u['id'];
}
/* logout on this device (or, with $userId, on every device: after a password change etc.) */
function remember_forget(?int $userId = null): void {
    if ($userId !== null) { run('DELETE FROM user_tokens WHERE user_id = ?', [$userId]); return; }
    if (preg_match('/^([a-f0-9]{18}):/', (string)($_COOKIE['eg_remember'] ?? ''), $m)) { run('DELETE FROM user_tokens WHERE selector = ?', [$m[1]]); }
    remember_cookie_set('', time() - 3600);
}
