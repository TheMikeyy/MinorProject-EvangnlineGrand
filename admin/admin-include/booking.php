<?php
/*
 * BOOKING ENGINE  -  prices, availability and creating bookings.
 * Used by the public booking page, the lodges search, and the admin "new booking" form,
 * so the rules are identical everywhere:
 *
 *  - A lodge can be booked while fewer than  lodges.units  active bookings cover a night.
 *  - "Active" = status pending or confirmed. Cancelled / declined bookings free the dates again.
 *  - Price per night = "Price from" on Sun-Thu nights, "Price up to" on Fri and Sat nights
 *    (if "Price up to" is empty or the same, every night costs the same).
 *  - The night of the check-out day is NOT charged / not blocked.
 */
const BOOKING_ACTIVE = ['pending', 'confirmed'];

function parse_date($s): ?DateTimeImmutable {
    $s = trim((string)$s);
    if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $s, $m) || !checkdate((int)$m[2], (int)$m[3], (int)$m[1])) { return null; }
    return new DateTimeImmutable($s);
}
function fmt_date($d): string {
    if (!$d instanceof DateTimeInterface) { $d = new DateTimeImmutable((string)$d); }
    return $d->format('D, d M Y');
}
function max_nights(): int { $n = (int)setting('max_nights'); return $n >= 1 ? min($n, 90) : 14; }

/* ---------- price ---------- */
function calc_stay(array $lodge, DateTimeImmutable $in, DateTimeImmutable $out): array {
    $std  = (int)$lodge['price_min'];
    $peak = ($lodge['price_max'] !== null && (int)$lodge['price_max'] > $std) ? (int)$lodge['price_max'] : $std;
    $nStd = 0; $nPeak = 0;
    for ($d = $in; $d < $out; $d = $d->modify('+1 day')) {
        $w = (int)$d->format('N');                       // 5 = Friday, 6 = Saturday
        if ($peak > $std && ($w === 5 || $w === 6)) { $nPeak++; } else { $nStd++; }
    }
    $sub = $nStd * $std + $nPeak * $peak;
    $pct = max(0.0, min(100.0, (float)setting('tax_percent')));
    $tax = (int)round($sub * $pct / 100);
    $lines = [];
    if ($nStd)  { $lines[] = [$nStd  . ' night' . ($nStd  > 1 ? 's' : '') . ' × ₹' . inr($std),  $nStd * $std]; }
    if ($nPeak) { $lines[] = [$nPeak . ' weekend night' . ($nPeak > 1 ? 's' : '') . ' (Fri/Sat) × ₹' . inr($peak), $nPeak * $peak]; }
    return ['nights' => $nStd + $nPeak, 'std_nights' => $nStd, 'peak_nights' => $nPeak, 'std_rate' => $std, 'peak_rate' => $peak,
            'subtotal' => $sub, 'tax_percent' => $pct, 'tax' => $tax, 'total' => $sub + $tax, 'lines' => $lines];
}

/* ---------- availability ---------- */
function lodge_is_free(int $lodgeId, int $units, DateTimeImmutable $in, DateTimeImmutable $out, int $ignoreBookingId = 0): bool {
    $units = max(1, $units);
    $busy = rows("SELECT check_in, check_out FROM bookings
                  WHERE lodge_id = ? AND status IN ('pending','confirmed') AND check_in < ? AND check_out > ? AND id <> ?",
                 [$lodgeId, $out->format('Y-m-d'), $in->format('Y-m-d'), $ignoreBookingId]);
    if (count($busy) < $units) { return true; }          // cannot be full on any night
    for ($d = $in; $d < $out; $d = $d->modify('+1 day')) {
        $day = $d->format('Y-m-d'); $n = 0;
        foreach ($busy as $b) { if ($b['check_in'] <= $day && $b['check_out'] > $day) { $n++; } }
        if ($n >= $units) { return false; }
    }
    return true;
}

/* checks everything about a requested stay; returns an error text or null */
function stay_error(array $lodge, ?DateTimeImmutable $in, ?DateTimeImmutable $out, int $adults, int $children): ?string {
    if (!(int)$lodge['is_active']) { return 'This lodge is not available for booking.'; }
    if (!$in || !$out)  { return 'Please choose valid check-in and check-out dates.'; }
    $today = new DateTimeImmutable('today');
    if ($in < $today)   { return 'Check-in cannot be in the past.'; }
    if ($out <= $in)    { return 'Check-out must be after check-in.'; }
    $nights = (int)$in->diff($out)->days;
    if ($nights > max_nights()) { return 'You can book at most ' . max_nights() . ' nights at a time.'; }
    if ($in > $today->modify('+2 years')) { return 'Bookings can be made up to 2 years ahead.'; }
    if ($adults < 1 || $adults > (int)$lodge['max_adults']) { return 'This lodge allows 1 to ' . (int)$lodge['max_adults'] . ' adults.'; }
    if ($children < 0 || $children > (int)$lodge['max_children']) { return 'This lodge allows up to ' . (int)$lodge['max_children'] . ' children.'; }
    return null;
}

/* what the booking page / lodge search shows: availability + price for one lodge */
function quote_stay(array $lodge, $checkin, $checkout, int $adults = 1, int $children = 0): array {
    $in = parse_date($checkin); $out = parse_date($checkout);
    $err = stay_error($lodge, $in, $out, $adults, $children);
    if ($err) { return ['ok' => false, 'available' => false, 'message' => $err]; }
    $calc = calc_stay($lodge, $in, $out);
    $free = lodge_is_free((int)$lodge['id'], (int)$lodge['units'], $in, $out);
    return ['ok' => true, 'available' => $free, 'message' => $free ? '' : 'Sorry, this lodge is fully booked for those dates. Please try other dates.'] + $calc;
}

/* ---------- creating a booking (safe against two guests booking the last room at once) ---------- */
function new_booking_ref(): string {
    $alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    do {
        $r = 'EG-';
        for ($i = 0; $i < 6; $i++) { $r .= $alphabet[random_int(0, strlen($alphabet) - 1)]; }
    } while (value('SELECT COUNT(*) FROM bookings WHERE ref = ?', [$r]));
    return $r;
}

function create_booking(array $in): array {
    global $pdo;
    $checkin = parse_date($in['check_in'] ?? ''); $checkout = parse_date($in['check_out'] ?? '');
    $adults = (int)($in['adults'] ?? 1); $children = (int)($in['children'] ?? 0);
    $status = in_array(($in['status'] ?? 'pending'), ['pending', 'confirmed'], true) ? $in['status'] : 'pending';

    try {
        $pdo->beginTransaction();
        $lodge = row('SELECT * FROM lodges WHERE id = ? FOR UPDATE', [(int)($in['lodge_id'] ?? 0)]);   // lock: one booking at a time per lodge
        if (!$lodge) { $pdo->rollBack(); return ['ok' => false, 'error' => 'That lodge was not found.']; }

        $err = stay_error($lodge, $checkin, $checkout, $adults, $children);
        if (!$err && !lodge_is_free((int)$lodge['id'], (int)$lodge['units'], $checkin, $checkout)) {
            $err = 'Sorry, this lodge has just been booked for those dates. Please choose other dates.';
        }
        if ($err) { $pdo->rollBack(); return ['ok' => false, 'error' => $err]; }

        $c   = calc_stay($lodge, $checkin, $checkout);
        $ref = new_booking_ref();
        run('INSERT INTO bookings (ref, user_id, lodge_id, lodge_name, check_in, check_out, nights, adults, children,
                 std_nights, peak_nights, std_rate, peak_rate, subtotal, tax_percent, tax_amount, total,
                 special_requests, status, source, guest_name, guest_email, guest_phone, admin_note)
             VALUES (?,?,?,?,?,?,?,?,?, ?,?,?,?,?,?,?,?, ?,?,?,?,?,?,?)',
            [$ref, $in['user_id'] ?? null, $lodge['id'], $lodge['name'], $checkin->format('Y-m-d'), $checkout->format('Y-m-d'), $c['nights'], $adults, $children,
             $c['std_nights'], $c['peak_nights'], $c['std_rate'], $c['peak_rate'], $c['subtotal'], $c['tax_percent'], $c['tax'], $c['total'],
             mb_substr(trim((string)($in['requests'] ?? '')), 0, 500), $status, ($in['source'] ?? 'online') === 'admin' ? 'admin' : 'online',
             mb_substr(trim((string)($in['guest_name'] ?? '')), 0, 100), mb_substr(trim((string)($in['guest_email'] ?? '')), 0, 150),
             mb_substr(trim((string)($in['guest_phone'] ?? '')), 0, 25), mb_substr(trim((string)($in['admin_note'] ?? '')), 0, 1000)]);
        $id = (int)$pdo->lastInsertId();
        $pdo->commit();
    } catch (Throwable $ex) {
        if ($pdo->inTransaction()) { $pdo->rollBack(); }
        error_log('create_booking failed: ' . $ex->getMessage());
        return ['ok' => false, 'error' => 'Something went wrong while saving your booking. Please try again.'];
    }
    $b = row('SELECT * FROM bookings WHERE id = ?', [$id]);
    if (($in['source'] ?? 'online') !== 'admin') { email_booking_created($b); }
    return ['ok' => true, 'booking' => $b];
}

/* ---------- status handling ---------- */
function booking_status_info(array $b): array {      // [label, css key]
    $s = $b['status'];
    if ($s === 'confirmed' && $b['check_out'] < date('Y-m-d')) { return ['Completed', 'completed']; }
    return [['pending' => 'Awaiting confirmation', 'confirmed' => 'Confirmed', 'cancelled' => 'Cancelled', 'declined' => 'Declined by hotel', 'completed' => 'Completed'][$s] ?? ucfirst($s), $s];
}
function guest_can_cancel(array $b): bool { return in_array($b['status'], BOOKING_ACTIVE, true) && $b['check_in'] >= date('Y-m-d'); }

/* $by = 'guest' | 'admin'. Returns an error text or null. */
function change_booking_status(int $id, string $new, string $by, string $note = ''): ?string {
    $b = row('SELECT * FROM bookings WHERE id = ?', [$id]);
    if (!$b) { return 'Booking not found.'; }
    $allowed = ['pending' => ['confirmed', 'declined', 'cancelled'], 'confirmed' => ['cancelled', 'completed']];
    if ($by === 'guest') {
        if ($new !== 'cancelled' || !guest_can_cancel($b)) { return 'This booking can no longer be cancelled online. Please contact the hotel.'; }
    } elseif (!in_array($new, $allowed[$b['status']] ?? [], true)) {
        return 'This booking is already ' . $b['status'] . ' and cannot be changed to ' . $new . '.';
    }
    $noteSql = ''; $params = [$new, $new === 'cancelled' ? $by : null];
    if ($note !== '') { $noteSql = ', admin_note = ?'; $params[] = mb_substr($note, 0, 1000); }
    $params[] = $id;
    run("UPDATE bookings SET status = ?, cancelled_by = ?, updated_at = NOW() $noteSql WHERE id = ?", $params);
    $b = row('SELECT * FROM bookings WHERE id = ?', [$id]);
    email_booking_changed($b, $by);
    return null;
}

/* ---------- e-mails (saved in Admin > Email Log until sending is connected) ---------- */
function booking_summary_text(array $b): string {
    return "Booking reference: {$b['ref']}\nLodge: {$b['lodge_name']}\nCheck-in: " . fmt_date($b['check_in']) . ' (from ' . setting('check_in_time') . ")\n"
         . 'Check-out: ' . fmt_date($b['check_out']) . ' (by ' . setting('check_out_time') . ")\nNights: {$b['nights']}\n"
         . "Guests: {$b['adults']} adult(s), {$b['children']} child(ren)\nTotal: ₹" . inr($b['total']) . ($b['tax_amount'] > 0 ? ' (includes ₹' . inr($b['tax_amount']) . ' tax)' : '') . "\nPayment: at the hotel\n";
}
function email_booking_created(array $b): void {
    $hotel = setting('hotel_name');
    if ($b['guest_email'] !== '') {
        send_mail($b['guest_email'], "Booking request received - {$b['ref']}",
            "Dear {$b['guest_name']},\n\nThank you for choosing $hotel. We have received your booking request and will confirm it shortly.\n\n"
            . booking_summary_text($b) . "\nYou can follow the status in My Bookings: " . site_url('my-bookings.php') . "\n\nWarm regards,\n$hotel");
    }
    notify_admin("New booking request {$b['ref']}",
        "A new booking request was made on the website.\n\nGuest: {$b['guest_name']} ({$b['guest_email']}, {$b['guest_phone']})\n" . booking_summary_text($b)
        . ($b['special_requests'] !== '' ? "Requests: {$b['special_requests']}\n" : '') . "\nReview it here: " . site_url('admin/admin-booking.php?id=' . $b['id']));
}
function email_booking_changed(array $b, string $by): void {
    $hotel = setting('hotel_name'); $s = $b['status'];
    $text = [
        'confirmed' => "Good news! Your booking is CONFIRMED. We look forward to welcoming you.",
        'declined'  => "We are sorry, but we are unable to accommodate this booking request." . ($b['admin_note'] !== '' ? "\nNote from the hotel: {$b['admin_note']}" : ''),
        'cancelled' => $by === 'guest' ? "Your booking has been cancelled as you requested." : "Your booking has been cancelled by the hotel." . ($b['admin_note'] !== '' ? "\nNote from the hotel: {$b['admin_note']}" : ''),
        'completed' => "Thank you for staying with us. We hope to see you again soon.",
    ][$s] ?? null;
    if ($text && $b['guest_email'] !== '') {
        send_mail($b['guest_email'], "Booking {$b['ref']}: " . booking_status_info($b)[0], "Dear {$b['guest_name']},\n\n$text\n\n" . booking_summary_text($b) . "\nWarm regards,\n$hotel");
    }
    if ($s === 'cancelled' && $by === 'guest') {
        notify_admin("Booking {$b['ref']} cancelled by guest", "The guest cancelled this booking.\n\n" . booking_summary_text($b) . "\nGuest: {$b['guest_name']} ({$b['guest_phone']})");
    }
}
