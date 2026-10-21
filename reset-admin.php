<?php
/*
 * ONE-TIME ADMIN LOGIN RESET  (use it once, then DELETE this file)
 *
 * Sets a new admin name + password in the database your website is connected to.
 * It is switched OFF unless the environment variable RESET_TOKEN is set (any long secret you invent),
 * and it asks for that token before doing anything.
 */
header('Content-Type: text/html; charset=utf-8');
header('X-Robots-Tag: noindex');

function page(string $body): void {
    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin reset</title></head>'
       . '<body style="font-family:system-ui,sans-serif;max-width:560px;margin:2rem auto;padding:0 1rem;line-height:1.5">' . $body . '</body></html>';
    exit;
}
function h($s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

$token = (string)getenv('RESET_TOKEN');
if ($token === '') {
    page('<h2>Admin reset is switched off</h2><p>Add an environment variable <b>RESET_TOKEN</b> (any long secret text) in Render &gt; Environment, wait for the redeploy, then reload this page.</p>');
}

$opts = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false];
if (getenv('DB_SSL') || getenv('DB_SSL_CA')) {
    $opts[PDO::MYSQL_ATTR_SSL_CA] = getenv('DB_SSL_CA') ?: '/etc/ssl/certs/ca-certificates.crt';
    if (!getenv('DB_SSL_CA')) { $opts[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false; }
}
try {
    $pdo = new PDO('mysql:host=' . (getenv('DB_HOST') ?: '127.0.0.1') . ';port=' . (int)(getenv('DB_PORT') ?: 3306) . ';dbname=' . (getenv('DB_NAME') ?: 'evangelinewebsite') . ';charset=utf8mb4',
                   getenv('DB_USER') ?: 'root', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '', $opts);
} catch (PDOException $ex) {
    page('<h2>Cannot reach the database</h2><p>Check the DB_ settings in Render &gt; Environment.</p><pre>' . h($ex->getMessage()) . '</pre>');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    page('<h2>Reset the admin login</h2><form method="post" autocomplete="off">'
       . '<p><label>Reset token<br><input type="password" name="token" required style="width:100%;padding:.5rem"></label></p>'
       . '<p><label>New admin name<br><input type="text" name="name" required maxlength="150" style="width:100%;padding:.5rem" placeholder="for example  admin@evangelinegrand.com"></label></p>'
       . '<p><label>New password (8 or more characters)<br><input type="password" name="pass" required minlength="8" style="width:100%;padding:.5rem"></label></p>'
       . '<p><label>Repeat the password<br><input type="password" name="pass2" required minlength="8" style="width:100%;padding:.5rem"></label></p>'
       . '<button style="padding:.6rem 1.2rem">Set new admin login</button></form>');
}

if (!hash_equals($token, (string)($_POST['token'] ?? ''))) { sleep(1); http_response_code(403); page('<h2>Wrong token</h2><p><a href="">Try again</a></p>'); }
$name = trim((string)($_POST['name'] ?? '')); $pass = (string)($_POST['pass'] ?? '');
if ($name === '' || mb_strlen($name) > 150) { page('<h2>Not saved</h2><p>Please enter a name (up to 150 characters). <a href="">Back</a></p>'); }
if (strlen($pass) < 8)                      { page('<h2>Not saved</h2><p>The password must be at least 8 characters. <a href="">Back</a></p>'); }
if ($pass !== (string)($_POST['pass2'] ?? '')) { page('<h2>Not saved</h2><p>The two passwords do not match. <a href="">Back</a></p>'); }

try {
    $id = $pdo->query('SELECT sr_no FROM admin_cred ORDER BY sr_no LIMIT 1')->fetchColumn();
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    if ($id) { $pdo->prepare('UPDATE admin_cred SET admin_mail = ?, admin_pass = ? WHERE sr_no = ?')->execute([$name, $hash, $id]); }
    else     { $pdo->prepare('INSERT INTO admin_cred (admin_mail, admin_pass) VALUES (?, ?)')->execute([$name, $hash]); }
} catch (Throwable $ex) {
    page('<h2>Stopped with an error</h2><pre>' . h($ex->getMessage()) . '</pre>');
}
page('<h2 style="color:#1F2A52">Done &#10003;</h2><p>The admin login is now:<br>Name: <b>' . h($name) . '</b><br>Password: the one you just typed.</p>'
   . '<p><b>Now:</b> (1) delete <code>reset-admin.php</code> from your project and push, (2) remove RESET_TOKEN from Render, (3) <a href="admin/admin-index.php">log in</a>. If it says "too many attempts", wait one minute.</p>');
