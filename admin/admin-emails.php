<?php
require_once 'admin-include/db_config.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    if (($_POST['action'] ?? '') === 'clear') { run('DELETE FROM email_log'); flash_set('success', 'Email log cleared.'); }
    if (($_POST['action'] ?? '') === 'delete') { run('DELETE FROM email_log WHERE id = ?', [(int)($_POST['id'] ?? 0)]); }
    if (($_POST['action'] ?? '') === 'test') {
        $to = trim(setting('notify_email')) ?: trim(setting('email'));
        send_mail($to, 'Test e-mail from your website', "This is a test e-mail from the " . setting('hotel_name') . " admin panel.\n\nIf you can read it, e-mail sending works.");
        $last = row('SELECT status, error FROM email_log ORDER BY id DESC LIMIT 1');
        if ($last && $last['status'] === 'sent')        { flash_set('success', 'Test e-mail sent to ' . $to . '. Check that inbox (and the spam folder).'); }
        elseif ($last && $last['status'] === 'failed')  { flash_set('error', 'The test e-mail could not be sent: ' . $last['error']); }
        else                                            { flash_set('error', 'E-mail sending is not connected yet, so the test e-mail was only saved in the log below.'); }
    }
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
  <div class="d-flex gap-2 flex-wrap">
  <form method="post" class="m-0"><?= csrf_field() ?><input type="hidden" name="action" value="test"><button class="btn btn-ink" type="submit"><i class="fa-solid fa-paper-plane me-1"></i> Send test e-mail</button></form>
  <?php if ($list): ?>
    <form method="post" class="m-0" onsubmit="return confirm('Delete all entries in the email log?');"><?= csrf_field() ?><input type="hidden" name="action" value="clear">
      <button class="btn-danger-soft" type="submit">Clear log</button></form>
  <?php endif; ?>
  </div>
</div>

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
