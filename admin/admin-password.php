<?php
require_once 'admin-include/db_config.php';
require_admin();

$admin = row('SELECT * FROM admin_cred WHERE sr_no = ?', [(int)($_SESSION['admin_id'] ?? 0)]);
if (!$admin) { redirect('admin-logout.php'); }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $name    = trim((string)($_POST['admin_name'] ?? ''));
    $current = (string)($_POST['current_password'] ?? '');
    $new     = (string)($_POST['new_password'] ?? '');
    $confirm = (string)($_POST['confirm_password'] ?? '');

    if (!password_verify($current, $admin['admin_pass'])) { $errors[] = 'Your current password is not correct.'; }
    if ($name === '' || mb_strlen($name) > 150)            { $errors[] = 'Please enter a login name (up to 150 characters).'; }
    if ($new !== '') {
        if (strlen($new) < 8)      { $errors[] = 'The new password must be at least 8 characters long.'; }
        if ($new !== $confirm)     { $errors[] = 'The new password and its confirmation do not match.'; }
    }
    if ($name !== $admin['admin_mail'] && value('SELECT COUNT(*) FROM admin_cred WHERE admin_mail = ? AND sr_no <> ?', [$name, $admin['sr_no']])) {
        $errors[] = 'That login name is already used.';
    }

    if (!$errors) {
        if ($new !== '') {
            run('UPDATE admin_cred SET admin_mail = ?, admin_pass = ? WHERE sr_no = ?', [$name, password_hash($new, PASSWORD_DEFAULT), $admin['sr_no']]);
        } else {
            run('UPDATE admin_cred SET admin_mail = ? WHERE sr_no = ?', [$name, $admin['sr_no']]);
        }
        $_SESSION['admin_name'] = $name;
        flash_set('success', $new !== '' ? 'Your login details and password were updated.' : 'Your login name was updated.');
        redirect('admin-password.php');
    }
}

$page_title = 'Account & Password';
$active     = 'password';
require 'admin-include/header.php';
?>
<div class="page-head">
  <div>
    <h1>Account &amp; Password</h1>
    <p>Change the name and password used to sign in to this Administration Panel. Choose a strong password before handing the website to the hotel.</p>
  </div>
</div>

<?php foreach ($errors as $er): ?><div class="flash error"><?= e($er) ?></div><?php endforeach; ?>

<form method="post" class="panel-card" style="max-width:640px" autocomplete="off">
  <?= csrf_field() ?>
  <div class="mb-3">
    <label class="form-label" for="admin_name">Login name</label>
    <input type="text" class="form-control" id="admin_name" name="admin_name" value="<?= e($_POST['admin_name'] ?? $admin['admin_mail']) ?>" required maxlength="150">
  </div>
  <div class="mb-3">
    <label class="form-label" for="new_password">New password <span class="text-muted fw-normal">(leave empty to keep the current one)</span></label>
    <input type="password" class="form-control" id="new_password" name="new_password" autocomplete="new-password">
    <div class="form-text">At least 8 characters.</div>
  </div>
  <div class="mb-3">
    <label class="form-label" for="confirm_password">Confirm new password</label>
    <input type="password" class="form-control" id="confirm_password" name="confirm_password" autocomplete="new-password">
  </div>
  <hr>
  <div class="mb-3">
    <label class="form-label" for="current_password">Current password <span class="req">*</span></label>
    <input type="password" class="form-control" id="current_password" name="current_password" required autocomplete="current-password">
    <div class="form-text">Needed to confirm that it is really you.</div>
  </div>
  <button type="submit" class="btn btn-ink px-4"><i class="fa-solid fa-floppy-disk me-1"></i> Save</button>
</form>

<?php require 'admin-include/footer.php'; ?>
