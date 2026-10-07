<?php
require_once 'admin-include/db_config.php';
require_admin();

/* quick "Confirm" button on a row */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    if (($_POST['action'] ?? '') === 'confirm') {
        $err = change_booking_status((int)($_POST['id'] ?? 0), 'confirmed', 'admin');
        flash_set($err ? 'error' : 'success', $err ?: 'Booking confirmed. The guest can see it in My Bookings.');
    }
    redirect('admin-bookings.php' . (!empty($_POST['back']) ? '?' . preg_replace('/[^A-Za-z0-9_=&%.\-]/', '', $_POST['back']) : ''));
}

$tab = $_GET['status'] ?? 'all';
$q   = trim((string)($_GET['q'] ?? ''));
$today = date('Y-m-d');
$tabs = [
    'all'       => ['All',       '1=1', []],
    'pending'   => ['Pending',   "status = 'pending'", []],
    'upcoming'  => ['Upcoming',  "status = 'confirmed' AND check_out >= ?", [$today]],
    'past'      => ['Past',      "(status = 'completed' OR (status = 'confirmed' AND check_out < ?))", [$today]],
    'cancelled' => ['Cancelled', "status IN ('cancelled','declined')", []],
];
if (!isset($tabs[$tab])) { $tab = 'all'; }

$where = $tabs[$tab][1]; $params = $tabs[$tab][2];
if ($q !== '') {
    $like = '%' . str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $q) . '%';
    $where .= ' AND (ref LIKE ? OR guest_name LIKE ? OR guest_email LIKE ? OR guest_phone LIKE ? OR lodge_name LIKE ?)';
    array_push($params, $like, $like, $like, $like, $like);
}
$perPage = 25;
$total = (int)value("SELECT COUNT(*) FROM bookings WHERE $where", $params);
$pages = max(1, (int)ceil($total / $perPage));
$page  = max(1, min($pages, (int)($_GET['page'] ?? 1)));
$list  = rows("SELECT * FROM bookings WHERE $where ORDER BY (status = 'pending') DESC, check_in DESC, id DESC LIMIT $perPage OFFSET " . (($page - 1) * $perPage), $params);

$counts = [];
foreach ($tabs as $k => [$lbl, $w, $p]) { $counts[$k] = (int)value("SELECT COUNT(*) FROM bookings WHERE $w", $p); }
$qs = function (array $over = []) use ($tab, $q, $page) {
    return 'admin-bookings.php?' . http_build_query(array_filter(array_merge(['status' => $tab === 'all' ? '' : $tab, 'q' => $q, 'page' => $page > 1 ? $page : ''], $over), fn($v) => $v !== '' && $v !== null));
};

$page_title = 'Bookings';
$active     = 'bookings';
require 'admin-include/header.php';
?>
<div class="page-head">
  <div>
    <h1>Bookings</h1>
    <p>Booking requests from guests, and bookings you add yourself for phone or walk-in guests. Pending requests are shown first.</p>
  </div>
  <a href="admin-booking.php?new=1" class="btn btn-ink"><i class="fa-solid fa-plus me-1"></i> New booking</a>
</div>

<div class="tabs-row">
  <?php foreach ($tabs as $k => [$lbl]): ?>
    <a href="<?= e($qs(['status' => $k === 'all' ? '' : $k, 'page' => ''])) ?>" class="<?= $tab === $k ? 'active' : '' ?>"><?= e($lbl) ?> (<?= $counts[$k] ?>)</a>
  <?php endforeach; ?>
</div>

<form method="get" class="search-row">
  <?php if ($tab !== 'all'): ?><input type="hidden" name="status" value="<?= e($tab) ?>"><?php endif; ?>
  <input type="search" class="form-control" name="q" value="<?= e($q) ?>" placeholder="Search reference, guest, phone, email or lodge">
  <button class="btn btn-ink" type="submit">Search</button>
  <?php if ($q !== ''): ?><a class="btn btn-soft" href="<?= e($qs(['q' => '', 'page' => ''])) ?>">Clear</a><?php endif; ?>
</form>

<?php if (!$list): ?>
  <div class="panel-card empty-state"><i class="fa-regular fa-calendar"></i>No bookings found here.</div>
<?php else: ?>
<div class="table-wrap">
  <table class="admin-table">
    <thead><tr><th>Reference</th><th>Guest</th><th>Lodge</th><th>Stay</th><th>Guests</th><th>Total</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
    <?php foreach ($list as $b): [$label, $key] = booking_status_info($b); ?>
      <tr>
        <td><a class="ref" href="admin-booking.php?id=<?= (int)$b['id'] ?>"><?= e($b['ref']) ?></a><div class="sub"><?= e(date('d M, H:i', strtotime($b['created_at']))) ?><?= $b['source'] === 'admin' ? ' · added by hotel' : '' ?></div></td>
        <td><?= e($b['guest_name'] ?: '—') ?><div class="sub"><?= e($b['guest_phone']) ?></div></td>
        <td><?= e($b['lodge_name']) ?></td>
        <td><?= e(date('d M Y', strtotime($b['check_in']))) ?> → <?= e(date('d M Y', strtotime($b['check_out']))) ?><div class="sub"><?= (int)$b['nights'] ?> night<?= $b['nights'] > 1 ? 's' : '' ?></div></td>
        <td><?= (int)$b['adults'] ?>A<?= (int)$b['children'] > 0 ? ' + ' . (int)$b['children'] . 'C' : '' ?></td>
        <td>₹<?= e(inr($b['total'])) ?></td>
        <td><span class="st <?= e($key) ?>"><?= e($label) ?></span></td>
        <td>
          <div class="actions">
            <?php if ($b['status'] === 'pending'): ?>
              <form method="post" class="m-0"><?= csrf_field() ?><input type="hidden" name="action" value="confirm"><input type="hidden" name="id" value="<?= (int)$b['id'] ?>"><input type="hidden" name="back" value="<?= e(parse_url($qs(), PHP_URL_QUERY) ?? '') ?>">
                <button class="btn-soft" type="submit">Confirm</button></form>
            <?php endif; ?>
            <a class="btn-soft" href="admin-booking.php?id=<?= (int)$b['id'] ?>">Open</a>
          </div>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php if ($pages > 1): ?>
  <div class="pager">
    <?php for ($i = 1; $i <= $pages; $i++): ?><a class="btn-soft <?= $i === $page ? 'active' : '' ?>" style="<?= $i === $page ? 'background:var(--ink);color:#fff' : '' ?>" href="<?= e($qs(['page' => $i > 1 ? $i : ''])) ?>"><?= $i ?></a><?php endfor; ?>
  </div>
<?php endif; ?>
<?php endif; ?>

<?php require 'admin-include/footer.php'; ?>
