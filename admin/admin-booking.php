<?php
require_once 'admin-include/db_config.php';
require_admin();

$errors = [];
$isNew = isset($_GET['new']) || (($_POST['action'] ?? '') === 'create');
$f = ['lodge_id' => (int)($_POST['lodge_id'] ?? 0), 'check_in' => trim((string)($_POST['check_in'] ?? '')), 'check_out' => trim((string)($_POST['check_out'] ?? '')),
      'adults' => max(1, (int)($_POST['adults'] ?? 2)), 'children' => max(0, (int)($_POST['children'] ?? 0)), 'guest_name' => trim((string)($_POST['guest_name'] ?? '')),
      'guest_phone' => trim((string)($_POST['guest_phone'] ?? '')), 'guest_email' => trim((string)($_POST['guest_email'] ?? '')),
      'requests' => trim((string)($_POST['requests'] ?? '')), 'status' => ($_POST['status'] ?? 'confirmed') === 'pending' ? 'pending' : 'confirmed', 'admin_note' => trim((string)($_POST['admin_note'] ?? ''))];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';

    if ($action === 'create') {
        if ($f['guest_name'] === '' || mb_strlen($f['guest_name']) > 100) { $errors[] = 'Please enter the guest name.'; }
        if ($f['guest_phone'] !== '' && !valid_phone($f['guest_phone'])) { $errors[] = 'The phone number is not valid.'; }
        if ($f['guest_email'] !== '' && !filter_var($f['guest_email'], FILTER_VALIDATE_EMAIL)) { $errors[] = 'The e-mail address is not valid.'; }
        if (!$errors) {
            $linked = $f['guest_email'] !== '' ? row('SELECT id FROM users WHERE email = ?', [$f['guest_email']]) : null;   // appears in the guest's My Bookings
            $res = create_booking($f + ['user_id' => $linked['id'] ?? null, 'source' => 'admin']);
            if ($res['ok']) {
                if ($res['booking']['status'] === 'confirmed') { email_booking_changed($res['booking'], 'admin'); }
                flash_set('success', 'Booking ' . $res['booking']['ref'] . ' created.');
                redirect('admin-booking.php?id=' . (int)$res['booking']['id']);
            }
            $errors[] = $res['error'];
        }
    } else {
        $id = (int)($_POST['id'] ?? 0);
        $note = trim((string)($_POST['note'] ?? ''));
        if ($action === 'note') {
            run('UPDATE bookings SET admin_note = ?, updated_at = NOW() WHERE id = ?', [mb_substr($note, 0, 1000), $id]);
            flash_set('success', 'Note saved.');
        } elseif (in_array($action, ['confirmed', 'declined', 'cancelled', 'completed'], true)) {
            $err = change_booking_status($id, $action, 'admin', $note);
            flash_set($err ? 'error' : 'success', $err ?: 'Booking updated to ' . $action . '.');
        }
        redirect('admin-booking.php?id=' . $id);
    }
}

$b = null;
if (!$isNew) {
    $b = row('SELECT * FROM bookings WHERE id = ?', [(int)($_GET['id'] ?? 0)]);
    if (!$b) { flash_set('error', 'Booking not found.'); redirect('admin-bookings.php'); }
}

$page_title = $isNew ? 'New booking' : 'Booking ' . $b['ref'];
$active     = 'bookings';
require 'admin-include/header.php';
?>

<?php if ($isNew): $lodges = rows('SELECT id, name, max_adults, max_children FROM lodges WHERE is_active = 1 ORDER BY sort_order, id'); ?>
  <div class="page-head">
    <div><h1>New booking</h1><p>For guests who phone or walk in. The same availability and price rules as the website apply, so you cannot double-book a lodge.</p></div>
    <a href="admin-bookings.php" class="btn btn-soft"><i class="fa-solid fa-arrow-left me-1"></i> Back to bookings</a>
  </div>
  <?php foreach ($errors as $er): ?><div class="flash error"><?= e($er) ?></div><?php endforeach; ?>
  <form method="post" class="panel-card" autocomplete="off">
    <?= csrf_field() ?><input type="hidden" name="action" value="create">
    <div class="row g-3">
      <div class="col-md-6"><label class="form-label">Lodge <span class="req">*</span></label>
        <select class="form-select" name="lodge_id" required>
          <option value="">Choose a lodge…</option>
          <?php foreach ($lodges as $l): ?><option value="<?= (int)$l['id'] ?>" <?= $f['lodge_id'] === (int)$l['id'] ? 'selected' : '' ?>><?= e($l['name']) ?> (max <?= (int)$l['max_adults'] ?> adults, <?= (int)$l['max_children'] ?> children)</option><?php endforeach; ?>
        </select></div>
      <div class="col-md-3"><label class="form-label">Check-in <span class="req">*</span></label><input type="date" class="form-control" name="check_in" required min="<?= e(date('Y-m-d')) ?>" value="<?= e($f['check_in']) ?>"></div>
      <div class="col-md-3"><label class="form-label">Check-out <span class="req">*</span></label><input type="date" class="form-control" name="check_out" required min="<?= e(date('Y-m-d')) ?>" value="<?= e($f['check_out']) ?>"></div>
      <div class="col-md-3"><label class="form-label">Adults</label><input type="number" class="form-control" name="adults" min="1" max="50" value="<?= (int)$f['adults'] ?>"></div>
      <div class="col-md-3"><label class="form-label">Children</label><input type="number" class="form-control" name="children" min="0" max="50" value="<?= (int)$f['children'] ?>"></div>
      <div class="col-md-3"><label class="form-label">Status</label>
        <select class="form-select" name="status"><option value="confirmed" <?= $f['status'] === 'confirmed' ? 'selected' : '' ?>>Confirmed</option><option value="pending" <?= $f['status'] === 'pending' ? 'selected' : '' ?>>Pending</option></select></div>
      <div class="col-12"><hr class="my-1"></div>
      <div class="col-md-4"><label class="form-label">Guest name <span class="req">*</span></label><input type="text" class="form-control" name="guest_name" required maxlength="100" value="<?= e($f['guest_name']) ?>"></div>
      <div class="col-md-4"><label class="form-label">Phone</label><input type="tel" class="form-control" name="guest_phone" maxlength="20" value="<?= e($f['guest_phone']) ?>"></div>
      <div class="col-md-4"><label class="form-label">E-mail</label><input type="email" class="form-control" name="guest_email" maxlength="150" value="<?= e($f['guest_email']) ?>">
        <div class="form-text">If this matches a registered guest, the booking also shows in their My Bookings.</div></div>
      <div class="col-md-6"><label class="form-label">Guest requests</label><textarea class="form-control" name="requests" rows="2" maxlength="500"><?= e($f['requests']) ?></textarea></div>
      <div class="col-md-6"><label class="form-label">Internal note</label><textarea class="form-control" name="admin_note" rows="2" maxlength="1000"><?= e($f['admin_note']) ?></textarea></div>
    </div>
    <button type="submit" class="btn btn-ink px-4 mt-4"><i class="fa-solid fa-floppy-disk me-1"></i> Create booking</button>
  </form>

<?php else: [$label, $key] = booking_status_info($b); $u = $b['user_id'] ? row('SELECT id, name FROM users WHERE id = ?', [$b['user_id']]) : null; ?>
  <div class="page-head">
    <div><h1><?= e($b['ref']) ?> <span class="st <?= e($key) ?>" style="font-size:.8rem;vertical-align:middle"><?= e($label) ?></span></h1>
      <p>Requested <?= e(date('d M Y, H:i', strtotime($b['created_at']))) ?> · <?= $b['source'] === 'admin' ? 'added by the hotel' : 'made on the website' ?></p></div>
    <a href="admin-bookings.php" class="btn btn-soft"><i class="fa-solid fa-arrow-left me-1"></i> Back to bookings</a>
  </div>

  <div class="detail-grid">
    <div class="panel-card">
      <h2>Guest</h2><div class="mb-2"></div>
      <div class="kv"><span>Name</span><span><?= e($b['guest_name'] ?: '—') ?></span></div>
      <div class="kv"><span>Phone</span><span><?= e($b['guest_phone'] ?: '—') ?></span></div>
      <div class="kv"><span>E-mail</span><span><?php if ($b['guest_email']): ?><a href="mailto:<?= e($b['guest_email']) ?>" style="color:var(--ink)"><?= e($b['guest_email']) ?></a><?php else: ?>—<?php endif; ?></span></div>
      <div class="kv"><span>Account</span><span><?= $u ? e($u['name']) . ' (registered)' : 'No account' ?></span></div>
    </div>
    <div class="panel-card">
      <h2>Stay</h2><div class="mb-2"></div>
      <div class="kv"><span>Lodge</span><span><?= e($b['lodge_name']) ?></span></div>
      <div class="kv"><span>Check-in</span><span><?= e(fmt_date($b['check_in'])) ?></span></div>
      <div class="kv"><span>Check-out</span><span><?= e(fmt_date($b['check_out'])) ?></span></div>
      <div class="kv"><span>Nights</span><span><?= (int)$b['nights'] ?></span></div>
      <div class="kv"><span>Guests</span><span><?= e(adults_text($b['adults'])) ?>, <?= e(children_text($b['children'])) ?></span></div>
    </div>
    <div class="panel-card">
      <h2>Price</h2><div class="mb-2"></div>
      <?php if ($b['std_nights']): ?><div class="kv"><span><?= (int)$b['std_nights'] ?> night(s) × ₹<?= e(inr($b['std_rate'])) ?></span><span>₹<?= e(inr($b['std_nights'] * $b['std_rate'])) ?></span></div><?php endif; ?>
      <?php if ($b['peak_nights']): ?><div class="kv"><span><?= (int)$b['peak_nights'] ?> weekend night(s) × ₹<?= e(inr($b['peak_rate'])) ?></span><span>₹<?= e(inr($b['peak_nights'] * $b['peak_rate'])) ?></span></div><?php endif; ?>
      <?php if ($b['tax_amount'] > 0): ?><div class="kv"><span>Tax (<?= e(rtrim(rtrim((string)$b['tax_percent'], '0'), '.')) ?>%)</span><span>₹<?= e(inr($b['tax_amount'])) ?></span></div><?php endif; ?>
      <div class="kv total"><span>Total (pay at hotel)</span><span>₹<?= e(inr($b['total'])) ?></span></div>
    </div>
  </div>

  <?php if ($b['special_requests'] !== ''): ?>
    <div class="panel-card"><h2>Guest's special requests</h2><p class="mb-0" style="white-space:pre-wrap"><?= e($b['special_requests']) ?></p></div>
  <?php endif; ?>

  <form method="post" class="panel-card">
    <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$b['id'] ?>">
    <h2>Note &amp; actions</h2>
    <div class="note">The note is saved on the booking. When you decline or cancel, the guest also sees it.</div>
    <textarea class="form-control mb-3" name="note" rows="3" maxlength="1000" placeholder="Internal note, or the reason for declining / cancelling"><?= e($b['admin_note']) ?></textarea>
    <div class="d-flex gap-2 flex-wrap">
      <button class="btn btn-soft" type="submit" name="action" value="note">Save note only</button>
      <?php if ($b['status'] === 'pending'): ?>
        <button class="btn btn-ink" type="submit" name="action" value="confirmed">Confirm booking</button>
        <button class="btn-danger-soft" type="submit" name="action" value="declined" onclick="return confirm('Decline this booking request? The dates become free again.');">Decline</button>
      <?php elseif ($b['status'] === 'confirmed'): ?>
        <button class="btn btn-ink" type="submit" name="action" value="completed">Mark as completed</button>
        <button class="btn-danger-soft" type="submit" name="action" value="cancelled" onclick="return confirm('Cancel this confirmed booking? The dates become free again.');">Cancel booking</button>
      <?php endif; ?>
    </div>
  </form>
<?php endif; ?>

<?php require 'admin-include/footer.php'; ?>
