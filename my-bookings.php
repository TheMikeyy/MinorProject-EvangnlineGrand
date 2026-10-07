<?php
require_once __DIR__ . '/admin/admin-include/db_config.php';
$user = require_user();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    if (($_POST['action'] ?? '') === 'cancel') {
        $b = row('SELECT * FROM bookings WHERE id = ? AND user_id = ?', [(int)($_POST['id'] ?? 0), $user['id']]);   // a guest can only touch their own bookings
        if (!$b) { toast_set('error', 'Booking not found.'); }
        else {
            $err = change_booking_status((int)$b['id'], 'cancelled', 'guest');
            toast_set($err ? 'error' : 'success', $err ?: 'Booking ' . $b['ref'] . ' has been cancelled.');
        }
    }
    redirect('my-bookings.php');
}

$all = rows('SELECT b.*, l.image AS lodge_image FROM bookings b LEFT JOIN lodges l ON l.id = b.lodge_id WHERE b.user_id = ? ORDER BY b.check_in DESC, b.id DESC', [$user['id']]);
$today = date('Y-m-d');
$upcoming = []; $past = [];
foreach ($all as $b) {
    if (in_array($b['status'], BOOKING_ACTIVE, true) && $b['check_out'] >= $today) { $upcoming[] = $b; } else { $past[] = $b; }
}
usort($upcoming, fn($a, $b) => strcmp($a['check_in'], $b['check_in']));
$highlight = (string)($_GET['new'] ?? '');

function booking_card(array $b, string $highlight): void {
    [$label, $key] = booking_status_info($b);
    $img = $b['lodge_image'] ? asset($b['lodge_image']) : 'images/logo/logo-light.png'; ?>
    <div class="acct-card acct-lift booking-item mb-3 <?= $highlight === $b['ref'] ? 'is-new' : '' ?>">
      <img class="b-thumb" src="<?= e($img) ?>" alt="<?= e($b['lodge_name']) ?>">
      <div>
        <div class="b-ref"><?= e($b['ref']) ?></div>
        <h5><?= e($b['lodge_name']) ?></h5>
        <div class="b-meta">
          <div><i class="bi bi-calendar-event"></i><?= e(fmt_date($b['check_in'])) ?> &rarr; <?= e(fmt_date($b['check_out'])) ?> &middot; <?= (int)$b['nights'] ?> night<?= $b['nights'] > 1 ? 's' : '' ?></div>
          <div><i class="bi bi-people"></i><?= e(adults_text($b['adults'])) ?><?= (int)$b['children'] > 0 ? ', ' . e(children_text($b['children'])) : '' ?></div>
          <?php if ($b['special_requests'] !== ''): ?><div><i class="bi bi-chat-left-text"></i><?= e($b['special_requests']) ?></div><?php endif; ?>
          <?php if (in_array($b['status'], ['declined', 'cancelled'], true) && $b['admin_note'] !== '' && $b['cancelled_by'] !== 'guest'): ?>
            <div><i class="bi bi-info-circle"></i>Note from the hotel: <?= e($b['admin_note']) ?></div><?php endif; ?>
          <div class="text-muted small mt-1">Requested on <?= e(date('d M Y, H:i', strtotime($b['created_at']))) ?></div>
        </div>
      </div>
      <div class="b-side">
        <span class="status-pill <?= e($key) ?>"><?= e($label) ?></span>
        <div>
          <div class="b-total">₹<?= e(inr($b['total'])) ?></div>
          <div class="small text-muted">Pay at the hotel<?= (int)$b['tax_amount'] > 0 ? ' · incl. tax' : '' ?></div>
        </div>
        <?php if (guest_can_cancel($b)): ?>
          <form method="post" class="m-0" onsubmit="return confirm('Cancel booking <?= e($b['ref']) ?>?');">
            <?= csrf_field() ?><input type="hidden" name="action" value="cancel"><input type="hidden" name="id" value="<?= (int)$b['id'] ?>">
            <button type="submit" class="btn btn-sm btn-outline-dark shadow-none rounded-pill px-3">Cancel booking</button>
          </form>
        <?php endif; ?>
      </div>
    </div>
<?php } ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Bookings | <?= e(setting('hotel_name')) ?></title>
  <?php require('include/links.php') ?>
</head>
<body>

<?php $navbar_solid = true; require('include/navbar.php') ?>

<?php
  $acct_active = 'bookings'; $acct_title = 'My Bookings';
  $acct_intro  = 'Everything you have booked with us. A booking is confirmed once the hotel accepts it.';
  require('include/account-start.php');
  $nUp = count($upcoming);
  $nPast = count(array_filter($past, fn($b) => !in_array($b['status'], ['cancelled', 'declined'], true)));
  $nCan  = count($past) - $nPast;
?>

<?php if (!$all): ?>
  <div class="acct-card empty-box">
    <i class="bi bi-calendar2-heart"></i>
    <h4 class="mt-3" style="font-family:'DM Serif Display',serif;color:var(--ink)">No bookings yet</h4>
    <p class="text-secondary">When you book a lodge, it will show up here so you can follow its status.</p>
    <a href="lodges.php" class="btn text-white custom-bg shadow-none rounded-pill px-4">Browse lodges</a>
  </div>
<?php else: ?>
  <div class="acct-stats">
    <div class="acct-stat"><div class="num"><?= $nUp ?></div><div class="lbl">Upcoming &amp; current</div></div>
    <div class="acct-stat"><div class="num"><?= $nPast ?></div><div class="lbl">Past stays</div></div>
    <div class="acct-stat"><div class="num"><?= $nCan ?></div><div class="lbl">Cancelled / declined</div></div>
  </div>
  <?php if ($upcoming): ?>
    <h2 class="h5 mb-3" style="font-family:'DM Serif Display',serif;color:var(--ink)">Upcoming &amp; current</h2>
    <?php foreach ($upcoming as $b) { booking_card($b, $highlight); } ?>
  <?php endif; ?>
  <?php if ($past): ?>
    <h2 class="h5 mb-3 mt-4" style="font-family:'DM Serif Display',serif;color:var(--ink)">Past &amp; cancelled</h2>
    <?php foreach ($past as $b) { booking_card($b, $highlight); } ?>
  <?php endif; ?>
<?php endif; ?>

<?php require('include/account-end.php') ?>

<?php require('include/footer.php') ?>
</body>
</html>
