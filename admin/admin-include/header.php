<?php
/*
 * Shared top of every admin page (protected: redirects to the login if not signed in).
 * Before including it, a page sets:   $page_title = 'Lodges';   $active = 'lodges';
 */
require_once __DIR__ . '/db_config.php';
require_admin();

$page_title = $page_title ?? 'Admin';
$active     = $active ?? '';
$unread     = (int)value('SELECT COUNT(*) FROM contact_messages WHERE is_read = 0');

$menu = [
    ['Overview', [
        ['dashboard',    'admin-dashboard.php',    'fa-solid fa-gauge-high',    'Dashboard'],
    ]],
    ['Website content', [
        ['content',      'admin-setting.php',      'fa-solid fa-sliders',       'Site Content'],
        ['slides',       'admin-slides.php',       'fa-solid fa-images',        'Home Slideshow'],
        ['lodges',       'admin-lodge.php',        'fa-solid fa-bed',           'Lodges'],
        ['comforts',     'admin-comforts.php',     'fa-solid fa-mug-saucer',    'Comforts'],
        ['team',         'admin-team.php',         'fa-solid fa-people-group',  'Team'],
        ['testimonials', 'admin-testimonials.php', 'fa-solid fa-comments',      'Guest Reviews'],
    ]],
    ['Inbox & account', [
        ['messages',     'admin-messages.php',     'fa-solid fa-envelope',      'Messages'],
        ['password',     'admin-password.php',     'fa-solid fa-key',           'Account & Password'],
    ]],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($page_title) ?> | Administration Panel | <?= e(setting('hotel_name')) ?></title>
    <?php require __DIR__ . '/links.php'; ?>
    <link rel="stylesheet" href="admin.css">
</head>
<body class="admin-body">

<nav class="navbar navbar-scrolled admin-navbar">
  <div class="container-fluid">
    <a class="navbar-brand" href="admin-dashboard.php">
      <img src="admin-images/logo/logo-light.png" alt="<?= e(setting('hotel_name')) ?>" class="logo-img">
      <span class="admin-brand-label">Administration Panel</span>
    </a>
    <div class="d-flex">
      <a href="../index.php" class="btn btn-outline-dark shadow-none me-lg-3 me-3">
        <span class="d-none d-sm-inline">Back to Your Website</span><span class="d-sm-none">Back</span>
      </a>
      <a href="admin-logout.php" class="btn btn-dark shadow-none custom-bg">Logout</a>
    </div>
  </div>
</nav>

<div class="admin-layout">
  <aside class="admin-side">
    <?php foreach ($menu as [$group, $items]): ?>
      <div class="side-title"><?= e($group) ?></div>
      <?php foreach ($items as [$id, $href, $icon, $label]): ?>
        <a class="side-link <?= $active === $id ? 'active' : '' ?>" href="<?= e($href) ?>">
          <i class="<?= e($icon) ?>"></i><?= e($label) ?>
          <?php if ($id === 'messages' && $unread > 0): ?><span class="side-badge"><?= $unread ?></span><?php endif; ?>
        </a>
      <?php endforeach; ?>
    <?php endforeach; ?>
  </aside>

  <main class="admin-main">
    <?php foreach (flash_take() as $fl): ?>
      <div class="flash <?= e($fl['type']) ?>"><?= e($fl['msg']) ?></div>
    <?php endforeach; ?>
