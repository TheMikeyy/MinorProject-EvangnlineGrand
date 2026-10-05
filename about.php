<?php require_once __DIR__ . '/admin/admin-include/db_config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | <?= e(setting('hotel_name')) ?></title>
    <?php require('include/links.php') ?>
</head>
<body class="bg-light">

<style>
  :root{
    --ink: #1F2A52;
    --ink-black: #13141C;
  }

  /* ---------- Page hero ---------- */
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
    background-image: url('<?= e(img('about_banner')) ?>');
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

  /* ---------- STANDARDIZED HERO LOGO (unified with index page sizing) ---------- */
   .page-hero-logo{
    display: block;
    width: 46%;
    max-width: 460px;
    min-width: 260px;
    height: auto;
    margin: 1rem auto 0;
    filter: drop-shadow(0 3px 14px rgba(0,0,0,.4));
  }
  .page-hero-eyebrow{
    display: block;
    font-family: "Great Vibes", cursive;
    font-size: 2.2rem;
    color: var(--ink);
    margin-bottom: -.1rem;
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
  .about-intro{
    padding-top: 5rem;
    padding-bottom: 1rem;
  }

  .about-intro p{
    max-width: 760px;
    margin: 1.25rem auto 0;
    color: var(--ink-black);
    font-size: 1.05rem;
    line-height: 1.8;
  }

  /* ---------- Story feature rows (reused pattern) ---------- */
  .story-section{
    padding-top: 2rem;
    padding-bottom: 5rem;
  }

  .feature-row{
    display: flex;
    align-items: flex-start;
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
    height: 360px;
    object-fit: cover;
  }

  .feature-text .lodge-tier{
    display: inline-block;
    font-size: .7rem;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--ink);
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

  /* ---------- Stats strip ---------- */
  .stats-section{
    padding: 4rem 0;
  }

  .stat-item{
    text-align: center;
    padding: 1rem;
  }

  .stat-number{
    font-family: 'DM Serif Display', serif;
    color: var(--ink);
    font-size: 2.6rem;
    line-height: 1;
    margin-bottom: .4rem;
  }

  .stat-label{
    font-size: .85rem;
    letter-spacing: .5px;
    text-transform: uppercase;
    color: var(--ink-black);
  }

  /* ---------- Values ---------- */
  .values-section{
    padding-top: 5rem;
    padding-bottom: 4rem;
  }

  .value-card{
    border-radius: 16px;
    box-shadow: 0 10px 26px rgba(31,42,82,.08);
    background-color: var(--paper);
    padding: 2.4rem 1.6rem;
    text-align: center;
    height: 100%;
  }

  .value-icon{
    width: 58px;
    height: 58px;
    margin: 0 auto 1.2rem;
    border-radius: 50%;
    border: 1.5px solid rgba(122,35,51,.3);
    background-color: var(--cream);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--ink);
    font-size: 22px;
  }

  .value-card h5{
    font-family: 'DM Serif Display', serif;
    color: var(--ink);
    margin-bottom: .7rem;
  }

  .value-card p{
    color: var(--ink-black);
    font-size: .92rem;
    line-height: 1.65;
    margin-bottom: 0;
  }

  /* ---------- Team ---------- */
  .team-section{
    padding-top: 5rem;
    padding-bottom: 5rem;
  }

  .team-card{
    position: relative;
    border-radius: 18px;
    overflow: hidden;
    height: 420px;
    box-shadow: 0 14px 30px rgba(31,42,82,.14);
  }

  .team-card:nth-child(even){
    margin-top: 3rem;
  }

  @media (max-width: 991.98px){
    .team-card:nth-child(even){
      margin-top: 0;
    }
  }

  .team-card img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .5s ease;
  }

  .team-card:hover img{
    transform: scale(1.06);
  }

  .team-card::after{
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(19,20,28,0) 40%, rgba(19,20,28,.88) 100%);
  }

  .team-card-info{
    position: absolute;
    left: 0; right: 0; bottom: 0;
    z-index: 2;
    padding: 1.4rem 1.4rem 1.2rem;
    color: var(--paper);
  }

  .team-card-role{
    display: block;
    font-size: .74rem;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: var(--rose);
    margin-bottom: .25rem;
  }

  .team-card-info h6{
    font-family: 'DM Serif Display', serif;
    font-size: 1.3rem;
    margin-bottom: .5rem;
  }

  .team-card-note{
    font-size: .85rem;
    line-height: 1.55;
    color: rgba(255,255,255,.85);
    max-height: 0;
    opacity: 0;
    overflow: hidden;
    transition: max-height .4s ease, opacity .3s ease;
  }

  .team-card:hover .team-card-note{
    max-height: 90px;
    opacity: 1;
  }

  .team-card-tier{
    position: absolute;
    top: 1.2rem;
    left: 1.2rem;
    z-index: 2;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background-color: rgba(255,255,255,.9);
    color: var(--ink);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    box-shadow: 0 4px 12px rgba(19,20,28,.2);
  }
</style>

<?php require('include/navbar.php') ?>

<!-- PAGE HERO -->
<div class="page-hero">
  <div class="page-hero-bg"></div>
  <div class="page-hero-content">
    <h1 class="page-hero-title">About Us</h1>
    <img src="<?= e(img('logo_hero')) ?>" alt="<?= e(setting('hotel_name')) ?>" class="page-hero-logo">
  </div>
</div>

<!-- INTRO -->
<div class="container about-intro text-center">
  <h2 class="mb-0 fw-bold section-font"><?= e(setting('about_title')) ?></h2>
  <div class="h-line bg-dark mx-auto mt-3"></div>
  <p>
    <?= e(setting('about_text')) ?>
  </p>
</div>

<!-- STORY -->
<div class="container story-section">
  <div class="feature-row reveal">
    <div class="col-lg-6">
      <img src="<?= e(img('story1_image')) ?>" alt="How it began">
    </div>
    <div class="col-lg-6 feature-text">
      <span class="lodge-tier"><?= e(setting('story1_tag')) ?></span>
      <h3><?= e(setting('story1_title')) ?></h3>
      <p>
        <?= e(setting('story1_text')) ?>
      </p>
    </div>
  </div>

  <div class="feature-row reverse reveal">
    <div class="col-lg-6">
      <img src="<?= e(img('story2_image')) ?>" alt="What we do today">
    </div>
    <div class="col-lg-6 feature-text">
      <span class="lodge-tier"><?= e(setting('story2_tag')) ?></span>
      <h3><?= e(setting('story2_title')) ?></h3>
      <p>
        <?= e(setting('story2_text')) ?>
      </p>
    </div>
  </div>
</div>

<!-- STATS -->
<div class="section-white stats-section">
  <div class="container">
    <div class="row g-4">
      <div class="col-6 col-lg-3 reveal">
        <div class="stat-item">
          <div class="stat-number"><?= e(setting('stat1_number')) ?></div>
          <div class="stat-label"><?= e(setting('stat1_label')) ?></div>
        </div>
      </div>
      <div class="col-6 col-lg-3 reveal">
        <div class="stat-item">
          <div class="stat-number"><?= e(setting('stat2_number')) ?></div>
          <div class="stat-label"><?= e(setting('stat2_label')) ?></div>
        </div>
      </div>
      <div class="col-6 col-lg-3 reveal">
        <div class="stat-item">
          <div class="stat-number"><?= e(setting('stat3_number')) ?></div>
          <div class="stat-label"><?= e(setting('stat3_label')) ?></div>
        </div>
      </div>
      <div class="col-6 col-lg-3 reveal">
        <div class="stat-item">
          <div class="stat-number"><?= e(setting('stat4_number')) ?></div>
          <div class="stat-label"><?= e(setting('stat4_label')) ?></div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- VALUES -->
<div class="values-section">
  <div class="container">
    <div class="text-center section-head reveal">
      <span class="section-eyebrow"><?= e(setting('values_eyebrow')) ?></span>
      <h2 class="mb-0 fw-bold section-font"><?= e(setting('values_title')) ?></h2>
    </div>

    <div class="row g-4">
      <div class="col-lg-4 col-md-6 reveal">
        <div class="value-card">
          <div class="value-icon"><i class="<?= e(setting('value1_icon')) ?>"></i></div>
          <h5><?= e(setting('value1_title')) ?></h5>
          <p><?= e(setting('value1_text')) ?></p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 reveal">
        <div class="value-card">
          <div class="value-icon"><i class="<?= e(setting('value2_icon')) ?>"></i></div>
          <h5><?= e(setting('value2_title')) ?></h5>
          <p><?= e(setting('value2_text')) ?></p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 reveal">
        <div class="value-card">
          <div class="value-icon"><i class="<?= e(setting('value3_icon')) ?>"></i></div>
          <h5><?= e(setting('value3_title')) ?></h5>
          <p><?= e(setting('value3_text')) ?></p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- TEAM -->
<div class="section-white team-section">
  <div class="container">
    <div class="text-center section-head reveal">
      <span class="section-eyebrow"><?= e(setting('team_eyebrow')) ?></span>
      <h2 class="mb-0 fw-bold section-font"><?= e(setting('team_title')) ?></h2>
    </div>

    <div class="row g-4">

      <?php foreach (rows('SELECT * FROM team_members ORDER BY sort_order, id') as $tm): ?>
      <div class="col-lg-3 col-md-6 reveal">
        <div class="team-card">
          <div class="team-card-tier"><i class="<?= e($tm['icon']) ?>"></i></div>
          <img src="<?= e(asset($tm['image'])) ?>" alt="<?= e($tm['name']) ?>">
          <div class="team-card-info">
            <span class="team-card-role"><?= e($tm['role']) ?></span>
            <h6><?= e($tm['name']) ?></h6>
            <p class="team-card-note"><?= e($tm['note']) ?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>

    </div>
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