<?php
require_once __DIR__ . '/admin/admin-include/db_config.php';
$user = require_user();

$tab = (($_GET['tab'] ?? $_POST['tab'] ?? '') === 'password') ? 'password' : 'profile';
$errors = []; $pwErrors = [];
$d = ['name' => $user['name'], 'phone' => $user['phone'], 'address' => $user['address'], 'pincode' => $user['pincode'], 'dob' => (string)$user['dob']];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';

    if ($action === 'details') {
        foreach ($d as $k => $unused) { $d[$k] = trim((string)($_POST[$k] ?? '')); }
        if (mb_strlen($d['name']) < 2 || mb_strlen($d['name']) > 100) { $errors[] = 'Please enter your full name.'; }
        if (!valid_phone($d['phone']))                                { $errors[] = 'Please enter a valid phone number.'; }
        if (mb_strlen($d['address']) < 5 || mb_strlen($d['address']) > 300) { $errors[] = 'Please enter your address (at least 5 characters).'; }
        if (!valid_pincode($d['pincode']))                            { $errors[] = 'Please enter a valid pin code.'; }
        $dob = parse_dob($d['dob']);
        if (!$dob)               { $errors[] = 'Please enter your date of birth.'; }
        elseif (!is_adult($dob)) { $errors[] = 'You must be at least 18 years old.'; }

        $newPic = null;
        if (!$errors) { $err = null; $newPic = upload_image('picture', $err); if ($err) { $errors[] = 'Profile picture: ' . $err; } }
        if (!$errors && isset($_POST['remove_picture']) && !$newPic) { delete_uploaded_image($user['picture']); run('UPDATE users SET picture = NULL WHERE id = ?', [$user['id']]); }
        if (!$errors) {
            run('UPDATE users SET name = ?, phone = ?, address = ?, pincode = ?, dob = ? WHERE id = ?', [$d['name'], $d['phone'], $d['address'], $d['pincode'], $dob->format('Y-m-d'), $user['id']]);
            if ($newPic) { run('UPDATE users SET picture = ? WHERE id = ?', [$newPic, $user['id']]); delete_uploaded_image($user['picture']); }
            toast_set('success', 'Your profile has been updated.');
            redirect('profile.php');
        }
        if (!empty($newPic)) { delete_uploaded_image($newPic); }
    }

    if ($action === 'password') {
        $tab = 'password';
        $cur = (string)($_POST['current_password'] ?? ''); $new = (string)($_POST['new_password'] ?? ''); $conf = (string)($_POST['confirm_password'] ?? '');
        if (!password_verify($cur, $user['password_hash'])) { $pwErrors[] = 'Your current password is not correct.'; }
        if (strlen($new) < 8)  { $pwErrors[] = 'The new password must be at least 8 characters long.'; }
        elseif ($new !== $conf) { $pwErrors[] = 'The new password and its confirmation do not match.'; }
        if (!$pwErrors) {
            run('UPDATE users SET password_hash = ? WHERE id = ?', [password_hash($new, PASSWORD_DEFAULT), $user['id']]);
            session_regenerate_id(true);
            remember_forget((int)$user['id']);          // signs the account out of every other device
            toast_set('success', 'Your password has been changed.');
            redirect('profile.php?tab=password');
        }
    }
}
$user = current_user(true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $tab === 'password' ? 'Change Password' : 'My Profile' ?> | <?= e(setting('hotel_name')) ?></title>
  <?php require('include/links.php') ?>
</head>
<body>

<?php $navbar_solid = true; require('include/navbar.php') ?>

<?php
  $acct_active = $tab;
  $acct_title  = $tab === 'password' ? 'Change Password' : 'My Profile';
  $acct_intro  = $tab === 'password' ? 'Choose a new password for your account. You will stay logged in on this device.'
                                     : 'The details you gave when you registered. You can change them any time.';
  require('include/account-start.php');
?>

<?php if ($tab === 'profile'): ?>

  <div class="acct-card">
    <h2>Your information</h2>
    <div class="d-flex align-items-center gap-4 mb-3 flex-wrap">
      <?php if (!empty($user['picture'])): ?>
        <img class="profile-avatar" src="<?= e(asset($user['picture'])) ?>" alt="">
      <?php else: ?>
        <span class="profile-avatar user-avatar user-avatar-initial"><?= e(mb_strtoupper(mb_substr($user['name'], 0, 1))) ?></span>
      <?php endif; ?>
      <div><div style="font-family:'DM Serif Display',serif;font-size:1.5rem;color:var(--ink)"><?= e($user['name']) ?></div>
        <div class="text-secondary"><?= e($user['email']) ?></div></div>
    </div>
    <div class="acct-kv"><span>Phone number</span><span><?= e($user['phone']) ?></span></div>
    <div class="acct-kv"><span>Communication address</span><span><?= e($user['address']) ?></span></div>
    <div class="acct-kv"><span>Pin code</span><span><?= e($user['pincode']) ?></span></div>
    <div class="acct-kv"><span>Date of birth</span><span><?= $user['dob'] ? e(date('d M Y', strtotime($user['dob']))) : '—' ?></span></div>
    <div class="acct-kv"><span>Member since</span><span><?= e(date('d M Y', strtotime($user['created_at']))) ?></span></div>
  </div>

  <form method="post" enctype="multipart/form-data" class="acct-card" id="edit">
    <?= csrf_field() ?><input type="hidden" name="action" value="details">
    <h2>Edit your details</h2>
    <?php foreach ($errors as $er): ?><div class="alert alert-danger py-2"><?= e($er) ?></div><?php endforeach; ?>

    <div class="mb-4">
      <label class="form-label">Profile picture</label>
      <input type="file" name="picture" class="form-control shadow-none" accept="image/jpeg,image/png,image/webp,image/gif" style="max-width:420px">
      <?php if (!empty($user['picture'])): ?><label class="form-check mt-2 small"><input type="checkbox" class="form-check-input" name="remove_picture" value="1"> <span class="ms-1">Remove my picture</span></label><?php endif; ?>
    </div>

    <div class="row g-3">
      <div class="col-md-6"><label class="form-label">Full name</label>
        <input type="text" name="name" class="form-control shadow-none" required maxlength="100" value="<?= e($d['name']) ?>"></div>
      <div class="col-md-6"><label class="form-label">Email address</label>
        <input type="email" class="form-control shadow-none" value="<?= e($user['email']) ?>" disabled>
        <div class="form-text">To change your email, please contact the hotel.</div></div>
      <div class="col-md-6"><label class="form-label">Phone number</label>
        <input type="tel" name="phone" class="form-control shadow-none" required maxlength="20" value="<?= e($d['phone']) ?>"></div>
      <div class="col-md-6"><label class="form-label">Date of birth</label>
        <input type="date" name="dob" class="form-control shadow-none" required max="<?= e(date('Y-m-d', strtotime('-18 years'))) ?>" value="<?= e($d['dob']) ?>"></div>
      <div class="col-12"><label class="form-label">Communication address</label>
        <textarea name="address" class="form-control shadow-none" rows="2" required maxlength="300"><?= e($d['address']) ?></textarea></div>
      <div class="col-md-6"><label class="form-label">Pin code</label>
        <input type="text" name="pincode" class="form-control shadow-none" required maxlength="10" value="<?= e($d['pincode']) ?>"></div>
    </div>
    <button type="submit" class="btn text-white custom-bg shadow-none rounded-pill px-4 mt-4">Save changes</button>
  </form>

<?php else: ?>

  <form method="post" class="acct-card" autocomplete="off" style="max-width:640px">
    <?= csrf_field() ?><input type="hidden" name="action" value="password"><input type="hidden" name="tab" value="password">
    <h2>New password</h2>
    <?php foreach ($pwErrors as $er): ?><div class="alert alert-danger py-2"><?= e($er) ?></div><?php endforeach; ?>
    <div class="mb-3"><label class="form-label">Current password</label>
      <input type="password" name="current_password" class="form-control shadow-none" required autocomplete="current-password"></div>
    <div class="mb-3"><label class="form-label">New password</label>
      <input type="password" name="new_password" class="form-control shadow-none" required minlength="8" autocomplete="new-password">
      <div class="form-text">At least 8 characters.</div></div>
    <div class="mb-3"><label class="form-label">Confirm new password</label>
      <input type="password" name="confirm_password" class="form-control shadow-none" required minlength="8" autocomplete="new-password"></div>
    <button type="submit" class="btn text-white custom-bg shadow-none rounded-pill px-4 mt-2">Change password</button>
    <div class="form-text mt-3">For safety, changing your password signs you out on all your other devices.</div>
  </form>

<?php endif; ?>

<?php require('include/account-end.php') ?>

<?php require('include/footer.php') ?>
</body>
</html>
