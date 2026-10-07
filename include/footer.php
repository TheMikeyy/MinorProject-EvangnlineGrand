<div class="container-fluid site-footer pt-5 pb-4">
  <div class="container">
    <hr class="footer-divider">
    <div class="row align-items-start">
      <div class="col-lg-4 mb-4 mb-lg-0">
        <h3 class="h-font fw-bold fs-3 mb-3"><?= e(mb_strtoupper(setting('hotel_name'))) ?></h3>
        <p><?= e(setting('footer_about')) ?></p>
      </div>
      <div class="col-lg-4 mb-4 mb-lg-0 text-lg-center">
        <h5 class="mb-3">Quick Links</h5>
        <a href="index.php" class="d-inline-block mb-2 text-decoration-none">Home</a><br>
        <a href="lodges.php" class="d-inline-block mb-2 text-decoration-none">Lodges</a><br>
        <a href="comforts.php" class="d-inline-block mb-2 text-decoration-none">Comforts</a><br>
        <a href="about.php" class="d-inline-block mb-2 text-decoration-none">About</a><br>
        <a href="contact.php" class="d-inline-block mb-2 text-decoration-none">Contact</a>
      </div>
      <div class="col-lg-4 text-lg-end">
        <h5 class="mb-3">Follow Us</h5>
        <a <?= social_attrs('social_instagram') ?> class="d-inline-block mb-2 text-decoration-none">
          <i class="bi bi-instagram me-1"></i> Instagram
        </a><br>
        <a <?= social_attrs('social_facebook') ?> class="d-inline-block mb-2 text-decoration-none">
          <i class="bi bi-facebook me-1"></i> Facebook
        </a><br>
        <a <?= social_attrs('social_youtube') ?> class="d-inline-block mb-2 text-decoration-none">
          <i class="bi bi-youtube me-1"></i> Youtube
        </a><br>
        <a <?= social_attrs('social_x') ?> class="d-inline-block text-decoration-none">
          <i class="bi bi-twitter-x me-1"></i> X (Formerly Twitter)
        </a>
      </div>
    </div>
  </div>
</div>
 
<h6 class="text-center footer-bottom p-3 m-0">© <?= date('Y') ?> <span class="footer-brand-font"><?= e(setting('hotel_name')) ?></span>. All rights reserved. <span class="staff-link"><a href="admin/admin-index.php">Staff Login</a></span></h6>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>

(function(){
  var nav = document.querySelector('.navbar');
  function onScroll(){
    if (nav.classList.contains('navbar-solid')) { return; }   // account pages keep the light navbar
    if (window.scrollY > 40) {
      nav.classList.add('navbar-scrolled');
    } else {
      nav.classList.remove('navbar-scrolled');
    }
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
})();

</script>

<script>
  // re-open the Signup / Login / Forgot pop-up after a mistake, and switch between pop-ups
  document.addEventListener('DOMContentLoaded', function () {
    <?php if (!empty($auth_open)): ?>
    var open = document.getElementById('<?= e($auth_open) ?>');
    if (open) { new bootstrap.Modal(open).show(); }
    <?php endif; ?>
    document.querySelectorAll('[data-switch-modal]').forEach(function (a) {
      a.addEventListener('click', function (ev) {
        ev.preventDefault();
        var from = a.closest('.modal'), to = document.querySelector(a.getAttribute('data-switch-modal'));
        var f = bootstrap.Modal.getInstance(from) || new bootstrap.Modal(from);
        var go = function () {
          if (f._isTransitioning) { setTimeout(go, 80); return; }          // wait until the pop-up has finished fading in
          from.addEventListener('hidden.bs.modal', function () { new bootstrap.Modal(to).show(); }, { once: true });
          f.hide();
        };
        go();
      });
    });
    // pop-up notices fade away by themselves
    setTimeout(function () { document.querySelectorAll('.site-toast').forEach(function (t) { t.classList.remove('show'); setTimeout(function () { t.remove(); }, 400); }); }, 6000);
  });
</script>
