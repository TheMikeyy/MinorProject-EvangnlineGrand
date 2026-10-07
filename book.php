<?php
require_once __DIR__ . '/admin/admin-include/db_config.php';
$user = require_user();                       // guests must be logged in to book

$lodge = row('SELECT * FROM lodges WHERE id = ? AND is_active = 1', [(int)($_REQUEST['lodge'] ?? 0)]);
if (!$lodge) { toast_set('error', 'That lodge could not be found.'); redirect('lodges.php'); }

$errors = [];
$form = [
    'checkin'  => (string)($_REQUEST['checkin'] ?? ''),
    'checkout' => (string)($_REQUEST['checkout'] ?? ''),
    'adults'   => (int)($_REQUEST['adults'] ?? 2),
    'children' => (int)($_REQUEST['children'] ?? 0),
    'requests' => trim((string)($_POST['requests'] ?? '')),
];
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {      // only tidy the pre-filled values; a submitted wrong number must be REFUSED, not silently changed
    $form['adults']   = max(1, min((int)$lodge['max_adults'], $form['adults']));
    $form['children'] = max(0, min((int)$lodge['max_children'], $form['children']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    if (mb_strlen($form['requests']) > 500) { $errors[] = 'Special requests can be at most 500 characters.'; }
    if (!$errors) {
        $res = create_booking([
            'lodge_id' => $lodge['id'], 'check_in' => $form['checkin'], 'check_out' => $form['checkout'],
            'adults' => $form['adults'], 'children' => $form['children'], 'requests' => $form['requests'],
            'user_id' => $user['id'], 'guest_name' => $user['name'], 'guest_email' => $user['email'], 'guest_phone' => $user['phone'],
            'source' => 'online', 'status' => 'pending',
        ]);
        if ($res['ok']) {
            toast_set('success', 'Booking request ' . $res['booking']['ref'] . ' sent! The hotel will confirm it shortly.');
            redirect('my-bookings.php?new=' . urlencode($res['booking']['ref']));
        }
        $errors[] = $res['error'];
    }
}

$features   = lines($lodge['features']);
$facilities = lines($lodge['facilities']);
$std  = (int)$lodge['price_min'];
$peak = ($lodge['price_max'] !== null && (int)$lodge['price_max'] > $std) ? (int)$lodge['price_max'] : $std;
$today = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book <?= e($lodge['name']) ?> | <?= e(setting('hotel_name')) ?></title>
  <?php require('include/links.php') ?>
</head>
<body>

<?php require('include/navbar.php') ?>

<div class="page-hero-lite">
  <div class="container">
    <span class="section-eyebrow on-dark d-block">Reserve Your Stay</span>
    <h2 class="mb-0 fw-bold section-font on-dark">BOOK <?= e(mb_strtoupper($lodge['name'])) ?></h2>
  </div>
</div>

<div class="container my-5">
  <div class="row g-4">

    <!-- the lodge -->
    <div class="col-lg-5">
      <div class="g-card h-100">
        <img class="book-lodge-img mb-3" src="<?= e(asset($lodge['image'])) ?>" alt="<?= e($lodge['name']) ?>">
        <?php if ($lodge['tier'] !== ''): ?><span class="lodge-tier"><?= e($lodge['tier']) ?></span><?php endif; ?>
        <h4 class="mt-2"><?= e($lodge['name']) ?></h4>
        <?php if (trim((string)$lodge['blurb']) !== ''): ?><p class="text-secondary"><?= e($lodge['blurb']) ?></p><?php endif; ?>
        <p class="mb-3">
          <strong>₹<?= e(inr($std)) ?></strong> per night<?= $peak > $std ? ' (Sun–Thu)' : '' ?>
          <?php if ($peak > $std): ?><br><strong>₹<?= e(inr($peak)) ?></strong> per night (Fri &amp; Sat)<?php endif; ?>
        </p>
        <?php if ($features): ?><div class="mb-2"><small class="text-muted d-block">Features</small><?php foreach ($features as $p): ?><span class="g-pill"><?= e($p) ?></span><?php endforeach; ?></div><?php endif; ?>
        <?php if ($facilities): ?><div class="mb-2"><small class="text-muted d-block">Facilities</small><?php foreach ($facilities as $p): ?><span class="g-pill"><?= e($p) ?></span><?php endforeach; ?></div><?php endif; ?>
        <div><small class="text-muted d-block">Guests limit</small>
          <span class="g-pill"><?= e(adults_text($lodge['max_adults'])) ?></span><?php if ((int)$lodge['max_children'] > 0): ?><span class="g-pill"><?= e(children_text($lodge['max_children'])) ?></span><?php endif; ?>
        </div>
        <a href="lodges.php" class="btn btn-sm btn-outline-dark shadow-none rounded-pill px-3 mt-4"><i class="bi bi-arrow-left me-1"></i>Choose another lodge</a>
      </div>
    </div>

    <!-- the booking form -->
    <div class="col-lg-7">
      <form method="post" class="g-card" id="bookForm" novalidate>
        <?= csrf_field() ?>
        <input type="hidden" name="lodge" value="<?= (int)$lodge['id'] ?>">
        <h4 class="mb-3">Your stay</h4>

        <?php foreach ($errors as $er): ?><div class="alert alert-danger py-2"><?= e($er) ?></div><?php endforeach; ?>

        <div class="row g-3">
          <div class="col-sm-6">
            <label class="form-label" for="checkin">Check-in</label>
            <input type="date" class="form-control shadow-none" id="checkin" name="checkin" required min="<?= e($today) ?>" value="<?= e($form['checkin']) ?>">
            <div class="form-text">From <?= e(setting('check_in_time')) ?></div>
          </div>
          <div class="col-sm-6">
            <label class="form-label" for="checkout">Check-out</label>
            <input type="date" class="form-control shadow-none" id="checkout" name="checkout" required min="<?= e($today) ?>" value="<?= e($form['checkout']) ?>">
            <div class="form-text">By <?= e(setting('check_out_time')) ?></div>
          </div>
          <div class="col-sm-6">
            <label class="form-label" for="adults">Adults</label>
            <select class="form-select shadow-none" id="adults" name="adults">
              <?php for ($i = 1; $i <= (int)$lodge['max_adults']; $i++): ?><option value="<?= $i ?>" <?= $i === $form['adults'] ? 'selected' : '' ?>><?= $i ?></option><?php endfor; ?>
            </select>
          </div>
          <div class="col-sm-6">
            <label class="form-label" for="children">Children</label>
            <select class="form-select shadow-none" id="children" name="children">
              <?php for ($i = 0; $i <= (int)$lodge['max_children']; $i++): ?><option value="<?= $i ?>" <?= $i === $form['children'] ? 'selected' : '' ?>><?= $i ?></option><?php endfor; ?>
            </select>
          </div>
          <div class="col-12">
            <label class="form-label" for="requests">Special requests <span class="text-muted small">(optional)</span></label>
            <textarea class="form-control shadow-none" id="requests" name="requests" rows="3" maxlength="500" placeholder="Late arrival, extra bed, dietary needs…"><?= e($form['requests']) ?></textarea>
          </div>
        </div>

        <div class="stay-summary mt-4" id="summary">
          <div class="text-secondary" id="summaryEmpty">Choose your check-in and check-out dates to see the price.</div>
          <div id="summaryLines" class="d-none"></div>
        </div>
        <div class="stay-message bad mt-3 d-none" id="stayMessage"></div>

        <hr class="my-4">
        <h6 class="mb-2">Booking in the name of</h6>
        <p class="mb-1"><?= e($user['name']) ?> &middot; <?= e($user['email']) ?> &middot; <?= e($user['phone']) ?></p>
        <p class="small text-muted mb-3">Not right? <a href="profile.php" class="text-decoration-none" style="color:var(--ink);font-weight:500">Update your profile</a>.</p>

        <p class="small text-secondary"><?= nl2br(e(setting('booking_policy'))) ?></p>

        <button type="submit" class="btn btn-lg text-white custom-bg shadow-none rounded-pill px-5 w-100" id="submitBtn" disabled>Request booking</button>
        <div class="form-text text-center mt-2">Your booking is confirmed once the hotel accepts it. You will not be charged online.</div>
      </form>
    </div>
  </div>
</div>

<?php require('include/footer.php') ?>

<script>
(function () {
  var lodgeId = <?= (int)$lodge['id'] ?>;
  var $in = document.getElementById('checkin'), $out = document.getElementById('checkout');
  var $ad = document.getElementById('adults'), $ch = document.getElementById('children');
  var $btn = document.getElementById('submitBtn'), $msg = document.getElementById('stayMessage');
  var $empty = document.getElementById('summaryEmpty'), $lines = document.getElementById('summaryLines');
  var timer = null, seq = 0;

  function money(n) { return '₹' + Number(n).toLocaleString('en-IN'); }
  function addDay(iso, n) { var d = new Date(iso + 'T00:00:00'); d.setDate(d.getDate() + n); return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0'); }
  function row(label, value, cls) {
    var r = document.createElement('div'); r.className = 'row-line ' + (cls || '');
    var a = document.createElement('span'); a.textContent = label; var b = document.createElement('span'); b.textContent = value;
    r.appendChild(a); r.appendChild(b); return r;
  }
  function bad(text) { $msg.textContent = text; $msg.classList.toggle('d-none', !text); }
  function reset(text) { $btn.disabled = true; $lines.classList.add('d-none'); $empty.classList.remove('d-none'); bad(text || ''); }

  function refresh() {
    if ($in.value) { $out.min = addDay($in.value, 1); if ($out.value && $out.value <= $in.value) { $out.value = addDay($in.value, 1); } }
    if (!$in.value || !$out.value) { reset(''); return; }
    var mine = ++seq;
    var q = new URLSearchParams({ lodge: lodgeId, checkin: $in.value, checkout: $out.value, adults: $ad.value, children: $ch.value });
    fetch('availability.php?' + q.toString()).then(function (r) { return r.json(); }).then(function (d) {
      if (mine !== seq) { return; }
      if (!d.ok) { reset(d.message); return; }
      $lines.innerHTML = '';
      d.lines.forEach(function (l) { $lines.appendChild(row(l[0], money(l[1]))); });
      if (d.tax > 0) { $lines.appendChild(row('Tax (' + d.tax_percent + '%)', money(d.tax))); }
      $lines.appendChild(row(d.nights + ' night' + (d.nights > 1 ? 's' : '') + ' – total', money(d.total), 'row-total'));
      $lines.classList.remove('d-none'); $empty.classList.add('d-none');
      bad(d.available ? '' : d.message);
      $btn.disabled = !d.available;
    }).catch(function () { if (mine === seq) { reset('Could not check availability. Please check your connection and try again.'); } });
  }
  function later() { clearTimeout(timer); timer = setTimeout(refresh, 250); }
  [$in, $out, $ad, $ch].forEach(function (el) { el.addEventListener('change', later); });
  document.getElementById('bookForm').addEventListener('submit', function (ev) { if ($btn.disabled) { ev.preventDefault(); } });
  refresh();
})();
</script>

</body>
</html>
