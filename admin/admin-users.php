<?php
require_once 'admin-include/db_config.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? ''; $id = (int)($_POST['id'] ?? 0);
    $u = row('SELECT * FROM users WHERE id = ?', [$id]);
    if (!$u) { flash_set('error', 'Guest not found.'); redirect('admin-users.php'); }

    if ($action === 'toggle') {
        run('UPDATE users SET is_active = ? WHERE id = ?', [$u['is_active'] ? 0 : 1, $id]);
        flash_set('success', $u['name'] . ($u['is_active'] ? ' was disabled and cannot log in.' : ' can log in again.'));
    } elseif ($action === 'password') {
        $pw = (string)($_POST['new_password'] ?? '');
        if (strlen($pw) < 8) { flash_set('error', 'The password must be at least 8 characters long.'); }
        else {
            run('UPDATE users SET password_hash = ? WHERE id = ?', [password_hash($pw, PASSWORD_DEFAULT), $id]);
            run('UPDATE password_resets SET used_at = NOW() WHERE user_id = ?', [$id]);
            remember_forget($id);
            flash_set('success', 'New password set for ' . $u['name'] . '. Tell the guest, and ask them to change it in My Profile.');
        }
    } elseif ($action === 'delete') {
        run('UPDATE bookings SET user_id = NULL WHERE user_id = ?', [$id]);      // the hotel keeps the booking records
        run('DELETE FROM password_resets WHERE user_id = ?', [$id]);
        remember_forget($id);
        run('DELETE FROM users WHERE id = ?', [$id]);
        delete_uploaded_image($u['picture']);
        flash_set('success', 'Guest account deleted. Their past bookings were kept in Bookings.');
    }
    redirect('admin-users.php' . (!empty($_POST['q']) ? '?q=' . urlencode($_POST['q']) : ''));
}

$q = trim((string)($_GET['q'] ?? ''));
$where = '1=1'; $params = [];
if ($q !== '') {
    $like = '%' . str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $q) . '%';
    $where = '(u.name LIKE ? OR u.email LIKE ? OR u.phone LIKE ?)'; $params = [$like, $like, $like];
}
$perPage = 25;
$total = (int)value("SELECT COUNT(*) FROM users u WHERE $where", $params);
$pages = max(1, (int)ceil($total / $perPage));
$page  = max(1, min($pages, (int)($_GET['page'] ?? 1)));
$list = rows("SELECT u.*, (SELECT COUNT(*) FROM bookings b WHERE b.user_id = u.id) AS booking_count FROM users u WHERE $where ORDER BY u.created_at DESC, u.id DESC LIMIT $perPage OFFSET " . (($page - 1) * $perPage), $params);

$page_title = 'Guests';
$active     = 'users';
require 'admin-include/header.php';
?>
<div class="page-head">
  <div>
    <h1>Guests</h1>
    <p><?= $total ?> registered guest<?= $total === 1 ? '' : 's' ?>. You can disable an account, set a new password for a guest who cannot reset it, or delete the account.</p>
  </div>
</div>

<form method="get" class="search-row">
  <input type="search" class="form-control" name="q" value="<?= e($q) ?>" placeholder="Search name, email or phone">
  <button class="btn btn-ink" type="submit">Search</button>
  <?php if ($q !== ''): ?><a class="btn btn-soft" href="admin-users.php">Clear</a><?php endif; ?>
</form>

<?php if (!$list): ?>
  <div class="panel-card empty-state"><i class="fa-regular fa-user"></i>No guests found.</div>
<?php else: ?>
<div class="table-wrap">
  <table class="admin-table">
    <thead><tr><th>Guest</th><th>Contact</th><th>Address</th><th>Registered</th><th>Bookings</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
    <?php foreach ($list as $u): ?>
      <tr>
        <td>
          <div class="d-flex align-items-center gap-2">
            <?php if ($u['picture']): ?><img class="avatar-sm" src="../<?= e(asset($u['picture'])) ?>" alt=""><?php else: ?><span class="avatar-sm"><?= e(mb_strtoupper(mb_substr($u['name'], 0, 1))) ?></span><?php endif; ?>
            <div><b><?= e($u['name']) ?></b><div class="sub">Born <?= e($u['dob'] ? date('d M Y', strtotime($u['dob'])) : '—') ?></div></div>
          </div>
        </td>
        <td><a href="mailto:<?= e($u['email']) ?>" style="color:var(--ink)"><?= e($u['email']) ?></a><div class="sub"><?= e($u['phone']) ?></div></td>
        <td style="max-width:240px"><?= e($u['address']) ?><div class="sub"><?= e($u['pincode']) ?></div></td>
        <td><?= e(date('d M Y', strtotime($u['created_at']))) ?><div class="sub"><?= $u['last_login_at'] ? 'Last login ' . e(date('d M, H:i', strtotime($u['last_login_at']))) : 'Never logged in again' ?></div></td>
        <td><?php if ($u['booking_count']): ?><a href="admin-bookings.php?q=<?= urlencode($u['email']) ?>" style="color:var(--ink)"><?= (int)$u['booking_count'] ?></a><?php else: ?>0<?php endif; ?></td>
        <td><span class="st <?= $u['is_active'] ? 'active' : 'disabled' ?>"><?= $u['is_active'] ? 'Active' : 'Disabled' ?></span></td>
        <td>
          <div class="actions">
            <form method="post" class="m-0"><?= csrf_field() ?><input type="hidden" name="action" value="toggle"><input type="hidden" name="id" value="<?= (int)$u['id'] ?>"><input type="hidden" name="q" value="<?= e($q) ?>">
              <button class="btn-soft" type="submit"><?= $u['is_active'] ? 'Disable' : 'Enable' ?></button></form>
            <details class="inline">
              <summary class="btn-soft">Set password</summary>
              <form method="post" class="box" autocomplete="off"><?= csrf_field() ?><input type="hidden" name="action" value="password"><input type="hidden" name="id" value="<?= (int)$u['id'] ?>"><input type="hidden" name="q" value="<?= e($q) ?>">
                <input type="text" class="form-control mb-2" name="new_password" placeholder="New password (8+ characters)" minlength="8" required autocomplete="off">
                <button class="btn btn-ink btn-sm" type="submit">Save</button></form>
            </details>
            <form method="post" class="m-0" onsubmit="return confirm('Delete this guest account? Their bookings are kept, but they can no longer log in.');"><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$u['id'] ?>"><input type="hidden" name="q" value="<?= e($q) ?>">
              <button class="btn-danger-soft" type="submit"><i class="fa-solid fa-trash"></i></button></form>
          </div>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php if ($pages > 1): ?>
  <div class="pager"><?php for ($i = 1; $i <= $pages; $i++): ?><a class="btn-soft" style="<?= $i === $page ? 'background:var(--ink);color:#fff' : '' ?>" href="admin-users.php?<?= e(http_build_query(array_filter(['q' => $q, 'page' => $i > 1 ? $i : '']))) ?>"><?= $i ?></a><?php endfor; ?></div>
<?php endif; ?>
<?php endif; ?>

<?php require 'admin-include/footer.php'; ?>
