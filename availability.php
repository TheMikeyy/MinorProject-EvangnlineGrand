<?php
/* Small JSON service used by the booking page and the lodges search:
   availability.php?lodge=3&checkin=2026-12-20&checkout=2026-12-23&adults=2&children=1   -> one lodge, with price
   availability.php?checkin=...&checkout=...                                             -> every lodge */
require_once __DIR__ . '/admin/admin-include/db_config.php';
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

$in = $_GET['checkin'] ?? ''; $out = $_GET['checkout'] ?? '';
$adults = max(1, (int)($_GET['adults'] ?? 1)); $children = max(0, (int)($_GET['children'] ?? 0));

if (!empty($_GET['lodge'])) {
    $lodge = row('SELECT * FROM lodges WHERE id = ?', [(int)$_GET['lodge']]);
    if (!$lodge) { echo json_encode(['ok' => false, 'available' => false, 'message' => 'Lodge not found.']); exit; }
    echo json_encode(quote_stay($lodge, $in, $out, $adults, $children), JSON_UNESCAPED_UNICODE);
    exit;
}

$result = [];
$dI = parse_date($in); $dO = parse_date($out);
$err = null;
if (!$dI || !$dO)               { $err = 'Please choose valid check-in and check-out dates.'; }
elseif ($dI < new DateTimeImmutable('today')) { $err = 'Check-in cannot be in the past.'; }
elseif ($dO <= $dI)             { $err = 'Check-out must be after check-in.'; }
elseif ((int)$dI->diff($dO)->days > max_nights()) { $err = 'You can book at most ' . max_nights() . ' nights at a time.'; }
if ($err) { echo json_encode(['ok' => false, 'message' => $err]); exit; }

foreach (rows('SELECT * FROM lodges WHERE is_active = 1') as $l) {
    $free  = lodge_is_free((int)$l['id'], (int)$l['units'], $dI, $dO);
    $calc  = calc_stay($l, $dI, $dO);
    $result[$l['id']] = ['available' => $free, 'total' => $calc['total'], 'total_text' => '₹' . inr($calc['total'])];
}
echo json_encode(['ok' => true, 'nights' => (int)$dI->diff($dO)->days, 'lodges' => $result], JSON_UNESCAPED_UNICODE);
