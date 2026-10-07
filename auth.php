<?php
/*
 * Handles the Sign up, Login and Forgot-password pop-ups of the website (POST only).
 * On a mistake the visitor is sent back to the same page with the pop-up re-opened and the problem shown.
 */
require_once __DIR__ . '/admin/admin-include/db_config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('index.php'); }
csrf_check();

$action = $_GET['action'] ?? '';
$return = safe_return($_POST['return'] ?? '');

function auth_fail(string $which, array $errors, array $old, string $return): void {
    unset($old['password'], $old['confirm_password']);
    $_SESSION['auth_modal'] = ['which' => $which, 'errors' => $errors, 'old' => $old, 'return' => $return];
    redirect($return);
}

/* ============================== SIGN UP ============================== */
if ($action === 'signup') {
    $d = [];
    foreach (['name', 'email', 'phone', 'address', 'pincode', 'dob'] as $k) { $d[$k] = trim((string)($_POST[$k] ?? '')); }
    $pass = (string)($_POST['password'] ?? ''); $conf = (string)($_POST['confirm_password'] ?? '');
    $errors = [];

    if (mb_strlen($d['name']) < 2 || mb_strlen($d['name']) > 100)                       { $errors[] = 'Please enter your full name.'; }
    if (!filter_var($d['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($d['email']) > 150) { $errors[] = 'Please enter a valid email address.'; }
    elseif (value('SELECT COUNT(*) FROM users WHERE email = ?', [$d['email']]))          { $errors[] = 'An account with this email already exists. Please log in instead.'; }
    if (!valid_phone($d['phone']))                                                       { $errors[] = 'Please enter a valid phone number.'; }
    if (mb_strlen($d['address']) < 5 || mb_strlen($d['address']) > 300)                  { $errors[] = 'Please enter your address (at least 5 characters).'; }
    if (!valid_pincode($d['pincode']))                                                   { $errors[] = 'Please enter a valid pin code.'; }
    $dob = parse_dob($d['dob']);
    if (!$dob)                       { $errors[] = 'Please enter your date of birth.'; }
    elseif (!is_adult($dob))         { $errors[] = 'You must be at least 18 years old to create an account.'; }
    if (strlen($pass) < 8)           { $errors[] = 'The password must be at least 8 characters long.'; }
    elseif ($pass !== $conf)         { $errors[] = 'The password and its confirmation do not match.'; }

    $picture = null;
    if (!$errors) {
        $err = null; $picture = upload_image('picture', $err);
        if ($err) { $errors[] = 'Profile picture: ' . $err; }
    }
    if ($errors) { auth_fail('signup', $errors, $d, $return); }

    try {
        run('INSERT INTO users (name, email, phone, address, pincode, dob, password_hash, picture) VALUES (?,?,?,?,?,?,?,?)',
            [$d['name'], $d['email'], $d['phone'], $d['address'], $d['pincode'], $dob->format('Y-m-d'), password_hash($pass, PASSWORD_DEFAULT), $picture]);
    } catch (PDOException $ex) {
        delete_uploaded_image($picture);
        auth_fail('signup', ['An account with this email already exists. Please log in instead.'], $d, $return);
    }
    $u = row('SELECT * FROM users WHERE id = ?', [(int)$GLOBALS['pdo']->lastInsertId()]);
    login_user($u);
    send_mail($u['email'], 'Welcome to ' . setting('hotel_name'), "Dear {$u['name']},\n\nYour account has been created. You can now book your stay online and follow your bookings in My Bookings:\n" . site_url('my-bookings.php') . "\n\nWarm regards,\n" . setting('hotel_name'));
    toast_set('success', 'Welcome, ' . explode(' ', $u['name'])[0] . '! Your account has been created.');
    redirect($return);
}

/* ============================== LOGIN ============================== */
if ($action === 'login') {
    $email = trim((string)($_POST['email'] ?? '')); $pass = (string)($_POST['password'] ?? '');
    if ($email === '' || $pass === '') { auth_fail('login', ['Please enter your email and password.'], ['email' => $email], $return); }
    if (login_throttled($email))       { auth_fail('login', ['Too many attempts. Please wait a few minutes and try again.'], ['email' => $email], $return); }

    $u = row('SELECT * FROM users WHERE email = ?', [$email]);
    if (!$u || !password_verify($pass, $u['password_hash'])) {
        login_fail_record($email);
        auth_fail('login', ['Incorrect email or password.'], ['email' => $email], $return);
    }
    if (!(int)$u['is_active']) { auth_fail('login', ['This account has been disabled. Please contact the hotel.'], ['email' => $email], $return); }

    if (password_needs_rehash($u['password_hash'], PASSWORD_DEFAULT)) {
        run('UPDATE users SET password_hash = ? WHERE id = ?', [password_hash($pass, PASSWORD_DEFAULT), $u['id']]);
    }
    login_fail_clear($email);
    login_user($u);
    if (!empty($_POST['remember'])) { remember_issue((int)$u['id']); }
    toast_set('success', 'Welcome back, ' . explode(' ', $u['name'])[0] . '!');
    redirect($return);
}

/* ============================== FORGOT PASSWORD ============================== */
if ($action === 'forgot') {
    $email = trim((string)($_POST['email'] ?? ''));
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { auth_fail('forgot', ['Please enter a valid email address.'], ['email' => $email], $return); }

    $u = row('SELECT * FROM users WHERE email = ? AND is_active = 1', [$email]);
    if ($u && (int)value("SELECT COUNT(*) FROM password_resets WHERE user_id = ? AND created_at > (NOW() - INTERVAL 1 HOUR)", [$u['id']]) < 3) {
        run('UPDATE password_resets SET used_at = NOW() WHERE user_id = ? AND used_at IS NULL', [$u['id']]);   // old links stop working
        $token = bin2hex(random_bytes(32));
        run('INSERT INTO password_resets (user_id, token_hash, expires_at) VALUES (?, ?, NOW() + INTERVAL 1 HOUR)', [$u['id'], hash('sha256', $token)]);
        send_mail($u['email'], 'Reset your password - ' . setting('hotel_name'),
            "Dear {$u['name']},\n\nWe received a request to reset your password. Open this link within 1 hour to choose a new one:\n\n"
            . site_url('reset-password.php?token=' . $token) . "\n\nIf you did not ask for this, you can ignore this e-mail.\n\n" . setting('hotel_name'));
    }
    // same answer whether or not the account exists (so nobody can discover who has an account)
    toast_set('success', 'If an account exists for that email, a password reset link has been sent to it.');
    redirect($return);
}

redirect('index.php');
