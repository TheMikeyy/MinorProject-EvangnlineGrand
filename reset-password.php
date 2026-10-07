<?php
require_once __DIR__ . '/admin/admin-include/db_config.php';

$token = (string)($_REQUEST['token'] ?? '');
$reset = null;
if (preg_match('/^[a-f0-9]{64}$/', $token)) {
    $reset = row('SELECT * FROM password_resets WHERE token_hash = ? AND used_at IS NULL AND expires_at > NOW()', [hash('sha256', $token)]);
}

$errors = [];
if ($reset && $_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $new = (string)($_POST['new_password'] ?? ''); $conf = (string)($_POST['confirm_password'] ?? '');
    if (strlen($new) < 8)   { $errors[] = 'The password must be at least 8 characters long.'; }
    elseif ($new !== $conf) { $errors[] = 'The password and its confirmation do not match.'; }
    if (!$errors) {
        run('UPDATE users SET password_hash = ? WHERE id = ? AND is_active = 1', [password_hash($new, PASSWORD_DEFAULT), $reset['user_id']]);
        run('UPDATE password_resets SET used_at = NOW() WHERE user_id = ?', [$reset['user_id']]);        // every older link dies too
        $_SESSION['auth_modal'] = ['which' => 'login', 'errors' => [], 'old' => [], 'return' => 'index.php'];
        toast_set('success', 'Your password has been changed. You can now log in.');
        redirect('index.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password | <?= e(setting('hotel_name')) ?></title>
  <?php require('include/links.php') ?>
</head>
<body>

<?php require('include/navbar.php') ?>

<div class="page-hero-lite">
  <div class="container">
    <span class="section-eyebrow on-dark d-block">Your Account</span>
    <h2 class="mb-0 fw-bold section-font on-dark">RESET PASSWORD</h2>
  </div>
</div>

<div class="container my-5" style="max-width: 560px;">
<?php if (!$reset): ?>
  <div class="g-card empty-box">
    <i class="bi bi-link-45deg"></i>
    <h4 class="mt-3">This link is not valid</h4>
    <p class="text-secondary">It may have expired or already been used. Please request a new password reset link.</p>
    <a href="index.php" class="btn text-white custom-bg shadow-none rounded-pill px-4">Back to home</a>
  </div>
<?php else: ?>
  <form method="post" class="g-card" autocomplete="off">
    <?= csrf_field() ?><input type="hidden" name="token" value="<?= e($token) ?>">
    <h4 class="mb-3">Choose a new password</h4>
    <?php foreach ($errors as $er): ?><div class="alert alert-danger py-2"><?= e($er) ?></div><?php endforeach; ?>
    <div class="mb-3"><label class="form-label">New password</label>
      <input type="password" name="new_password" class="form-control shadow-none" required minlength="8" autocomplete="new-password">
      <div class="form-text">At least 8 characters.</div></div>
    <div class="mb-4"><label class="form-label">Confirm new password</label>
      <input type="password" name="confirm_password" class="form-control shadow-none" required minlength="8" autocomplete="new-password"></div>
    <button type="submit" class="btn text-white custom-bg shadow-none rounded-pill px-4">Save new password</button>
  </form>
<?php endif; ?>
</div>

<?php require('include/footer.php') ?>
</body>
</html>
