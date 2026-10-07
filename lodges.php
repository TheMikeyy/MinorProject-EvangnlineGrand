<?php require_once __DIR__ . '/admin/admin-include/db_config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Lodges | <?= e(setting('hotel_name')) ?></title>
    <?php require('include/links.php') ?>
</head>
<body class="bg-light">

<style>
  
  body{
      background-image: none !important;
    }

  /* ---------- Page hero  ---------- */
  .page-hero{
    position: relative;
    height: 420px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }

  .page-hero-bg{
    position: absolute;
    inset: 0;
    background-image: url('<?= e(img('lodges_banner')) ?>');
    background-size: cover;
    background-position: center;
    transform: scale(1.03);
  }

  .page-hero::after{
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(19,20,28,.66) 0%, rgba(19,20,28,.42) 45%, rgba(19,20,28,.8) 100%);
  }

  .page-hero-content{
    position: relative;
    z-index: 2;
    text-align: center;
    color: var(--paper);
    padding: 2rem 1rem 0;
  }

  .page-hero-logo{
    display: block;
    width: 46%;
    max-width: 460px;
    min-width: 260px;
    height: auto;
    margin: 1rem auto 0;
    filter: drop-shadow(0 3px 14px rgba(0,0,0,.4));
  }

  .page-hero-title{
    font-family: 'DM Serif Display', serif;
    letter-spacing: 1.5px;
    font-size: 2.2rem;
  }

  @media screen and (max-width: 575px){
    .page-hero{ height: 320px; }
    .page-hero-logo{
      width: 60%;
      min-width: 0;
      max-width: 400px;
      margin-top: .4rem;
    }
    .page-hero-eyebrow{ font-size: 1.6rem; }
    .page-hero-title{ font-size: 1.4rem; padding: 0 .5rem; }
  }

  /* ---------- Intro ---------- */
  .lodges-intro{
    padding-top: 5rem;
    padding-bottom: 1rem;
  }

  .lodges-intro p{
    max-width: 760px;
    margin: 1.25rem auto 0;
    color: var(--ink-black);
    font-size: 1.05rem;
    line-height: 1.8;
  }

  /* ---------- Filter bar  ---------- */
  .filters-wrap{
    padding-top: 2.5rem;
  }

  .filters-toggle-btn{
    width: 100%;
    border-radius: 50px;
    border: 1.5px solid rgba(31,42,82,.16);
    background-color: var(--paper);
    color: var(--ink);
    font-weight: 600;
    padding: .75rem 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
  }

  .filters-toggle-btn:hover{
    background-color: var(--cream);
  }

  .filters-panel{
    border-radius: 32px;
    background: rgba(255,255,255,.92);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,.5);
    box-shadow: 0 12px 30px rgba(31,42,82,.14);
    padding: 1.8rem 2rem 1.4rem;
    margin-top: 1rem;
  }

  @media (min-width: 992px){
    .filters-panel{
      margin-top: 0;
    }
  }

  .filters-panel label{
    font-size: .82rem;
    font-weight: 500;
    color: var(--ink);
    margin-bottom: .35rem;
  }

  .filters-panel .form-control,
  .filters-panel .form-select{
    border-radius: 14px;
  }

  .filters-panel .price-inputs{
    display: flex;
    align-items: center;
    gap: .5rem;
  }

  .filters-panel .price-inputs span{
    color: var(--muted);
    font-size: .85rem;
  }

  .filters-panel .btn{
    border-radius: 50px;
  }

  .filters-results-note{
    font-size: .9rem;
    color: var(--muted);
  }

  .filters-results-note strong{
    color: var(--ink);
  }

  /* ---------- Lodge grid ---------- */
  .lodges-grid-wrap{
    padding-top: 3rem;
    padding-bottom: 5rem;
  }

  #lodgeGrid{
    display: grid;
    gap: 1.8rem;
    grid-template-columns: repeat(2, 1fr);
  }

  @media (max-width: 767.98px){
    #lodgeGrid{ grid-template-columns: 1fr; }
  }

  .lodge-item{
    display: block;
  }

  .grid-card-wrap{ display: none !important; }
  .list-card-wrap{ display: block !important; }

  /* ---------- List card (horizontal, tap-to-reveal, mirrored parallel effect) ---------- */
  .list-card-flip{
    position: relative;
    height: 420px;
    border-radius: 26px;
    overflow: hidden;
    box-shadow: 0 14px 32px rgba(31,42,82,.12);
    background-color: var(--paper);
  }

  .list-card-image{
    position: absolute;
    inset: 0;
    z-index: 2;
    cursor: pointer;
    transition: transform .5s cubic-bezier(.2,.7,.3,1);
  }

  .list-card-image img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  .list-card-image::after{
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(19,20,28,0) 45%, rgba(19,20,28,.82) 100%);
  }

  .list-card-image-caption{
    position: absolute;
    left: 0; right: 0; bottom: 0;
    z-index: 1;
    padding: 1.2rem 1.4rem;
    color: var(--paper);
    transition: opacity .3s ease;
  }

  .list-card-flip.is-open .list-card-image-caption{
    opacity: 0;
    pointer-events: none;
  }

  .list-card-image-caption .lodge-tier{
    display: inline-block;
    font-size: .66rem;
    letter-spacing: 1.3px;
    text-transform: uppercase;
    color: var(--rose);
    font-weight: 600;
    margin-bottom: .2rem;
  }

  .list-card-image-caption h6{
    font-family: 'DM Serif Display', serif;
    font-size: 1.2rem;
    margin-bottom: .15rem;
  }

  .list-card-image-caption .tap-hint{
    font-size: .74rem;
    color: rgba(255,255,255,.75);
    display: flex;
    align-items: center;
    gap: .3rem;
  }

  /* Parallel effect: left-column cards slide their image right and the
     details stay/read on the LEFT; right-column cards slide their image
     left and the details stay/read on the RIGHT. The un-vacated side is
     reserved as padding on .list-card-details so text can never sit
     underneath the still-visible sliver of the image. */
  .list-card-flip[data-flip="left"].is-open .list-card-image{
    transform: translateX(58%);
  }

  .list-card-flip[data-flip="right"].is-open .list-card-image{
    transform: translateX(-58%);
  }

  .list-card-details{
    position: absolute;
    inset: 0;
    z-index: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 1.5rem 2rem;
    background: linear-gradient(135deg, var(--cream) 0%, var(--paper) 100%);
    overflow-y: auto;
  }

  .list-card-flip[data-flip="left"] .list-card-details{
    align-items: flex-start;
    text-align: left;
    padding-right: 44%;
  }

  .list-card-flip[data-flip="right"] .list-card-details{
    align-items: flex-end;
    text-align: right;
    padding-left: 44%;
  }

  .list-card-details .lodge-tier{
    font-size: .8rem;
    letter-spacing: 1.3px;
    text-transform: uppercase;
    color: var(--wine);
    font-weight: 600;
    margin-bottom: .35rem;
  }

  .list-card-details h5{
    font-family: 'DM Serif Display', serif;
    color: var(--ink);
    font-size: 1.4rem;
    line-height: 1.2;
    margin-bottom: .35rem;
  }

  .list-card-details .price-line{
    color: var(--muted);
    font-size: .92rem;
    margin-bottom: .55rem;
  }

  .list-card-details p.blurb{
    font-size: .85rem;
    color: var(--ink-black);
    line-height: 1.5;
    margin-bottom: .6rem;
  }

  .list-card-details .mini-label{
    font-size: .7rem;
    text-transform: uppercase;
    letter-spacing: .4px;
    color: var(--ink);
    font-weight: 600;
    margin-bottom: .2rem;
    margin-top: .1rem;
  }

  .list-card-details .pill-group{
    margin-bottom: .5rem;
  }

  .list-card-details .guests-limit{
    margin-bottom: .7rem;
  }

  .list-card-details .pill{
    display: inline-block;
    font-size: .72rem;
    padding: .3rem .65rem;
    margin: .12rem;
    border-radius: 30px;
    border: 1px solid rgba(122,35,51,.22);
    background-color: var(--cream);
    color: var(--ink);
  }

  .list-card-flip[data-flip="left"] .list-card-details .pill{ margin-left: 0; }
  .list-card-flip[data-flip="right"] .list-card-details .pill{ margin-right: 0; }

  .list-card-details .guests-limit .pill{
    font-size: .78rem;
    padding: .35rem .7rem;
  }

  .list-card-details .btn{
    width: auto;
    font-size: .92rem;
    font-weight: 600;
    padding: .5rem 1.4rem;
  }

  .list-card-close{
    display: none;
    position: absolute;
    top: 1rem;
    right: 1rem;
    z-index: 3;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    border: none;
    background-color: var(--paper);
    color: var(--ink);
    box-shadow: 0 6px 16px rgba(19,20,28,.18);
    align-items: center;
    justify-content: center;
    font-size: 14px;
    cursor: pointer;
  }

  .list-card-close:hover{
    background-color: var(--ink);
    color: var(--paper);
  }

  @media (max-width: 767.98px){
    .list-card-flip{ height: 340px; }

    
    .list-card-flip[data-flip="left"].is-open .list-card-image{
      transform: translateX(106%);
    }

    .list-card-flip[data-flip="right"].is-open .list-card-image{
      transform: translateX(-106%);
    }

    .list-card-details{ padding: 1.3rem 1.6rem; }

    .list-card-flip[data-flip="left"] .list-card-details,
    .list-card-flip[data-flip="right"] .list-card-details{
      align-items: flex-start;
      text-align: left;
      padding-right: 1.6rem;
      padding-left: 1.6rem;
    }

    .list-card-flip[data-flip="left"] .list-card-details .pill,
    .list-card-flip[data-flip="right"] .list-card-details .pill{
      margin-left: .12rem;
      margin-right: .12rem;
    }

    .list-card-details h5{ font-size: 1.2rem; padding-right: 2.2rem; }
    .list-card-details p.blurb{ font-size: .8rem; }

    .list-card-close{ display: flex; }
  }

  /* ---------- No results ---------- */
  .no-results{
    text-align: center;
    padding: 4rem 1rem;
    color: var(--muted);
  }

  .no-results i{
    font-size: 2.4rem;
    color: var(--wine);
    display: block;
    margin-bottom: 1rem;
  }
</style>

<?php
  $lodges = rows('SELECT * FROM lodges WHERE is_active = 1 ORDER BY sort_order, id');
  require('include/navbar.php');
?>

<!-- PAGE HERO -->
<div class="page-hero">
  <div class="page-hero-bg"></div>
  <div class="page-hero-content">
    <h1 class="page-hero-title">Our Lodges</h1>
    <img src="<?= e(img('logo_hero')) ?>" alt="<?= e(setting('hotel_name')) ?>" class="page-hero-logo">
  </div>
</div>

<!-- INTRO -->
<div class="container lodges-intro text-center">
  <span class="section-eyebrow d-block"><?= e(setting('lodges_eyebrow')) ?></span>
  <h2 class="mb-0 fw-bold section-font"><?= e(setting('lodges_title')) ?></h2>
  <div class="h-line bg-dark mx-auto mt-3"></div>
  <p>
    <?= e(setting('lodges_intro')) ?>
  </p>
</div>

<!-- FILTERS -->
<div class="container filters-wrap">
  <button class="filters-toggle-btn d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#filtersPanel" aria-expanded="false" aria-controls="filtersPanel">
    <i class="fa-solid fa-sliders"></i> Filters
  </button>

  <div class="collapse d-lg-block" id="filtersPanel">
    <div class="filters-panel">
      <form id="lodgeFilterForm">
        <div class="row g-3 align-items-end">

          <div class="col-lg-2 col-md-6 col-12">
            <label for="filterCheckin" class="form-label">Check-In</label>
            <input type="date" class="form-control shadow-none" id="filterCheckin" min="<?= date('Y-m-d') ?>">
          </div>

          <div class="col-lg-2 col-md-6 col-12">
            <label for="filterCheckout" class="form-label">Check-Out</label>
            <input type="date" class="form-control shadow-none" id="filterCheckout" min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
          </div>

          <div class="col-lg-2 col-md-6 col-12">
            <label for="filterAdults" class="form-label">Adults</label>
            <select class="form-select shadow-none" id="filterAdults">
              <option value="0" selected>Any</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
            </select>
          </div>

          <div class="col-lg-2 col-md-6 col-12">
            <label for="filterChildren" class="form-label">Children</label>
            <select class="form-select shadow-none" id="filterChildren">
              <option value="0" selected>Any</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
            </select>
          </div>

          <div class="col-lg-3 col-md-8 col-12">
            <label class="form-label">Price Range (per night)</label>
            <div class="price-inputs">
              <input type="number" min="0" step="500" class="form-control shadow-none" id="filterMinPrice" placeholder="Min">
              <span>to</span>
              <input type="number" min="0" step="500" class="form-control shadow-none" id="filterMaxPrice" placeholder="Max">
            </div>
          </div>

          <div class="col-lg-1 col-md-4 col-12">
            <button type="submit" class="btn text-white shadow-none custom-bg w-100">Apply</button>
          </div>
          
        </div>
        
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
          <span class="filters-results-note" id="filterResultsNote">Showing <strong><?= count($lodges) ?></strong> of <strong><?= count($lodges) ?></strong> lodges</span>
          <button type="button" class="btn btn-sm btn-outline-dark px-3 shadow-none" id="filterResetBtn">Reset Filters</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- LODGE GRID -->
<div class="container lodges-grid-wrap reveal">
  <div id="lodgeGrid" class="view-grid">

<?php foreach ($lodges as $i => $l): ?>
    <!-- <?= $i + 1 ?>: <?= e($l['name']) ?> -->
    <div class="lodge-item" data-id="<?= (int)$l['id'] ?>" data-price="<?= (int)$l['price_min'] ?>" data-adults="<?= (int)$l['max_adults'] ?>" data-children="<?= (int)$l['max_children'] ?>">
      <div class="list-card-wrap reveal">
        <div class="list-card-flip" data-flip="<?= $i % 2 === 0 ? 'left' : 'right' ?>">
          <div class="list-card-details">
            <button type="button" class="list-card-close" aria-label="Back to photo"><i class="fa-solid fa-image"></i></button>
            <?php if ($l['tier'] !== ''): ?><span class="lodge-tier"><?= e($l['tier']) ?></span><?php endif; ?>
            <h5><?= e($l['name']) ?></h5>
            <div class="price-line"><?= e(price_line($l['price_min'], $l['price_max'])) ?></div>
            <div class="stay-total fw-semibold mb-2 d-none"></div>
            <?php if (trim((string)$l['blurb']) !== ''): ?><p class="blurb"><?= e($l['blurb']) ?></p><?php endif; ?>
            <?php if (lines($l['features'])): ?>
            <div class="pill-group">
              <div class="mini-label">Features</div>
              <?php foreach (lines($l['features']) as $p): ?><span class="pill"><?= e($p) ?></span>
              <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <?php if (lines($l['facilities'])): ?>
            <div class="pill-group">
              <div class="mini-label">Facilities</div>
              <?php foreach (lines($l['facilities']) as $p): ?><span class="pill"><?= e($p) ?></span>
              <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <div class="guests-limit">
              <div class="mini-label">Guests Limit</div>
              <span class="pill"><?= e(adults_text($l['max_adults'])) ?></span>
              <?php if ((int)$l['max_children'] > 0): ?><span class="pill"><?= e(children_text($l['max_children'])) ?></span><?php endif; ?>
            </div>
            <a href="book.php?lodge=<?= (int)$l['id'] ?>" class="btn btn-sm text-white custom-bg shadow-none rounded-pill px-3 js-book">Book Now</a>
          </div>
          <div class="list-card-image">
            <img src="<?= e(asset($l['image'])) ?>" alt="<?= e($l['name']) ?>">
            <div class="list-card-image-caption">
              <?php if ($l['tier'] !== ''): ?><span class="lodge-tier"><?= e($l['tier']) ?></span><?php endif; ?>
              <h6><?= e($l['name']) ?></h6>
              <span class="tap-hint"><i class="fa-solid fa-hand-pointer"></i> Tap to view details</span>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php endforeach; ?>


  </div>

  <div class="no-results d-none" id="noResultsMsg">
    <i class="fa-solid fa-magnifying-glass"></i>
    <p class="mb-1 fw-bold">No lodges match those filters</p>
    <p class="mb-0">Try widening your price range or adjusting guest counts.</p>
  </div>
</div>

<!-- FOOTER -->
<?php require('include/footer.php') ?>

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
  var items = document.querySelectorAll('.reveal');
  if (!('IntersectionObserver' in window)) {
    items.forEach(function(el){ el.classList.add('is-visible'); });
    return;
  }
  var io = new IntersectionObserver(function(entries){
    entries.forEach(function(entry){
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        io.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
  items.forEach(function(el){ io.observe(el); });
})();

/* ---------- Tap-to-reveal: ---------- */
(function(){
  document.querySelectorAll('.list-card-image').forEach(function(img){
    img.addEventListener('click', function(){
      img.closest('.list-card-flip').classList.toggle('is-open');
    });
  });

  document.querySelectorAll('.list-card-close').forEach(function(btn){
    btn.addEventListener('click', function(e){
      e.stopPropagation();
      btn.closest('.list-card-flip').classList.remove('is-open');
    });
  });
})();

/* ---------- Lodge filters (guests, price, and REAL availability for the chosen dates) ---------- */
(function(){
  var form = document.getElementById('lodgeFilterForm');
  var lodgeItems = Array.prototype.slice.call(document.querySelectorAll('.lodge-item'));
  var totalCount = lodgeItems.length;
  var noResultsMsg = document.getElementById('noResultsMsg');
  var resultsNote = document.getElementById('filterResultsNote');
  var checkinInput = document.getElementById('filterCheckin');
  var checkoutInput = document.getElementById('filterCheckout');
  var adultsSel = document.getElementById('filterAdults'), childrenSel = document.getElementById('filterChildren');
  var resetBtn = document.getElementById('filterResetBtn');
  var seq = 0;

  function setBookLinks(){
    var hasDates = checkinInput.value && checkoutInput.value;
    lodgeItems.forEach(function(item){
      var a = item.querySelector('a.js-book'); if (!a) return;
      var q = new URLSearchParams({ lodge: item.getAttribute('data-id') });
      if (hasDates) { q.set('checkin', checkinInput.value); q.set('checkout', checkoutInput.value); }
      if (parseInt(adultsSel.value, 10) > 0) q.set('adults', adultsSel.value);
      if (parseInt(childrenSel.value, 10) > 0) q.set('children', childrenSel.value);
      a.setAttribute('href', 'book.php?' + q.toString());
    });
  }
  function showNote(visible, hiddenFull){
    resultsNote.innerHTML = 'Showing <strong>' + visible + '</strong> of <strong>' + totalCount + '</strong> lodges' +
      (hiddenFull ? ' &middot; <span>' + hiddenFull + ' fully booked for your dates</span>' : '');
  }
  function render(avail){
    var adults = parseInt(adultsSel.value, 10) || 0;
    var children = parseInt(childrenSel.value, 10) || 0;
    var minPrice = parseFloat(document.getElementById('filterMinPrice').value);
    var maxPrice = parseFloat(document.getElementById('filterMaxPrice').value);
    var visibleCount = 0, fullCount = 0;

    lodgeItems.forEach(function(item){
      var price = parseFloat(item.getAttribute('data-price'));
      var itemAdults = parseInt(item.getAttribute('data-adults'), 10);
      var itemChildren = parseInt(item.getAttribute('data-children'), 10);
      var info = avail && avail.lodges ? avail.lodges[item.getAttribute('data-id')] : null;
      var tot = item.querySelector('.stay-total');

      var matches = true;
      if (adults > 0 && itemAdults < adults) matches = false;
      if (children > 0 && itemChildren < children) matches = false;
      if (!isNaN(minPrice) && price < minPrice) matches = false;
      if (!isNaN(maxPrice) && price > maxPrice) matches = false;
      if (info && !info.available) { if (matches) fullCount++; matches = false; }

      if (tot) {
        if (info && info.available && matches) { tot.textContent = info.total_text + ' for ' + avail.nights + ' night' + (avail.nights > 1 ? 's' : ''); tot.classList.remove('d-none'); }
        else { tot.classList.add('d-none'); }
      }
      item.classList.toggle('d-none', !matches);
      if (matches) visibleCount++;
    });
    noResultsMsg.classList.toggle('d-none', visibleCount !== 0);
    showNote(visibleCount, fullCount);
    setBookLinks();
  }

  function applyFilters(e){
    if (e) e.preventDefault();
    checkoutInput.setCustomValidity('');
    if ((checkinInput.value && !checkoutInput.value) || (!checkinInput.value && checkoutInput.value)) {
      (checkinInput.value ? checkoutInput : checkinInput).setCustomValidity('Please choose both check-in and check-out dates');
      (checkinInput.value ? checkoutInput : checkinInput).reportValidity();
      (checkinInput.value ? checkoutInput : checkinInput).setCustomValidity('');
      return;
    }
    if (checkinInput.value && checkoutInput.value && checkoutInput.value <= checkinInput.value) {
      checkoutInput.setCustomValidity('Check-out must be after check-in');
      checkoutInput.reportValidity();
      return;
    }
    if (!checkinInput.value) { render(null); return; }          // no dates: filter by guests / price only

    var mine = ++seq;
    var q = new URLSearchParams({ checkin: checkinInput.value, checkout: checkoutInput.value });
    fetch('availability.php?' + q.toString()).then(function(r){ return r.json(); }).then(function(d){
      if (mine !== seq) return;
      if (!d.ok) { checkoutInput.setCustomValidity(d.message); checkoutInput.reportValidity(); checkoutInput.setCustomValidity(''); return; }
      render(d);
    }).catch(function(){ if (mine === seq) { render(null); } });
  }

  function resetFilters(){
    form.reset(); seq++;
    checkoutInput.setCustomValidity('');
    lodgeItems.forEach(function(item){ item.classList.remove('d-none'); var t = item.querySelector('.stay-total'); if (t) t.classList.add('d-none'); });
    noResultsMsg.classList.add('d-none');
    showNote(totalCount, 0); setBookLinks();
  }

  checkinInput.addEventListener('change', function(){
    if (checkinInput.value) { var d = new Date(checkinInput.value + 'T00:00:00'); d.setDate(d.getDate() + 1);
      checkoutInput.min = d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0'); }
  });
  form.addEventListener('submit', applyFilters);
  resetBtn.addEventListener('click', resetFilters);

  // arriving from the home page search (lodges.php?checkin=...&checkout=...&adults=2&children=0)
  var p = new URLSearchParams(window.location.search);
  if (p.get('checkin') && p.get('checkout')) {
    checkinInput.value = p.get('checkin'); checkoutInput.value = p.get('checkout');
    checkinInput.dispatchEvent(new Event('change'));
    if (p.get('adults')) adultsSel.value = p.get('adults');
    if (p.get('children')) childrenSel.value = p.get('children');
    applyFilters();
  } else { setBookLinks(); }
})();
</script>

</body>
</html>