<?php
require_once __DIR__ . '/admin/admin-include/db_config.php';
$user = require_user();

$b = row('SELECT * FROM bookings WHERE ref = ? AND user_id = ?', [(string)($_REQUEST['ref'] ?? ''), $user['id']]);   // a guest can only pay for their own booking
if (!$b) { toast_set('error', 'Booking not found.'); redirect('my-bookings.php'); }
if (!upi_enabled()) { toast_set('error', 'Online payment is not available right now. Please pay at the hotel.'); redirect('my-bookings.php'); }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $utr = strtoupper(trim((string)($_POST['utr'] ?? '')));
    if (!preg_match('/^[A-Z0-9]{8,30}$/', $utr)) { $errors[] = 'Please enter the UPI transaction ID (UTR) shown in your payment app: 8 to 30 letters or digits.'; }
    else {
        $err = submit_payment_ref((int)$b['id'], (int)$user['id'], $utr);
        if (!$err) { toast_set('success', 'Thank you! The hotel will verify your payment shortly.'); redirect('my-bookings.php?new=' . urlencode($b['ref'])); }
        $errors[] = $err;
    }
}
$paid = ($b['payment_status'] ?? '') === 'paid';
$can  = guest_can_pay($b);
$link = upi_link($b);
$payee = trim(setting('upi_name')) ?: setting('hotel_name');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pay for <?= e($b['ref']) ?> | <?= e(setting('hotel_name')) ?></title>
  <?php require('include/links.php') ?>
</head>
<body class="page-plain">

<?php require('include/navbar.php') ?>

<div class="page-hero-lite">
  <div class="container">
    <span class="section-eyebrow on-dark d-block">Secure UPI Payment</span>
    <h2 class="mb-0 fw-bold section-font on-dark">PAY FOR <?= e($b['ref']) ?></h2>
  </div>
</div>

<div class="container my-5" style="max-width: 980px;">
<?php if ($paid): ?>
  <div class="g-card empty-box">
    <i class="bi bi-patch-check"></i>
    <h4 class="mt-3">Payment received</h4>
    <p class="text-secondary">Thank you! The hotel has confirmed your payment of ₹<?= e(inr($b['total'])) ?> for <?= e($b['lodge_name']) ?>.</p>
    <a href="my-bookings.php" class="btn text-white custom-bg shadow-none rounded-pill px-4">Back to My Bookings</a>
  </div>
<?php elseif (!$can): ?>
  <div class="g-card empty-box">
    <i class="bi bi-info-circle"></i>
    <h4 class="mt-3">This booking cannot be paid online</h4>
    <p class="text-secondary">It may be cancelled or already finished. Please contact the hotel if you need help.</p>
    <a href="my-bookings.php" class="btn text-white custom-bg shadow-none rounded-pill px-4">Back to My Bookings</a>
  </div>
<?php else: ?>
  <div class="row g-4">
    <div class="col-md-5">
      <div class="g-card text-center h-100">
        <h4 class="mb-1">Scan to pay</h4>
        <p class="text-secondary small mb-3">Use Google Pay, PhonePe, Paytm, BHIM or any UPI app</p>
        <div class="qr-box" id="qr" aria-label="UPI QR code"></div>
        <div class="mt-3" style="font-family:'Lora',serif;font-size:1.9rem;color:var(--ink)">₹<?= e(inr($b['total'])) ?></div>
        <div class="text-secondary small">to <?= e($payee) ?> &middot; <?= e(trim(setting('upi_id'))) ?></div>
        <a href="<?= e($link) ?>" class="btn text-white custom-bg shadow-none rounded-pill px-4 mt-3 d-md-none">Open my UPI app</a>
      </div>
    </div>
    <div class="col-md-7">
      <div class="g-card h-100">
        <h4 class="mb-3"><?= e($b['lodge_name']) ?></h4>
        <p class="mb-1"><i class="bi bi-calendar-event me-2"></i><?= e(fmt_date($b['check_in'])) ?> &rarr; <?= e(fmt_date($b['check_out'])) ?> &middot; <?= (int)$b['nights'] ?> night<?= $b['nights'] > 1 ? 's' : '' ?></p>
        <p class="text-secondary small">Booking reference: <b><?= e($b['ref']) ?></b>. The reference is already written in the payment note.</p>
        <ol class="ps-3 small mb-4">
          <li class="mb-1">Scan the QR code with your UPI app (on a phone, tap <i>Open my UPI app</i>).</li>
          <li class="mb-1">Check that the amount is <b>₹<?= e(inr($b['total'])) ?></b> and pay.</li>
          <li>Type the <b>UPI transaction ID (UTR)</b> from your payment app below, so the hotel can verify your payment.</li>
        </ol>
        <?php foreach ($errors as $er): ?><div class="alert alert-danger py-2"><?= e($er) ?></div><?php endforeach; ?>
        <?php if (($b['payment_status'] ?? '') === 'verifying'): ?><div class="alert alert-info py-2 small">You already sent transaction ID <b><?= e($b['payment_ref']) ?></b>. The hotel is verifying it. You can send a corrected one below.</div><?php endif; ?>
        <form method="post" autocomplete="off">
          <?= csrf_field() ?><input type="hidden" name="ref" value="<?= e($b['ref']) ?>">
          <label class="form-label" for="utr">UPI transaction ID (UTR)</label>
          <input type="text" class="form-control shadow-none mb-3" id="utr" name="utr" required maxlength="30" placeholder="e.g. 412345678901" style="text-transform:uppercase">
          <button type="submit" class="btn text-white custom-bg shadow-none rounded-pill px-4">I have paid</button>
          <a href="my-bookings.php" class="btn btn-outline-dark shadow-none rounded-pill px-4 ms-2">Pay later</a>
        </form>
        <p class="small text-muted mt-3 mb-0">Your booking is confirmed by the hotel. Payment is marked as received only after the hotel sees the money.</p>
      </div>
    </div>
  </div>
<?php endif; ?>
</div>

<?php require('include/footer.php') ?>
<?php if (!$paid && $can): ?>
<script src="js/qrcode.js"></script>
<script>
  (function () {
    var qr = qrcode(0, 'M');
    qr.addData(<?= json_encode($link, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>);
    qr.make();
    document.getElementById('qr').innerHTML = qr.createSvgTag(6, 0);
  })();
</script>
<?php endif; ?>
</body>
</html>
