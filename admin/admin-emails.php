<?php
require_once 'admin-include/db_config.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    if (($_POST['action'] ?? '') === 'clear') { run('DELETE FROM email_log'); flash_set('success', 'Email log cleared.'); }
    if (($_POST['action'] ?? '') === 'delete') { run('DELETE FROM email_log WHERE id = ?', [(int)($_POST['id'] ?? 0)]); }
    redirect('admin-emails.php');
}

$list = rows('SELECT * FROM email_log ORDER BY id DESC LIMIT 100');
$queued = (int)value("SELECT COUNT(*) FROM email_log WHERE status = 'queued'");

$page_title = 'Email Log';
$active     = 'emails';
require 'admin-include/header.php';
?>
<div class="page-head">
  <div>
    <h1>Email Log</h1>
    <p>Every e-mail the website creates (booking received, booking confirmed, password reset, new message alerts). The latest 100 are kept.</p>
  </div>
  <?php if ($list): ?>
    <form method="post" class="m-0" onsubmit="return confirm('Delete all entries in the email log?');"><?= csrf_field() ?><input type="hidden" name="action" value="clear">
      <button class="btn-danger-soft" type="submit">Clear log</button></form>
  <?php endif; ?>
</div>

<?php if (MAIL_MODE === 'log'): ?>
  <div class="panel-card">
    <h2>E-mail sending is not connected yet</h2>
    <div class="note mb-0">Nothing is lost: every e-mail waits here as <b>Queued</b>. When you add your e-mail service (see <code>admin/admin-include/mailer.php</code>), new e-mails will be sent automatically and marked <b>Sent</b>. Password-reset links also appear below, so guests who forget their password can be helped by you in the meantime (or use <i>Guests &rarr; Set password</i>).</div>
  </div>
<?php endif; ?>

<?php if (!$list): ?>
  <div class="panel-card empty-state"><i class="fa-regular fa-paper-plane"></i>No e-mails yet. They appear when a guest books, registers or sends a message.</div>
<?php else: ?>
<div class="table-wrap">
  <table class="admin-table">
    <thead><tr><th>When</th><th>To</th><th>Subject</th><th>Status</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($list as $m): ?>
      <tr>
        <td style="white-space:nowrap"><?= e(date('d M Y, H:i', strtotime($m['created_at']))) ?></td>
        <td><?= e($m['to_email']) ?></td>
        <td style="min-width:320px">
          <details class="inline"><summary><b><?= e($m['subject']) ?></b></summary><pre class="mail-body"><?= e($m['body']) ?></pre><?php if ($m['error']): ?><div class="sub mt-1"><?= e($m['error']) ?></div><?php endif; ?></details>
        </td>
        <td><span class="st <?= e($m['status']) ?>"><?= e(ucfirst($m['status'])) ?></span></td>
        <td><form method="post" class="m-0"><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$m['id'] ?>"><button class="btn-danger-soft" type="submit" title="Delete"><i class="fa-solid fa-trash"></i></button></form></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php endif; ?>

<?php require 'admin-include/footer.php'; ?>
