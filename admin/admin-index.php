<?php
  require_once 'admin-include/db_config.php';   // starts the session + connects to the database

  // Already logged in? skip straight to the dashboard.
  if (!empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-dashboard.php');
    exit;
  }

  $error = '';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $name     = trim($_POST['name'] ?? '');
    $password = (string)($_POST['password'] ?? '');

    $wait = ($_SESSION['login_locked_until'] ?? 0) - time();
    if ($wait > 0) {
      // too many wrong attempts: block for a minute
      $error = 'Too many failed attempts. Please wait ' . $wait . ' seconds and try again.';
    } elseif ($name === '' || $password === '') {
      $error = 'Please enter both your name and password.';
    } else {
      $admin = row('SELECT sr_no, admin_mail, admin_pass FROM admin_cred WHERE admin_mail = ? LIMIT 1', [$name]);
      $ok = false;
      if ($admin) {
        if (password_verify($password, $admin['admin_pass'])) {
          $ok = true;
          if (password_needs_rehash($admin['admin_pass'], PASSWORD_DEFAULT)) {
            run('UPDATE admin_cred SET admin_pass = ? WHERE sr_no = ?', [password_hash($password, PASSWORD_DEFAULT), $admin['sr_no']]);
          }
        } elseif (strpos($admin['admin_pass'], '$2y$') !== 0 && hash_equals($admin['admin_pass'], $password)) {
          // an old plain-text password: accept it once and convert it to a secure hash
          $ok = true;
          run('UPDATE admin_cred SET admin_pass = ? WHERE sr_no = ?', [password_hash($password, PASSWORD_DEFAULT), $admin['sr_no']]);
        }
      }

      if ($ok) {
        session_regenerate_id(true);      // fresh session ID on every successful login
        unset($_SESSION['login_fails'], $_SESSION['login_locked_until']);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id']   = (int)$admin['sr_no'];
        $_SESSION['admin_name'] = $admin['admin_mail'];
        header('Location: admin-dashboard.php');
        exit;
      }

      $_SESSION['login_fails'] = ($_SESSION['login_fails'] ?? 0) + 1;
      if ($_SESSION['login_fails'] >= 5) {
        $_SESSION['login_locked_until'] = time() + 60;
        $_SESSION['login_fails'] = 0;
      }
      $error = 'Incorrect name or password.';
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Évangéline Grand</title>
    <?php require('admin-include/links.php') ?>
</head>
<body class="bg-light">

<style>
  html, body{
    height: 100%;
  }

  body{
    position: relative;
    background-image: url('admin-images/adminpage/1.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
  }

  body::before{
    content: "";
    position: fixed;
    inset: 0;
    background-color: rgba(0,0,0,.7);
    z-index: 0;
  }

  .admin-login-wrap{
    position: relative;
    z-index: 1;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
  }

  .admin-login-outer{
    width: 100%;
    max-width: 440px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
  }

  .admin-login-card{
    width: 100%;
    max-width: 440px;
    background-color: var(--paper);
    border-radius: 28px;
    box-shadow: 0 26px 60px rgba(19,20,28,.35);
    padding: 2.6rem 2.4rem 2.2rem;
  }

  .admin-login-logo{
    display: block;
    width: 64%;
    max-width: 260px;
    height: auto;
    margin: 0 auto 1.4rem;
  }

  .admin-login-title{
    text-align: center;
    font-family: serif;
    color: var(--ink);
    font-size: 1.7rem;
    margin-bottom: .4rem;
  }

  .admin-login-sub{
    text-align: center;
    color: var(--ink-black);
    font-size: .92rem;
    margin-bottom: 2rem;
  }

  .admin-login-card label{
    font-size: .85rem;
    font-weight: 500;
    color: var(--ink);
    margin-bottom: .4rem;
  }

  .admin-login-card .form-control{
    border-radius: 12px;
    border: 1.5px solid rgba(31,42,82,.14);
    padding: .7rem .95rem;
    font-size: .95rem;
    background-color: var(--cream);
  }

  .admin-login-card .form-control:focus{
    background-color: var(--paper);
    border-color: var(--ink);
    box-shadow: 0 0 0 3px rgba(31,42,82,.14);
  }

  .admin-login-card .mb-3{
    margin-bottom: 1.3rem !important;
  }

  .password-field{
    position: relative;
  }

  .password-toggle{
    position: absolute;
    top: 50%;
    right: .9rem;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--ink-black);
    font-size: .95rem;
    cursor: pointer;
    padding: .2rem;
  }

  .password-toggle:hover{
    color: var(--ink);
  }

  .admin-login-options{
    display: flex;
    align-items: center;
    justify-content: flex-end;
    font-size: .85rem;
    margin-bottom: 1.6rem;
  }

  .admin-login-options a{
    color: var(--ink);
    text-decoration: none;
  }

  .admin-login-options a:hover{
    text-decoration: underline;
  }

  .admin-login-options .form-check-label{
    color: var(--ink-black);
  }

  .admin-login-error{
    background-color: #f1f1f3;
    border: 1px solid #c9c9d0;
    color: #26262b;
    font-size: .88rem;
    border-radius: 12px;
    padding: .7rem .9rem;
    margin-bottom: 1.3rem;
    text-align: center;
  }

  .btn-admin-login{
    width: 100%;
    background-color: var(--ink);
    border: 1px solid var(--ink);
    color: var(--paper);
    font-weight: 600;
    letter-spacing: .3px;
    padding: .7rem 1rem;
    border-radius: 50px;
    transition: background-color .25s ease, transform .2s ease;
  }

  .btn-admin-login:hover{
    background-color: #2c3c74;
    border-color: #2c3c74;
    color: var(--paper);
    transform: translateY(-1px);
  }

  .admin-login-back{
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    font-size: 1.05rem;
    font-weight: 600;
    color: var(--paper);
    text-decoration: none;
    margin-bottom: 1.1rem;
  }

  .admin-login-back:hover{
    color: rgba(255,255,255,.75);
  }

  .admin-login-footnote{
    text-align: center;
    font-size: 0.9rem;
    color: var(--ink-black);
    margin-top: 1.6rem;
  }

  @media screen and (max-width: 420px){
    .admin-login-card{
      padding: 2.2rem 1.6rem 1.8rem;
      border-radius: 22px;
    }
  }
</style>

<div class="admin-login-wrap">
  <div class="admin-login-outer align-items-center">
    <a href="../index.php" class="admin-login-back"><i class="fa-solid fa-arrow-left"></i> Back to Site</a>
    <div class="admin-login-card">
      <img src="admin-images/logo/logo-light.png" alt="Évangéline Grand" class="admin-login-logo">
      <h1 class="admin-login-title">ADMIN ACCESS</h1>
      <p class="admin-login-sub">Login with your admin account to manage & change the property.</p>

    <?php if ($error): ?>
      <div class="admin-login-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="" method="POST">
      <?= csrf_field() ?>
      <div class="mb-3">
        <label for="adminName" class="form-label">Name</label>
        <input required type="text" class="form-control" id="adminName" name="name" placeholder="Enter your name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
      </div>

      <div class="mb-3">
        <label for="adminPassword" class="form-label">Password</label>
        <div class="password-field">
          <input required type="password" class="form-control" id="adminPassword" name="password" placeholder="Enter your password">
          <button type="button" class="password-toggle" id="togglePassword" aria-label="Show password">
            <i class="fa-solid fa-eye"></i>
          </button>
        </div>
      </div>

      <div class="admin-login-options">
        <a href="#">Forgot password?</a>
      </div>

      <button type="submit" class="btn btn-admin-login">Sign In</button>
    </form>

    <p class="admin-login-footnote">Restricted to authorized Évangéline Grand staff only.</p>
    </div>
  </div>
</div>

<?php require('script.php') ?>

<script>
  (function(){
    var toggle = document.getElementById('togglePassword');
    var field = document.getElementById('adminPassword');
    toggle.addEventListener('click', function(){
      var isPassword = field.getAttribute('type') === 'password';
      field.setAttribute('type', isPassword ? 'text' : 'password');
      toggle.innerHTML = isPassword
        ? '<i class="fa-solid fa-eye-slash"></i>'
        : '<i class="fa-solid fa-eye"></i>';
      toggle.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
    });
  })();
</script>

</body>
</html>