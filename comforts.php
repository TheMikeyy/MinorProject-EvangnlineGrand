<?php require_once __DIR__ . '/admin/admin-include/db_config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comforts | <?= e(setting('hotel_name')) ?></title>
    <?php require('include/links.php') ?>
</head>
<body class="bg-light">

<style>

 :root{
    --ink: #1F2A52;
    --ink-black: #13141C;
  }

  /* ---------- Page hero (interior pages) ---------- */
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
    background-image: url('<?= e(img('comforts_banner')) ?>');
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

  .page-hero-eyebrow{
    display: block;
    font-family: "Great Vibes", cursive;
    font-size: 2.2rem;
    color: var(--rose);
    margin-bottom: -.1rem;
  }

  /* ---------- Hero Logo (unified with index page sizing) ---------- */
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
  .comfort-intro{
    padding-top: 5rem;
    padding-bottom: 1rem;
  }

  .comfort-intro p{
    max-width: 760px;
    margin: 1.25rem auto 0;
    color: var(--ink-black);
    font-size: 1.05rem;
    line-height: 1.8;
  }

  /* ---------- Comfort cards ---------- */
  .comfort-grid{
    padding-top: 2rem;
    padding-bottom: 4rem;
  }

  .comfort-card{
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 26px rgba(31,42,82,.08);
    background-color: var(--paper);
    height: 100%;
  }

  .comfort-card img{
    height: 210px;
    object-fit: cover;
    width: 100%;
  }

  .comfort-icon-badge{
    width: 46px;
    height: 46px;
    min-width: 46px;
    border-radius: 50%;
    border: 1.5px solid rgba(122,35,51,.3);
    background-color: var(--cream);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--wine);
    font-size: 18px;
    margin: -38px auto 14px;
    position: relative;
    z-index: 1;
    box-shadow: 0 6px 14px rgba(19,20,28,.14);
  }

  .comfort-card h5{
    font-family: 'DM Serif Display', serif;
    color: var(--ink);
    margin-bottom: .6rem;
  }

  .comfort-card .card-body-pad{
    padding: 0 1.4rem 1.6rem;
  }

  .comfort-card p{
    color: var(--ink-black);
    font-size: .92rem;
    line-height: 1.65;
  }

  /* ---------- Signature feature rows ---------- */
  .signature-section{
    padding-top: 5rem;
    padding-bottom: 5rem;
  }

  .feature-row{
    display: flex;
    align-items: center;
    gap: 3rem;
    margin-bottom: 4.5rem;
  }

  .feature-row:last-child{ margin-bottom: 0; }

  .feature-row.reverse{
    flex-direction: row-reverse;
  }

  .feature-row img{
    border-radius: 16px;
    box-shadow: 0 16px 34px rgba(31,42,82,.14);
    width: 100%;
    height: 340px;
    object-fit: cover;
  }

  .feature-text .lodge-tier{
    display: inline-block;
    font-size: .7rem;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--wine);
    font-weight: 600;
    margin-bottom: .6rem;
  }

  .feature-text h3{
    font-family: 'DM Serif Display', serif;
    color: var(--ink);
    margin-bottom: 1rem;
  }

  .feature-text p{
    color: var(--ink-black);
    line-height: 1.8;
  }

  @media (max-width: 991.98px){
    .feature-row,
    .feature-row.reverse{
      flex-direction: column;
      gap: 1.5rem;
      margin-bottom: 3rem;
    }
    .feature-row img{ height: 260px; }
  }

  /* ---------- CTA banner ---------- */
  .comfort-cta{
    position: relative;
    overflow: hidden;
    padding: 5rem 0;
    margin-top: 2rem;
  }

  .comfort-cta-bg{
    position: absolute;
    inset: 0;
    background-image: url('<?= e(img('cta_bg')) ?>');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    filter: brightness(80%) saturate(1.05);
    transform: scale(1.03);
  }

  .comfort-cta::after{
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(19,20,28,.7) 0%, rgba(19,20,28,.75) 100%);
  }

  .comfort-cta-content{
    position: relative;
    z-index: 2;
    text-align: center;
    color: var(--paper);
  }

  .comfort-cta-content h2{
    font-family: 'DM Serif Display', serif;
    letter-spacing: 1px;
    margin-bottom: .75rem;
  }
</style>

<?php require('include/navbar.php') ?>

<!-- PAGE HERO -->
<div class="page-hero">
  <div class="page-hero-bg"></div>
  <div class="page-hero-content">
    <h1 class="page-hero-title">OUR COMFORTS</h1>
    <img src="<?= e(img('logo_hero')) ?>" alt="<?= e(setting('hotel_name')) ?>" class="page-hero-logo">
  </div>
</div>

<!-- INTRO -->
<div class="container comfort-intro text-center">
  <h2 class="mb-0 fw-bold section-font"><?= e(setting('comforts_title')) ?></h2>
  <div class="h-line bg-dark mx-auto mt-3"></div>
  <p>
    <?= e(setting('comforts_intro')) ?>
  </p>
</div>

<!-- COMFORT CARDS -->
<div class="container comfort-grid">
  <div class="row g-4">

    <?php foreach (rows("SELECT * FROM comforts WHERE is_active = 1 AND section = 'card' ORDER BY sort_order, id") as $c): ?>
    <div class="col-lg-4 col-md-6 reveal">
      <div class="comfort-card shadow lodge-hover">
        <img src="<?= e(asset($c['image'])) ?>" alt="<?= e($c['title']) ?>">
        <?php if ($c['icon'] !== ''): ?><div class="comfort-icon-badge"><i class="<?= e($c['icon']) ?>"></i></div><?php endif; ?>
        <div class="text-center card-body-pad">
          <h5><?= e($c['title']) ?></h5>
          <p><?= e($c['description']) ?></p>
        </div>
      </div>
    </div>
    <?php endforeach; ?>

  </div>
</div>

<!-- SIGNATURE COMFORTS -->
<div class="section-white signature-section">
  <div class="text-center section-head reveal">
    <span class="section-eyebrow"><?= e(setting('signature_eyebrow')) ?></span>
    <h2 class="mb-0 fw-bold section-font"><?= e(setting('signature_title')) ?></h2>
  </div>

  <div class="container">
    <?php foreach (rows("SELECT * FROM comforts WHERE is_active = 1 AND section = 'signature' ORDER BY sort_order, id") as $i => $c): ?>
    <div class="feature-row<?= $i % 2 === 1 ? ' reverse' : '' ?> reveal">
      <div class="col-lg-6">
        <img src="<?= e(asset($c['image'])) ?>" alt="<?= e($c['title']) ?>">
      </div>
      <div class="col-lg-6 feature-text">
        <?php if ($c['tag'] !== ''): ?><span class="lodge-tier"><?= e($c['tag']) ?></span><?php endif; ?>
        <h3><?= e($c['title']) ?></h3>
        <p><?= e($c['description']) ?></p>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- CTA -->
<div class="comfort-cta">
  <div class="comfort-cta-bg"></div>
  <div class="container comfort-cta-content">
    <h2><?= e(setting('cta_title')) ?></h2>
    <p class="mb-4"><?= e(setting('cta_text')) ?></p>
    <a href="lodges.php" class="btn btn-wine rounded-pill px-4 py-2"><?= e(setting('cta_button')) ?></a>
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
</script>

</body>
</html>