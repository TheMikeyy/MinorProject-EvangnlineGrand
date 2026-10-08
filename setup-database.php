<?php
/*
 * ONE-TIME DATABASE INSTALLER  (use it once, then DELETE this file and database-import.sql)
 *
 * Loads database-import.sql into the database your website is connected to (the DB_* settings in
 * Render > Environment), so you do not need MySQL Workbench.
 *
 * It is switched OFF unless the environment variable SETUP_TOKEN is set (any long secret you invent),
 * and it asks for that token before doing anything.
 */
header('Content-Type: text/html; charset=utf-8');
header('X-Robots-Tag: noindex');

$token = (string)getenv('SETUP_TOKEN');
$file  = __DIR__ . '/database-import.sql';
$tables = ['admin_cred','bookings','comforts','contact_messages','email_log','hero_slides','lodges','login_attempts','password_resets','site_settings','team_members','testimonials','users','user_tokens'];

function page(string $body): void {
    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Database setup</title></head>'
       . '<body style="font-family:system-ui,sans-serif;max-width:760px;margin:2rem auto;padding:0 1rem;line-height:1.5">' . $body . '</body></html>';
    exit;
}
function h($s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

if ($token === '') {
    page('<h2>Database setup is switched off</h2><p>Add an environment variable <b>SETUP_TOKEN</b> (any long secret text) in Render &gt; Environment, redeploy, then reload this page.</p>');
}
if (!is_file($file)) { page('<h2>File missing</h2><p><b>database-import.sql</b> must be in the same folder as this page.</p>'); }

// same connection settings as the website
$opts = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false];
if (getenv('DB_SSL') || getenv('DB_SSL_CA')) {
    $opts[PDO::MYSQL_ATTR_SSL_CA] = getenv('DB_SSL_CA') ?: '/etc/ssl/certs/ca-certificates.crt';
    if (!getenv('DB_SSL_CA')) { $opts[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false; }
}
try {
    $pdo = new PDO('mysql:host=' . (getenv('DB_HOST') ?: '127.0.0.1') . ';port=' . (int)(getenv('DB_PORT') ?: 3306) . ';dbname=' . (getenv('DB_NAME') ?: 'evangelinewebsite') . ';charset=utf8mb4',
                   getenv('DB_USER') ?: 'root', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '', $opts);
} catch (PDOException $ex) {
    page('<h2>Cannot reach the database</h2><p>Check DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS and DB_SSL=1 in Render &gt; Environment.</p><pre>' . h($ex->getMessage()) . '</pre>');
}

$marks = implode(',', array_fill(0, count($tables), '?'));
$st = $pdo->prepare("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME IN ($marks)");
$st->execute($tables);
$existing = $st->fetchAll(PDO::FETCH_COLUMN);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    page('<h2>Database setup</h2><p>Connected to database <b>' . h($pdo->query('SELECT DATABASE()')->fetchColumn()) . '</b>. It currently has <b>' . count($existing) . '</b> of the 14 website tables.</p>'
       . '<form method="post"><p><label>Setup token<br><input type="password" name="token" required style="width:100%;padding:.5rem"></label></p>'
       . ($existing ? '<p><label><input type="checkbox" name="erase" value="yes"> Tables already exist: <b>erase them</b> and import again (deletes all current website data)</label></p>' : '')
       . '<button style="padding:.6rem 1.2rem">Import database</button></form>');
}

if (!hash_equals($token, (string)($_POST['token'] ?? ''))) { http_response_code(403); page('<h2>Wrong token</h2><p><a href="">Try again</a></p>'); }
if ($existing && ($_POST['erase'] ?? '') !== 'yes') { page('<h2>Nothing was changed</h2><p>These tables already exist: ' . h(implode(', ', $existing)) . '.<br>Tick the "erase" box if you really want to replace them.</p><p><a href="">Back</a></p>'); }

set_time_limit(120);
$log = [];
try {
    if ($existing) { $pdo->exec('SET FOREIGN_KEY_CHECKS=0'); foreach ($existing as $t) { $pdo->exec('DROP TABLE IF EXISTS `' . $t . '`'); } $log[] = 'Removed old tables: ' . implode(', ', $existing); }

    // split the file into statements (aware of quotes and comments)
    $sql = file_get_contents($file); $len = strlen($sql); $stmts = []; $cur = ''; $q = ''; 
    for ($i = 0; $i < $len; $i++) {
        $c = $sql[$i]; $n = $sql[$i + 1] ?? '';
        if ($q === '') {
            if ($c === '-' && $n === '-' && ($sql[$i + 2] ?? ' ') <= ' ') { while ($i < $len && $sql[$i] !== "\n") { $i++; } continue; }
            if ($c === '#') { while ($i < $len && $sql[$i] !== "\n") { $i++; } continue; }
            if ($c === '/' && $n === '*') {                                   // block / version comment: keep (MySQL runs /*!...*/)
                $end = strpos($sql, '*/', $i + 2); $end = $end === false ? $len : $end + 2;
                $cur .= substr($sql, $i, $end - $i); $i = $end - 1; continue;
            }
            if ($c === "'" || $c === '"' || $c === '`') { $q = $c; }
            elseif ($c === ';') { if (trim($cur) !== '') { $stmts[] = trim($cur); } $cur = ''; continue; }
        } else {
            if ($c === '\\' && $q !== '`') { $cur .= $c . $n; $i++; continue; }
            if ($c === $q) { if ($n === $q) { $cur .= $c . $n; $i++; continue; } $q = ''; }
        }
        $cur .= $c;
    }
    if (trim($cur) !== '') { $stmts[] = trim($cur); }

    $done = 0;
    foreach ($stmts as $s) {
        if (preg_match('/^(CREATE DATABASE|USE)\b/i', $s)) { continue; }      // hosted databases already exist
        $pdo->exec($s); $done++;
    }
    $log[] = "Ran $done statements.";
    $counts = [];
    foreach ($tables as $t) { $counts[] = $t . ': ' . (int)$pdo->query("SELECT COUNT(*) FROM `$t`")->fetchColumn(); }
    page('<h2 style="color:#1F2A52">Done &#10003;</h2><p>' . h(implode(' ', $log)) . '</p><p>Rows per table:<br>' . h(implode(' · ', $counts)) . '</p>'
       . '<p><b>Now:</b> (1) delete <code>setup-database.php</code> and <code>database-import.sql</code> from your project and push, (2) remove SETUP_TOKEN from Render, (3) open <a href="admin/admin-index.php">the admin login</a>.</p>');
} catch (Throwable $ex) {
    page('<h2>Stopped with an error</h2><pre>' . h($ex->getMessage()) . '</pre><p>Nothing more was run. Send me this message.</p>');
}
