<?php
require_once 'admin-include/db_config.php';
require_admin();

$config = site_config();
$tab = $_GET['tab'] ?? ($_POST['tab'] ?? 'general');
if (!isset($config[$tab])) { $tab = 'general'; }

/* ---------------- save ---------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $errors = [];
    $saved  = 0;
    $upsert = $pdo->prepare('INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?)
                             ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)');

    foreach ($config[$tab]['groups'] as $g) {
        foreach ($g['fields'] as $f) {
            $k = $f['key']; $label = $f['label']; $type = $f['type'];
            $current = setting($k);

            if ($type === 'image') {
                if (isset($_POST['reset_' . $k])) {                       // go back to the original design image
                    run('DELETE FROM site_settings WHERE setting_key = ?', [$k]);
                    delete_uploaded_image($current);
                    $saved++;
                    continue;
                }
                $err = null;
                $path = upload_image('file_' . $k, $err);
                if ($err) { $errors[] = "$label: $err"; continue; }
                if ($path) {
                    $upsert->execute([$k, $path]);
                    delete_uploaded_image($current);
                    $saved++;
                }
                continue;
            }

            if (!isset($_POST[$k])) { continue; }
            $v = str_replace("\r\n", "\n", trim((string)$_POST[$k]));

            if ($type === 'map') {
                if (stripos($v, '<iframe') !== false && preg_match('/src\s*=\s*["\']([^"\']+)["\']/i', $v, $m)) { $v = html_entity_decode($m[1]); }
                if (!preg_match('#^https://www\.google\.com/maps/embed#', $v)) {
                    $errors[] = "$label: please paste the code from Google Maps > Share > Embed a map (the link must start with https://www.google.com/maps/embed).";
                    continue;
                }
            } elseif ($type === 'number') {
                if (!is_numeric($v) || (float)$v < 0 || (float)$v > 100000) { $errors[] = "$label must be a number (0 or more)."; continue; }
                if ($k === 'max_nights') { if ((float)$v < 1 || (float)$v > 90 || floor((float)$v) != (float)$v) { $errors[] = "$label must be a whole number from 1 to 90."; continue; } }
                if ($k === 'tax_percent' && (float)$v > 100) { $errors[] = "$label cannot be more than 100."; continue; }
                $v = (string)(float)$v === (string)(int)(float)$v ? (string)(int)(float)$v : (string)(float)$v;
            } elseif ($k === 'notify_email') {
                if ($v !== '' && !filter_var($v, FILTER_VALIDATE_EMAIL)) { $errors[] = "$label must be a valid e-mail address."; continue; }
            } elseif ($type === 'url') {
                if ($v !== '' && !preg_match('#^https?://#i', $v)) { $errors[] = "$label: the link must start with http:// or https://"; continue; }
            }
            $max = $type === 'textarea' ? 3000 : ($type === 'map' ? 2000 : 250);
            if (mb_strlen($v) > $max) { $errors[] = "$label is too long (maximum $max characters)."; continue; }

            if ($v !== $current) { $saved++; }
            $upsert->execute([$k, $v]);
        }
    }
    foreach ($errors as $er) { flash_set('error', $er); }
    if ($saved > 0 || !$errors) { flash_set('success', 'Saved. Your changes are now live on the website.'); }
    redirect('admin-setting.php?tab=' . urlencode($tab));
}

$page_title = 'Site Content';
$active     = 'content';
require 'admin-include/header.php';
$defaults = site_defaults();
?>

<div class="page-head">
  <div>
    <h1>Site Content</h1>
    <p>Change the text and pictures of your website. Pick a section, edit, press <b>Save</b> &ndash; visitors see it immediately.</p>
  </div>
</div>

<div class="tabs-row">
  <?php foreach ($config as $tk => $t): ?>
    <a href="admin-setting.php?tab=<?= e($tk) ?>" class="<?= $tk === $tab ? 'active' : '' ?>"><i class="<?= e($t['icon']) ?> me-1"></i><?= e($t['label']) ?></a>
  <?php endforeach; ?>
</div>

<p class="text-muted" style="max-width:760px"><?= e($config[$tab]['desc']) ?></p>

<form method="post" enctype="multipart/form-data" autocomplete="off">
  <?= csrf_field() ?>
  <input type="hidden" name="tab" value="<?= e($tab) ?>">

  <?php foreach ($config[$tab]['groups'] as $g): ?>
  <div class="panel-card">
    <h2><?= e($g['title']) ?></h2>
    <?php if (!empty($g['note'])): ?><div class="note"><?= e($g['note']) ?></div><?php else: ?><div class="mb-3"></div><?php endif; ?>

    <div class="row g-3">
    <?php foreach ($g['fields'] as $f):
        $k = $f['key']; $val = setting($k); $type = $f['type'];
        $wide = in_array($type, ['textarea', 'image', 'map'], true);
    ?>
      <div class="col-md-<?= $wide ? 12 : 6 ?>">
        <label class="form-label" for="<?= e($k) ?>"><?= e($f['label']) ?></label>

        <?php if ($type === 'textarea'): ?>
          <textarea class="form-control" id="<?= e($k) ?>" name="<?= e($k) ?>" rows="3"><?= e($val) ?></textarea>

        <?php elseif ($type === 'map'): ?>
          <textarea class="form-control" id="<?= e($k) ?>" name="<?= e($k) ?>" rows="3"><?= e($val) ?></textarea>
          <iframe class="w-100 mt-2" style="height:200px;border:0;border-radius:12px" src="<?= e($val) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

        <?php elseif ($type === 'image'): ?>
          <div class="img-field">
            <img class="preview <?= strpos($k, 'logo_') === 0 ? 'logo' : '' ?>" id="pv_<?= e($k) ?>" src="../<?= e(asset($val)) ?>" alt="">
            <div class="controls">
              <input type="file" class="form-control" name="file_<?= e($k) ?>" accept="image/jpeg,image/png,image/webp,image/gif"
                     onchange="if(this.files[0]){document.getElementById('pv_<?= e($k) ?>').src=URL.createObjectURL(this.files[0]);}">
              <?php if ($val !== $defaults[$k]): ?>
                <label class="check-row mt-2"><input type="checkbox" name="reset_<?= e($k) ?>" value="1"> Restore the original image</label>
              <?php endif; ?>
            </div>
          </div>

        <?php else: ?>
          <input type="text" class="form-control" id="<?= e($k) ?>" name="<?= e($k) ?>" value="<?= e($val) ?>"
                 <?= $type === 'url' ? 'placeholder="https://..."' : '' ?> maxlength="250">
        <?php endif; ?>

        <?php if (!empty($f['help'])): ?><div class="form-text"><?= e($f['help']) ?></div><?php endif; ?>
      </div>
    <?php endforeach; ?>
    </div>
  </div>
  <?php endforeach; ?>

  <div class="save-bar">
    <button type="submit" class="btn btn-ink px-4"><i class="fa-solid fa-floppy-disk me-1"></i> Save changes</button>
    <a href="../<?= e(['lodgespage' => 'lodges.php', 'comfortspage' => 'comforts.php', 'aboutpage' => 'about.php', 'contactpage' => 'contact.php'][$tab] ?? 'index.php') ?>" target="_blank" class="btn btn-soft">Open this page on the website</a>
  </div>
</form>

<?php require 'admin-include/footer.php'; ?>
