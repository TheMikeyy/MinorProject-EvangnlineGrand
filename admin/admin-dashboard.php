<?php
require_once 'admin-include/db_config.php';
require_admin();

$page_title = 'Dashboard';
$active     = 'dashboard';
require 'admin-include/header.php';

$counts = [
    'lodges'   => [(int)value('SELECT COUNT(*) FROM lodges WHERE is_active = 1'),        'Lodges live',         'fa-solid fa-bed',          'admin-lodge.php'],
    'comforts' => [(int)value('SELECT COUNT(*) FROM comforts WHERE is_active = 1'),      'Comforts live',       'fa-solid fa-mug-saucer',   'admin-comforts.php'],
    'team'     => [(int)value('SELECT COUNT(*) FROM team_members'),                      'Team members',        'fa-solid fa-people-group', 'admin-team.php'],
    'reviews'  => [(int)value('SELECT COUNT(*) FROM testimonials WHERE is_active = 1'),  'Guest reviews',       'fa-solid fa-comments',     'admin-testimonials.php'],
    'slides'   => [(int)value('SELECT COUNT(*) FROM hero_slides WHERE is_active = 1'),   'Slideshow photos',    'fa-solid fa-images',       'admin-slides.php'],
    'messages' => [$unread,                                                              'Unread messages',     'fa-solid fa-envelope',     'admin-messages.php'],
];
$latest = rows('SELECT * FROM contact_messages ORDER BY created_at DESC, id DESC LIMIT 4');
?>

<div class="page-head">
  <div>
    <h1>Welcome, <?= e($_SESSION['admin_name'] ?? 'Admin') ?></h1>
    <p>You're signed in to the <?= e(setting('hotel_name')) ?> Administration Panel. Everything you change here goes live on the website straight away.</p>
  </div>
</div>

<div class="stat-grid">
  <?php foreach ($counts as [$num, $label, $icon, $href]): ?>
    <a class="stat-box" href="<?= e($href) ?>"><i class="<?= e($icon) ?>"></i><div class="num"><?= $num ?></div><div class="lbl"><?= e($label) ?></div></a>
  <?php endforeach; ?>
</div>

<div class="panel-card">
  <h2>Latest messages</h2>
  <div class="note">From the Contact page of the website.</div>
  <?php if (!$latest): ?>
    <p class="text-muted mb-0">No messages yet.</p>
  <?php else: foreach ($latest as $m): ?>
    <div class="d-flex justify-content-between gap-3 py-2 border-top flex-wrap">
      <div><b><?= e($m['name']) ?></b> &ndash; <?= e($m['subject']) ?> <?= $m['is_read'] ? '' : '<span class="badge-pill good ms-1">New</span>' ?></div>
      <div class="text-muted small"><?= e(date('d M Y, H:i', strtotime($m['created_at']))) ?></div>
    </div>
  <?php endforeach; ?>
    <a class="btn-soft mt-3" href="admin-messages.php">Open inbox</a>
  <?php endif; ?>
</div>

<?php require 'admin-include/footer.php'; ?>
