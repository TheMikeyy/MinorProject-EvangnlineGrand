  </main>
</div>

<?php require __DIR__ . '/../script.php'; ?>
<script>
  // phone menu: the Menu button slides the left panel in; backdrop, Escape or a link closes it
  (function () {
    var b = document.body, t = document.getElementById('adminMenuToggle'), k = document.getElementById('adminBackdrop');
    function close() { b.classList.remove('menu-open'); }
    if (t) { t.addEventListener('click', function () { b.classList.toggle('menu-open'); }); }
    if (k) { k.addEventListener('click', close); }
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { close(); } });
    document.querySelectorAll('.admin-side a').forEach(function (a) { a.addEventListener('click', close); });
    window.addEventListener('resize', function () { if (window.innerWidth > 991) { close(); } });
  })();
</script>
</body>
</html>
