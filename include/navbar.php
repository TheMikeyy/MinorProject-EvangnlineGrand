<?php
  $current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container-fluid">
    <a class="navbar-brand me-3" href="index.php">
      <img src="images/logo/logo-dark.png" alt="Évangéline Grand" class="logo-img logo-img-transparent">
      <img src="images/logo/logo-light.png" alt="Évangéline Grand" class="logo-img logo-img-scrolled">
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
      <div class="d-flex">
        <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-3" data-bs-toggle="modal" data-bs-target="#signupModal">
          Signup
        </button>
        <button type="button" class="btn btn-dark shadow-none custom-bg" data-bs-toggle="modal" data-bs-target="#loginModal">
          Login
        </button>
      </div>
    </div>
  </div>
</nav>
 
<div class="modal fade" id="signupModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form>
        <div class="modal-header">
          <h5 class="modal-title d-flex align-items-center">
            <i class="bi bi-person-plus-fill fs-4 me-2"></i>User Signup
          </h5>
          <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
 
        <div class="modal-body">
          <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
            Note: Your details must match with your ID (Aadhar card, Passport, Driving license, Voter ID, etc.) that will be required during check-in.
          </span>
 
          <div class="container-fluid">
            <div class="row">
 
              <div class="col-md-6 mb-3">
                <label class="form-label">User Name</label>
                <input type="text" class="form-control shadow-none">
              </div>
 
              <div class="col-md-6 mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-control shadow-none">
              </div>
 
              <div class="col-md-6 mb-3">
                <label class="form-label">Phone Number</label>
                <input type="tel" class="form-control shadow-none">
              </div>
 
              <div class="col-md-6 mb-3">
                <label class="form-label">User Picture</label>
                <input type="file" class="form-control shadow-none">
              </div>
 
              <div class="col-md-12 mb-3">
                <label class="form-label">Communication Address</label>
                <textarea class="form-control shadow-none" rows="1"></textarea>
              </div>
 
              <div class="col-md-6 mb-3">
                <label class="form-label">Pin Code</label>
                <input type="number" class="form-control shadow-none">
              </div>
 
              <div class="col-md-6 mb-3">
                <label class="form-label">Date Of Birth</label>
                <input type="date" class="form-control shadow-none">
              </div>
 
              <div class="col-md-6 mb-3">
                <label class="form-label">Account Password</label>
                <input type="password" class="form-control shadow-none">
              </div>
 
              <div class="col-md-6 mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" class="form-control shadow-none">
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
      <form>
         <div class="modal-header">
        <h5 class="modal-title d-flex align-items-center">
        <i class="bi bi-person-circle fs-4 me-2"></i>User Login</h5>
        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
         <label class="form-label">Email address</label>
         <input type="email" class="form-control shadow-none">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
      </div>
       <div class="mb-4">
         <label class="form-label">Password</label>
         <input type="password" class="form-control shadow-none">
      </div>
      <div class="d-flex align-items-center justify-content-between mb-2">
        <button type="submit" class="btn btn-wine shadow-none">Submit</button>
        <a href="javascript: void(0)" class="text-secondary text-decoration-none">Forgot Password?</a>
      </div>
      </div>
      </form>
    </div>
  </div>
</div>
 