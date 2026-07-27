<div class="container-fluid site-footer pt-5 pb-4">
  <div class="container">
    <hr class="footer-divider">
    <div class="row align-items-start">
      <div class="col-lg-4 mb-4 mb-lg-0">
        <h3 class="h-font fw-bold fs-3 mb-3">Évangéline Grand</h3>
        <p>The perfect mix of reliable comfort and warm, genuine hospitality. Our peaceful lodges give you exactly what you need for a restful night's sleep.</p>
      </div>
      <div class="col-lg-4 mb-4 mb-lg-0 text-lg-center">
        <h5 class="mb-3">Quick Links</h5>
        <a href="#" class="d-inline-block mb-2 text-decoration-none">Home</a><br>
        <a href="#lodges" class="d-inline-block mb-2 text-decoration-none">Lodges</a><br>
        <a href="#comforts" class="d-inline-block mb-2 text-decoration-none">Comforts</a><br>
        <a href="#" class="d-inline-block mb-2 text-decoration-none">About</a><br>
        <a href="#locate" class="d-inline-block mb-2 text-decoration-none">Contact</a>
      </div>
      <div class="col-lg-4 text-lg-end">
        <h5 class="mb-3">Follow Us</h5>
        <a href="#" class="d-inline-block mb-2 text-decoration-none">
          <i class="bi bi-instagram me-1"></i> Instagram
        </a><br>
        <a href="#" class="d-inline-block mb-2 text-decoration-none">
          <i class="bi bi-facebook me-1"></i> Facebook
        </a><br>
        <a href="#" class="d-inline-block mb-2 text-decoration-none">
          <i class="bi bi-youtube me-1"></i> Youtube
        </a><br>
        <a href="#" class="d-inline-block text-decoration-none">
          <i class="bi bi-twitter-x me-1"></i> X (Formerly Twitter)
        </a>
      </div>
    </div>
  </div>
</div>
 
<h6 class="text-center footer-bottom p-3 m-0">© 2026 <span class="footer-brand-font">Évangéline Grand</span>. All rights reserved.</h6>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>

(function(){
  var nav = document.querySelector('.navbar');
  function onScroll(){
    if (window.scrollY > 40) {
      nav.classList.add('navbar-scrolled');
    } else {
      nav.classList.remove('navbar-scrolled');
    }
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
})();

(function(){
  var PAGE_ORDER = { 'index.php': 0, 'comforts.php': 1 }; // add new pages here as you build them, in site order

  function pageKey(url){
    var path = new URL(url, location.href).pathname.split('/').pop();
    return path === '' ? 'index.php' : path;
  }

  window.addEventListener('pageswap', function(e){
    if (!e.viewTransition || !e.activation) return;
    var from = PAGE_ORDER[pageKey(location.href)] ?? 0;
    var to = PAGE_ORDER[pageKey(e.activation.entry.url)] ?? 0;
    document.documentElement.setAttribute('data-transition', to < from ? 'back' : 'forward');
  });

  window.addEventListener('pagereveal', function(e){
    if (!e.viewTransition || !window.navigation || !navigation.activation || !navigation.activation.from) return;
    var from = PAGE_ORDER[pageKey(navigation.activation.from.url)] ?? 0;
    var to = PAGE_ORDER[pageKey(location.href)] ?? 0;
    document.documentElement.setAttribute('data-transition', to < from ? 'back' : 'forward');
  });
})();

</script>
