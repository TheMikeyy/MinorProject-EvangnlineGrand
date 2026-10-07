<?php
/*
 * Reusable "list / add / edit / delete / move up-down" screen.
 * A page (admin-lodge.php, admin-team.php ...) only defines a $cfg array describing its table and
 * form fields, then does:   require 'admin-include/crud.php';
 *
 * $cfg keys:  table, page, title, singular, active, intro, fields[], card (function), group, group_labels
 * field keys: name, label, type (text|textarea|number|select|checkbox|image|icon), required, col (1-12),
 *             help, max, rows, min, max_val, options, nullable, default, list (suggestions), preview_class
 */
require_once __DIR__ . '/db_config.php';
require_admin();

$table  = $cfg['table'];
$page   = $cfg['page'];
$fields = $cfg['fields'];
$word   = $cfg['singular'];

$errors  = [];
$posted  = null;     // submitted values, kept to refill the form after a validation error
$edit_id = 0;

/* ================================================================== */
/* 1) Handle form submissions                                          */
/* ================================================================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';
    $id     = (int)($_POST['id'] ?? 0);

    /* ---- delete ---- */
    if ($action === 'delete' && $id) {
        $old = row("SELECT * FROM `$table` WHERE id = ?", [$id]);
        if ($old && !empty($cfg['can_delete']) && ($why = $cfg['can_delete']($old))) {
            flash_set('error', $why);
            redirect($page);
        }
        if ($old) {
            run("DELETE FROM `$table` WHERE id = ?", [$id]);
            foreach ($fields as $f) {
                if ($f['type'] === 'image') { delete_uploaded_image($old[$f['name']] ?? ''); }
            }
            flash_set('success', ucfirst($word) . ' deleted.');
        }
        redirect($page);
    }

    /* ---- move up / down (swaps the order number with the neighbour) ---- */
    if ($action === 'move' && $id) {
        $cur = row("SELECT * FROM `$table` WHERE id = ?", [$id]);
        if ($cur) {
            $sql = "SELECT id, sort_order FROM `$table`";
            $par = [];
            if (!empty($cfg['group'])) { $sql .= " WHERE `{$cfg['group']}` = ?"; $par[] = $cur[$cfg['group']]; }
            $list = rows($sql . ' ORDER BY sort_order ASC, id ASC', $par);
            $pos = null;
            foreach ($list as $i => $r) { if ((int)$r['id'] === $id) { $pos = $i; } }
            $to = ($_POST['dir'] ?? '') === 'up' ? $pos - 1 : $pos + 1;
            if ($pos !== null && isset($list[$to])) {
                $a = $list[$pos]; $b = $list[$to];
                $oa = (int)$a['sort_order']; $ob = (int)$b['sort_order'];
                if ($oa === $ob) { $ob = $oa + ($to > $pos ? 1 : -1); }   // tie safety
                run("UPDATE `$table` SET sort_order = ? WHERE id = ?", [$ob, $a['id']]);
                run("UPDATE `$table` SET sort_order = ? WHERE id = ?", [$oa, $b['id']]);
            }
        }
        redirect($page);
    }

    /* ---- save (add new or update existing) ---- */
    if ($action === 'save') {
        $existing = $id ? row("SELECT * FROM `$table` WHERE id = ?", [$id]) : null;
        if ($id && !$existing) { flash_set('error', 'That item no longer exists.'); redirect($page); }

        $vals = [];
        $newImages = [];
        foreach ($fields as $f) {
            $n = $f['name']; $key = 'f_' . $n; $label = $f['label'];
            $type = $f['type'];

            if ($type === 'checkbox') {
                $vals[$n] = isset($_POST[$key]) ? 1 : 0;

            } elseif ($type === 'number') {
                $raw = trim((string)($_POST[$key] ?? ''));
                if ($raw === '') {
                    if (!empty($f['nullable'])) { $vals[$n] = null; continue; }
                    if (!empty($f['required'])) { $errors[] = "$label is required."; }
                    $vals[$n] = (int)($f['default'] ?? 0);
                } elseif (!preg_match('/^\d+$/', $raw)) {
                    $errors[] = "$label must be a whole number (0 or more).";
                    $vals[$n] = 0;
                } else {
                    $v = (int)$raw;
                    if (isset($f['min']) && $v < $f['min']) { $v = (int)$f['min']; }
                    if (isset($f['max_val']) && $v > $f['max_val']) { $v = (int)$f['max_val']; }
                    $vals[$n] = $v;
                }

            } elseif ($type === 'select') {
                $raw  = (string)($_POST[$key] ?? '');
                $opts = array_map('strval', array_keys($f['options']));
                if (!in_array($raw, $opts, true)) {
                    $errors[] = "Please choose a valid value for $label.";
                    $vals[$n] = !empty($f['nullable']) ? null : (string)reset($opts);
                } else {
                    $vals[$n] = ($raw === '' && !empty($f['nullable'])) ? null : $raw;
                }

            } elseif ($type === 'image') {
                $err = null;
                $path = upload_image($key, $err);
                if ($err) { $errors[] = "$label: $err"; }
                if ($path) {
                    $vals[$n] = $path;
                    $newImages[$n] = $path;
                } elseif (!$existing && !empty($f['required']) && !$err) {
                    $errors[] = "Please choose an image ($label).";
                }

            } else {   // text, textarea, icon
                $raw = str_replace("\r\n", "\n", trim((string)($_POST[$key] ?? '')));
                $max = $f['max'] ?? ($type === 'textarea' ? 4000 : 250);
                if (mb_strlen($raw) > $max) { $errors[] = "$label is too long (maximum $max characters)."; }
                if (!empty($f['required']) && $raw === '') { $errors[] = "$label is required."; }
                $vals[$n] = $raw;
            }
        }

        if (!$errors) {
            if ($existing) {
                $set = implode(', ', array_map(fn($c) => "`$c` = ?", array_keys($vals)));
                run("UPDATE `$table` SET $set WHERE id = ?", array_merge(array_values($vals), [$id]));
                foreach ($newImages as $n => $p) { delete_uploaded_image($existing[$n] ?? ''); }
                flash_set('success', ucfirst($word) . ' updated. The change is already live on the website.');
            } else {
                $vals['sort_order'] = (int)value("SELECT COALESCE(MAX(sort_order), 0) + 1 FROM `$table`");
                $colsql = implode(', ', array_map(fn($c) => "`$c`", array_keys($vals)));
                $marks  = implode(', ', array_fill(0, count($vals), '?'));
                run("INSERT INTO `$table` ($colsql) VALUES ($marks)", array_values($vals));
                flash_set('success', ucfirst($word) . ' added. It is already live on the website.');
            }
            redirect($page);
        }
        // validation failed: throw away images uploaded in this attempt, show the form again
        foreach ($newImages as $p) { delete_uploaded_image($p); }
        $posted  = $_POST;
        $edit_id = $id;
    }
}

/* ================================================================== */
/* 2) Decide what to show                                              */
/* ================================================================== */
$view = 'list';
$row  = null;
if ($posted !== null) {
    $view = 'form';
    $row  = $edit_id ? row("SELECT * FROM `$table` WHERE id = ?", [$edit_id]) : null;
} elseif (isset($_GET['new'])) {
    $view = 'form';
} elseif (isset($_GET['edit'])) {
    $row = row("SELECT * FROM `$table` WHERE id = ?", [(int)$_GET['edit']]);
    if (!$row) { flash_set('error', 'That item was not found.'); redirect($page); }
    $view = 'form';
}

/* current value of a field, for the form */
function crud_val(array $f, ?array $row, ?array $posted) {
    $n = $f['name'];
    if ($posted !== null) {
        if ($f['type'] === 'checkbox') { return isset($posted['f_' . $n]) ? 1 : 0; }
        return $posted['f_' . $n] ?? '';
    }
    if ($row !== null) { return $row[$n] ?? ''; }
    return $f['default'] ?? '';
}
function crud_selected($optKey, $cur): bool {
    if (is_numeric((string)$optKey) && is_numeric((string)$cur) && (string)$cur !== '') { return (float)$optKey === (float)$cur; }
    return (string)$optKey === (string)($cur ?? '');
}

$page_title = $cfg['title'];
$active     = $cfg['active'];
require __DIR__ . '/header.php';
?>

<?php if ($view === 'list'): ?>

  <div class="page-head">
    <div>
      <h1><?= e($cfg['title']) ?></h1>
      <p><?= e($cfg['intro'] ?? '') ?></p>
    </div>
    <a href="<?= e($page) ?>?new=1" class="btn btn-ink"><i class="fa-solid fa-plus me-1"></i> Add <?= e($word) ?></a>
  </div>

  <?php
    $items = rows("SELECT * FROM `$table` ORDER BY sort_order ASC, id ASC");
    $groups = [];
    if (!empty($cfg['group'])) {
        foreach ($items as $it) { $groups[$it[$cfg['group']]][] = $it; }
    } else {
        $groups[''] = $items;
    }
  ?>

  <?php if (!$items): ?>
    <div class="panel-card empty-state">
      <i class="fa-regular fa-folder-open"></i>
      Nothing here yet. Click <b>Add <?= e($word) ?></b> to create the first one.
    </div>
  <?php endif; ?>

  <?php foreach ($groups as $gname => $gitems): ?>
    <?php if ($gname !== '' && !empty($cfg['group_labels'][$gname])): ?>
      <h2 class="h5 mt-4 mb-3" style="font-family:'DM Serif Display',serif;color:var(--ink)"><?= e($cfg['group_labels'][$gname]) ?></h2>
    <?php endif; ?>
    <div class="item-grid mb-3">
      <?php foreach ($gitems as $i => $it): $card = $cfg['card']($it); ?>
        <div class="item-card">
          <?php if (!empty($card['image'])): ?>
            <img class="thumb" src="../<?= e(asset($card['image'])) ?>" alt="" loading="lazy">
          <?php else: ?>
            <div class="thumb none"><i class="<?= e($card['icon'] ?? 'fa-solid fa-quote-left') ?>"></i></div>
          <?php endif; ?>
          <div class="body">
            <h3><?= e($card['title']) ?></h3>
            <div class="sub"><?= e($card['sub'] ?? '') ?></div>
            <div class="badges">
              <?php foreach (($card['badges'] ?? []) as [$btxt, $bcls]): ?>
                <span class="badge-pill <?= e($bcls) ?>"><?= e($btxt) ?></span>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="foot">
            <form method="post" class="m-0"><?= csrf_field() ?><input type="hidden" name="action" value="move"><input type="hidden" name="id" value="<?= (int)$it['id'] ?>"><input type="hidden" name="dir" value="up">
              <button class="mv" title="Move earlier" <?= $i === 0 ? 'disabled' : '' ?>><i class="fa-solid fa-arrow-up"></i></button></form>
            <form method="post" class="m-0"><?= csrf_field() ?><input type="hidden" name="action" value="move"><input type="hidden" name="id" value="<?= (int)$it['id'] ?>"><input type="hidden" name="dir" value="down">
              <button class="mv" title="Move later" <?= $i === count($gitems) - 1 ? 'disabled' : '' ?>><i class="fa-solid fa-arrow-down"></i></button></form>
            <span class="spacer"></span>
            <a class="btn-soft" href="<?= e($page) ?>?edit=<?= (int)$it['id'] ?>"><i class="fa-solid fa-pen me-1"></i>Edit</a>
            <form method="post" class="m-0" onsubmit="return confirm('Delete this <?= e($word) ?>? This cannot be undone.');">
              <?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$it['id'] ?>">
              <button class="btn-danger-soft" type="submit"><i class="fa-solid fa-trash"></i></button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endforeach; ?>

<?php else: /* ================= form view ================= */ ?>

  <div class="page-head">
    <div>
      <h1><?= $row || $edit_id ? 'Edit ' : 'Add ' ?><?= e($word) ?></h1>
      <p><?= e($cfg['form_intro'] ?? 'Fill in the details and press Save. The website updates immediately.') ?></p>
    </div>
    <a href="<?= e($page) ?>" class="btn btn-soft"><i class="fa-solid fa-arrow-left me-1"></i> Back to list</a>
  </div>

  <?php foreach ($errors as $er): ?><div class="flash error"><?= e($er) ?></div><?php endforeach; ?>

  <form method="post" enctype="multipart/form-data" class="panel-card" autocomplete="off">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="id" value="<?= (int)($row['id'] ?? $edit_id) ?>">

    <div class="row g-3">
    <?php foreach ($fields as $f):
        $n = $f['name']; $key = 'f_' . $n; $val = crud_val($f, $row, $posted);
        $col = (int)($f['col'] ?? 12);
    ?>
      <div class="col-md-<?= $col ?>">
      <?php if ($f['type'] === 'checkbox'): ?>
        <label class="check-row"><input type="checkbox" name="<?= e($key) ?>" value="1" <?= $val ? 'checked' : '' ?>> <?= e($f['label']) ?></label>
        <?php if (!empty($f['help'])): ?><div class="form-text ms-4"><?= e($f['help']) ?></div><?php endif; ?>

      <?php else: ?>
        <label class="form-label" for="<?= e($key) ?>"><?= e($f['label']) ?><?= !empty($f['required']) ? ' <span class="req">*</span>' : '' ?></label>

        <?php if ($f['type'] === 'textarea'): ?>
          <textarea class="form-control" id="<?= e($key) ?>" name="<?= e($key) ?>" rows="<?= (int)($f['rows'] ?? 3) ?>"><?= e($val) ?></textarea>

        <?php elseif ($f['type'] === 'select'): ?>
          <select class="form-select" id="<?= e($key) ?>" name="<?= e($key) ?>">
            <?php foreach ($f['options'] as $ok => $ol): ?>
              <option value="<?= e($ok) ?>" <?= crud_selected($ok, $val) ? 'selected' : '' ?>><?= e($ol) ?></option>
            <?php endforeach; ?>
          </select>

        <?php elseif ($f['type'] === 'number'): ?>
          <input type="number" min="<?= (int)($f['min'] ?? 0) ?>" <?= isset($f['max_val']) ? 'max="' . (int)$f['max_val'] . '"' : '' ?> step="1" class="form-control" id="<?= e($key) ?>" name="<?= e($key) ?>" value="<?= e($val) ?>">

        <?php elseif ($f['type'] === 'image'): ?>
          <div class="img-field">
            <img class="preview <?= e($f['preview_class'] ?? '') ?>" id="pv_<?= e($n) ?>" alt=""
                 src="<?= !empty($row[$n]) ? '../' . e(asset($row[$n])) : 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==' ?>">
            <div class="controls">
              <input type="file" class="form-control" id="<?= e($key) ?>" name="<?= e($key) ?>" accept="image/jpeg,image/png,image/webp,image/gif"
                     onchange="if(this.files[0]){document.getElementById('pv_<?= e($n) ?>').src=URL.createObjectURL(this.files[0]);}">
              <div class="form-text"><?= $row ? 'Leave empty to keep the current photo. ' : '' ?>JPG, PNG, WEBP or GIF, up to 8 MB.</div>
            </div>
          </div>

        <?php else: /* text / icon */ ?>
          <input type="text" class="form-control" id="<?= e($key) ?>" name="<?= e($key) ?>" value="<?= e($val) ?>" maxlength="<?= (int)($f['max'] ?? 250) ?>"
                 <?= !empty($f['list']) ? 'list="dl_' . e($n) . '"' : '' ?>>
          <?php if (!empty($f['list'])): ?>
            <datalist id="dl_<?= e($n) ?>"><?php foreach ($f['list'] as $opt): ?><option value="<?= e($opt) ?>"><?php endforeach; ?></datalist>
          <?php endif; ?>
        <?php endif; ?>

        <?php if (!empty($f['help']) && $f['type'] !== 'checkbox'): ?><div class="form-text"><?= e($f['help']) ?></div><?php endif; ?>
      <?php endif; ?>
      </div>
    <?php endforeach; ?>
    </div>

    <div class="d-flex gap-2 mt-4">
      <button type="submit" class="btn btn-ink px-4"><i class="fa-solid fa-floppy-disk me-1"></i> Save <?= e($word) ?></button>
      <a href="<?= e($page) ?>" class="btn btn-soft">Cancel</a>
    </div>
  </form>

<?php endif; ?>

<?php require __DIR__ . '/footer.php'; ?>
