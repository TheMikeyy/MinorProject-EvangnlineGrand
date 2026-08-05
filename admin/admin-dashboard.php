<?php
  session_start();

  if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-index.php');
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Évangéline Grand</title>
    <?php require('admin-include/links.php') ?>
</head>
<body class="bg-light">

<style>
  .admin-navbar{
    background-color: var(--ink);
    padding: .9rem 0;
    box-shadow: 0 4px 16px rgba(19,20,28,.14);
  }

  .admin-navbar .navbar-brand{
    display: flex;
    align-items: center;
    color: var(--paper) !important;
  }

  .admin-navbar .logo-img{
    height: 34px;
    width: auto;
    display: block;
  }

  .admin-navbar .admin-brand-label{
    font-family: 'DM Serif Display', serif;
    font-size: 1.1rem;
    color: var(--paper);
    margin-left: .7rem;
    letter-spacing: .3px;
  }

  .admin-navbar .btn-admin-back{
    background-color: transparent;
    border: 1.5px solid rgba(255,255,255,.5);
    color: var(--paper);
    font-weight: 500;
    border-radius: 50px;
    padding: .45rem 1.1rem;
    font-size: .9rem;
    transition: background-color .2s ease, border-color .2s ease;
  }

  .admin-navbar .btn-admin-back:hover{
    background-color: rgba(255,255,255,.12);
    border-color: rgba(255,255,255,.8);
    color: var(--paper);
  }

  .admin-navbar .btn-admin-logout{
    background-color: var(--wine);
    border: 1.5px solid var(--wine);
    color: var(--paper);
    font-weight: 600;
    border-radius: 50px;
    padding: .45rem 1.2rem;
    font-size: .9rem;
    transition: background-color .2s ease, border-color .2s ease;
  }

  .admin-navbar .btn-admin-logout:hover{
    background-color: var(--wine-deep);
    border-color: var(--wine-deep);
    color: var(--paper);
  }

  .admin-shell{
    min-height: calc(100vh - 70px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem 1rem;
  }

  .admin-shell h1{
    font-family: 'DM Serif Display', serif;
    color: var(--ink);
    font-size: 1.9rem;
    margin-bottom: .5rem;
  }

  .admin-shell p{
    color: var(--ink-black);
    font-size: 1rem;
  }
</style>

<nav class="navbar navbar-expand-lg admin-navbar">
  <div class="container-fluid">
    <a class="navbar-brand" href="admin-dashboard.php">
      <img src="admin-images/logo/logo-light.png" alt="Évangéline Grand" class="logo-img">
      <span class="admin-brand-label">Admin Panel</span>
    </a>
    <div class="d-flex gap-2">
      <a href="../index.php" class="btn btn-admin-back">Back to Site</a>
      <a href="admin-logout.php" class="btn btn-admin-logout">Logout</a>
    </div>
  </div>
</nav>

<div class="admin-shell text-center">
  <div>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></h1>
    <p>You're signed in to the Évangéline Grand admin panel.</p>
  </div>
</div>

<?php require('script.php') ?>

</body>
</html>