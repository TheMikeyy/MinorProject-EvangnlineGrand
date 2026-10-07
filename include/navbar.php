<?php
  $current_page = basename($_SERVER['PHP_SELF']);

  // logged-in guest (null when visiting as a stranger)
  $au = current_user();

  // a Signup / Login / Forgot pop-up that must re-open after a mistake (set by auth.php)
  $auth = $_SESSION['auth_modal'] ?? null;
  unset($_SESSION['auth_modal']);
  $auth_open = $auth ? ['signup' => 'signupModal', 'login' => 'loginModal', 'forgot' => 'forgotModal'][$auth['which']] ?? '' : '';
  $auth_errors = function (string $which) use ($auth): array { return ($auth && $auth['which'] === $which) ? $auth['errors'] : []; };
  $auth_old    = function (string $which, string $k) use ($auth): string { return ($auth && $auth['which'] === $which) ? (string)($auth['old'][$k] ?? '') : ''; };
  $return_to   = $auth['return'] ?? ($_SERVER['REQUEST_URI'] ?? 'index.php');
  $adult_limit = date('Y-m-d', strtotime('-18 years'));
?>

<nav class="navbar navbar-expand-lg navbar-light<?= !empty($navbar_solid) ? ' navbar-scrolled navbar-solid' : '' ?>">
  <div class="container-fluid">
    <a class="navbar-brand me-3" href="index.php">
      <img src="<?= e(img('logo_dark')) ?>" alt="<?= e(setting('hotel_name')) ?>" class="logo-img logo-img-transparent">
      <img src="<?= e(img('logo_light')) ?>" alt="<?= e(setting('hotel_name')) ?>" class="logo-img logo-img-scrolled">
    </a>
    <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link me-1 <?php if ($current_page === 'index.php') echo 'active'; ?>" aria-current="page" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link me-1 <?php if ($current_page === 'lodges.php') echo 'active'; ?>" href="lodges.php">Lodges</a>
      </li>
      <li class="nav-item">
        <a class="nav-link me-1 <?php if ($current_page === 'comforts.php') echo 'active'; ?>" href="comforts.php">Comforts</a>
      </li>
      <li class="nav-item">
        <a class="nav-link me-1 <?php if ($current_page === 'about.php') echo 'active'; ?>" href="about.php">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php if ($current_page === 'contact.php') echo 'active'; ?>" href="contact.php">Contact</a>
      </li>
      </ul>

      <?php if ($au): ?>
      <div class="dropdown">
        <button class="btn btn-outline-dark shadow-none dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?= user_avatar($au, 26) ?><span><?= e(explode(' ', trim($au['name']))[0]) ?></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end user-menu">
          <li><h6 class="dropdown-header text-truncate"><?= e($au['email']) ?></h6></li>
          <li><a class="dropdown-item" href="my-bookings.php"><i class="bi bi-calendar-check me-2"></i>My Bookings</a></li>
          <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person-gear me-2"></i>My Profile</a></li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <form method="post" action="logout.php" class="m-0">
              <?= csrf_field() ?>
              <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
            </form>
          </li>
        </ul>
      </div>
      <?php else: ?>
      <div class="d-flex">
        <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-3" data-bs-toggle="modal" data-bs-target="#signupModal">
          Signup
        </button>
        <button type="button" class="btn btn-dark shadow-none custom-bg" data-bs-toggle="modal" data-bs-target="#loginModal">
          Login
        </button>
      </div>
      <?php endif; ?>
    </div>
  </div>
</nav>

<?php $toasts = toast_take(); if ($toasts): ?>
<div class="site-toasts">
  <?php foreach ($toasts as $t): ?>
    <div class="alert alert-<?= $t['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible shadow site-toast" role="alert">
      <?= e($t['msg']) ?>
      <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endforeach; ?>
</div>
<?php endif; ?>

<?php if (!$au): ?>
<div class="modal fade" id="signupModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form method="post" action="auth.php?action=signup" enctype="multipart/form-data" autocomplete="on">
        <?= csrf_field() ?>
        <input type="hidden" name="return" value="<?= e($return_to) ?>">
        <div class="modal-header">
          <h5 class="modal-title d-flex align-items-center" id="signupModalLabel">
            <i class="bi bi-person-plus-fill fs-4 me-2"></i>User Signup
          </h5>
          <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <?php foreach ($auth_errors('signup') as $er): ?><div class="alert alert-danger py-2 mb-2"><?= e($er) ?></div><?php endforeach; ?>
          <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
            Note: Your details must match with your ID (Aadhar card, Passport, Driving license, Voter ID, etc.) that will be required during check-in.
          </span>

          <div class="container-fluid">
            <div class="row">

              <div class="col-md-6 mb-3">
                <label class="form-label">User Name</label>
                <input type="text" name="name" class="form-control shadow-none" required maxlength="100" autocomplete="name" value="<?= e($auth_old('signup', 'name')) ?>">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control shadow-none" required maxlength="150" autocomplete="email" value="<?= e($auth_old('signup', 'email')) ?>">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Phone Number</label>
                <input type="tel" name="phone" class="form-control shadow-none" required maxlength="20" autocomplete="tel" value="<?= e($auth_old('signup', 'phone')) ?>">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">User Picture <span class="text-muted small">(optional)</span></label>
                <input type="file" name="picture" class="form-control shadow-none" accept="image/jpeg,image/png,image/webp,image/gif">
              </div>

              <div class="col-md-12 mb-3">
                <label class="form-label">Communication Address</label>
                <textarea name="address" class="form-control shadow-none" rows="2" required maxlength="300" autocomplete="street-address"><?= e($auth_old('signup', 'address')) ?></textarea>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Pin Code</label>
                <input type="text" name="pincode" class="form-control shadow-none" required maxlength="10" autocomplete="postal-code" value="<?= e($auth_old('signup', 'pincode')) ?>">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Date Of Birth</label>
                <input type="date" name="dob" class="form-control shadow-none" required max="<?= e($adult_limit) ?>" autocomplete="bday" value="<?= e($auth_old('signup', 'dob')) ?>">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Account Password</label>
                <input type="password" name="password" class="form-control shadow-none" required minlength="8" autocomplete="new-password">
                <div class="form-text">At least 8 characters.</div>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control shadow-none" required minlength="8" autocomplete="new-password">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-center border-0 pt-0">
          <button type="submit" class="btn btn-wine shadow-none px-4">Register</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="auth.php?action=login">
        <?= csrf_field() ?>
        <input type="hidden" name="return" value="<?= e($return_to) ?>">
        <div class="modal-header">
          <h5 class="modal-title d-flex align-items-center" id="loginModalLabel">
          <i class="bi bi-person-circle fs-4 me-2"></i>User Login</h5>
          <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <?php foreach ($auth_errors('login') as $er): ?><div class="alert alert-danger py-2"><?= e($er) ?></div><?php endforeach; ?>
          <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" name="email" class="form-control shadow-none" required autocomplete="email" value="<?= e($auth_old('login', 'email')) ?>">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control shadow-none" required autocomplete="current-password">
          </div>
          <div class="form-check mb-4">
            <input class="form-check-input shadow-none" type="checkbox" name="remember" value="1" id="rememberMe">
            <label class="form-check-label" for="rememberMe">Keep me logged in on this device (30 days)</label>
          </div>
          <div class="d-flex align-items-center justify-content-between mb-2">
            <button type="submit" class="btn btn-wine shadow-none">Submit</button>
            <a href="#" class="text-secondary text-decoration-none" data-switch-modal="#forgotModal">Forgot Password?</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="forgotModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="forgotModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="auth.php?action=forgot">
        <?= csrf_field() ?>
        <input type="hidden" name="return" value="<?= e($return_to) ?>">
        <div class="modal-header">
          <h5 class="modal-title d-flex align-items-center" id="forgotModalLabel">
          <i class="bi bi-key-fill fs-4 me-2"></i>Forgot Password</h5>
          <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <?php foreach ($auth_errors('forgot') as $er): ?><div class="alert alert-danger py-2"><?= e($er) ?></div><?php endforeach; ?>
          <p class="text-secondary">Enter the email address of your account. We will send you a link to choose a new password.</p>
          <div class="mb-4">
            <label class="form-label">Email address</label>
            <input type="email" name="email" class="form-control shadow-none" required autocomplete="email" value="<?= e($auth_old('forgot', 'email')) ?>">
          </div>
          <div class="d-flex align-items-center justify-content-between mb-2">
            <button type="submit" class="btn btn-wine shadow-none">Send reset link</button>
            <a href="#" class="text-secondary text-decoration-none" data-switch-modal="#loginModal">Back to login</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>
