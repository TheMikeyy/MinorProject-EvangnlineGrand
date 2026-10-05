<?php
require_once 'admin-include/db_config.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';
    $id = (int)($_POST['id'] ?? 0);
    if ($action === 'read' && $id)        { run('UPDATE contact_messages SET is_read = 1 WHERE id = ?', [$id]); }
    elseif ($action === 'unread' && $id)  { run('UPDATE contact_messages SET is_read = 0 WHERE id = ?', [$id]); }
    elseif ($action === 'delete' && $id)  { run('DELETE FROM contact_messages WHERE id = ?', [$id]); flash_set('success', 'Message deleted.'); }
    elseif ($action === 'allread')        { run('UPDATE contact_messages SET is_read = 1'); flash_set('success', 'All messages marked as read.'); }
    redirect('admin-messages.php');
}

$page_title = 'Messages';
$active     = 'messages';
require 'admin-include/header.php';
$messages = rows('SELECT * FROM contact_messages ORDER BY created_at DESC, id DESC LIMIT 200');
?>
<div class="page-head">
  <div>
    <h1>Messages</h1>
    <p>Messages sent by visitors from the Contact page of the website. Newest first.</p>
  </div>
  <?php if ($unread > 0): ?>
    <form method="post" class="m-0"><?= csrf_field() ?><input type="hidden" name="action" value="allread">
      <button class="btn btn-soft" type="submit"><i class="fa-solid fa-check-double me-1"></i> Mark all as read</button></form>
  <?php endif; ?>
</div>

<?php if (!$messages): ?>
  <div class="panel-card empty-state"><i class="fa-regular fa-envelope-open"></i>No messages yet. When a visitor uses the contact form, it will appear here.</div>
<?php endif; ?>

<?php foreach ($messages as $m): ?>
  <div class="msg-card <?= $m['is_read'] ? '' : 'unread' ?>">
    <div class="meta">
      <b><?= e($m['name']) ?></b> &middot; <a href="mailto:<?= e($m['email']) ?>?subject=<?= rawurlencode('Re: ' . $m['subject']) ?>"><?= e($m['email']) ?></a>
      &middot; <?= e(date('d M Y, H:i', strtotime($m['created_at']))) ?>
      <?php if (!$m['is_read']): ?><span class="badge-pill warn ms-1">New</span><?php endif; ?>
    </div>
    <h3><?= e($m['subject']) ?></h3>
    <div class="text"><?= e($m['message']) ?></div>
    <div class="d-flex gap-2 mt-3 flex-wrap">
      <a class="btn-soft" href="mailto:<?= e($m['email']) ?>?subject=<?= rawurlencode('Re: ' . $m['subject']) ?>"><i class="fa-solid fa-reply me-1"></i>Reply by email</a>
      <form method="post" class="m-0"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$m['id'] ?>">
        <button class="btn-soft" name="action" value="<?= $m['is_read'] ? 'unread' : 'read' ?>" type="submit"><?= $m['is_read'] ? 'Mark as unread' : 'Mark as read' ?></button></form>
      <form method="post" class="m-0" onsubmit="return confirm('Delete this message?');"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$m['id'] ?>">
        <button class="btn-danger-soft" name="action" value="delete" type="submit"><i class="fa-solid fa-trash"></i></button></form>
    </div>
  </div>
<?php endforeach; ?>

<?php require 'admin-include/footer.php'; ?>
