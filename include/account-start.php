<?php
/* Shared left-panel layout of the guest account area (looks like the admin panel).
   Before including: $user (logged-in guest), $acct_active ('bookings'|'profile'|'password'), $acct_title, $acct_intro */
$acctUpcoming = (int)value("SELECT COUNT(*) FROM bookings WHERE user_id = ? AND status IN ('pending','confirmed') AND check_out >= CURDATE()", [$user['id']]);
$acctLinks = [
    ['My account', [
        ['bookings', 'my-bookings.php',          'fa-solid fa-calendar-check', 'My Bookings'],
        ['profile',  'profile.php',              'fa-solid fa-user',           'My Profile'],
        ['password', 'profile.php?tab=password', 'fa-solid fa-key',            'Change Password'],
    ]],
    ['Hotel', [
        ['lodges',   'lodges.php',               'fa-solid fa-bed',            'Book a Lodge'],
        ['contact',  'contact.php',              'fa-solid fa-envelope',       'Contact Us'],
    ]],
];
?>
<div class="acct-layout">
  <aside class="acct-side">
    <div class="acct-user">
      <?= user_avatar($user, 52) ?>
      <div><b><?= e($user['name']) ?></b><small><?= e($user['email']) ?></small></div>
    </div>
    <?php foreach ($acctLinks as [$group, $items]): ?>
      <div class="acct-title"><?= e($group) ?></div>
      <?php foreach ($items as [$id, $href, $icon, $label]): ?>
        <a class="acct-link <?= $acct_active === $id ? 'active' : '' ?>" href="<?= e($href) ?>">
          <i class="<?= e($icon) ?>"></i><?= e($label) ?>
          <?php if ($id === 'bookings' && $acctUpcoming > 0): ?><span class="acct-badge"><?= $acctUpcoming ?></span><?php endif; ?>
        </a>
      <?php endforeach; ?>
    <?php endforeach; ?>
    <div class="acct-title">Session</div>
    <form method="post" action="logout.php" class="m-0"><?= csrf_field() ?>
      <button type="submit" class="acct-link"><i class="fa-solid fa-right-from-bracket"></i>Logout</button>
    </form>
  </aside>

  <main class="acct-main">
    <div class="acct-head">
      <h1><?= e($acct_title) ?></h1>
      <p><?= e($acct_intro) ?></p>
    </div>
