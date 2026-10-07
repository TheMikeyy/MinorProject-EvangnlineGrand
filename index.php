<?php require_once __DIR__ . '/admin/admin-include/db_config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | <?= e(setting('hotel_name')) ?></title>
    <?php require('include/links.php') ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css"/>
  </head>
<body class="bg-light">

<style>
  .hero-wrap{
  position: relative;
  margin-top: 0;
}

.hero-swiper .swiper-slide img{
  height: 620px;
  object-fit: cover;
  filter: saturate(1.02);
}

.hero-wrap::after{
  content: "";
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, rgba(19,20,28,.62) 0%, rgba(19,20,28,0) 20%, rgba(19,20,28,0) 52%, rgba(19,20,28,.88) 100%);
  pointer-events: none;
  z-index: 1;
}

.hero-overlay{
  position: absolute;
  left: 0; right: 0; bottom: 70px;
  z-index: 2;
  text-align: center;
  color: var(--paper);
  padding: 0 1rem;
}

.hero-script{
  display: block;
  font-family: "Great Vibes", cursive;
  font-size: 3.1rem;
  font-weight: 400;
  line-height: 1;
  color: var(--rose);
  margin-bottom: -.10rem;
}

.hero-logo-img{
  display: block;
  width: 46%;
  max-width: 460px;
  min-width: 260px;
  height: auto;
  margin: 0 auto .6rem;
  filter: drop-shadow(10 3px 140px rgba(0,0,0,.4));
}

.hero-tagline{
  font-family: "Cormorant Garamond", serif;
  font-size: 1.5rem;
  font-optical-sizing: auto;
  font-weight: 700;
  line-height: 1.6;
  color: var(--rose);
  max-width: 1000px;
  margin: 0 auto;
}

@media screen and (max-width: 575px){
    .hero-swiper .swiper-slide img{
        height: 340px;
    }
    .hero-title{ font-size: 2.5rem; }
    .hero-script{ font-size: 2rem; }
    .hero-overlay{ bottom: 40px; }
    .hero-logo-img{
      width: 60%;
      min-width: 0;
      max-width: 400px;
      margin-bottom: .4rem;
    }
    .hero-tagline{
      font-size: 1.1rem;
      line-height: 1.5;
      padding: 0 .75rem;
    }
}

/* ---------- Availability form ---------- */
.availability-form{
    margin-top: -60px;
    z-index: 3;
    position: relative;
}

@media screen and (max-width: 575px){
    .availability-form{
        margin-top: -30px;
    }
}

.availability-card{
  position: relative;
  z-index: 10;
  border-top: 3px solid var(--wine);
  border-radius: 40px;
  background: rgba(255,255,255,.90);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(255,255,255, 0.4);
  box-shadow: 0 12px 30px rgba(31,42,82,.14);
}

.availability-card .section-eyebrow{
  text-align: center;
}

.availability-row .form-control,
.availability-row .form-select,
.availability-row .btn{
  border-radius: 12px;
}

.availability-row {
    --gap: 0.75rem;
  }
.availability-row > div {
  padding-left: var(--gap);
  padding-right: var(--gap);
}

@media (max-width: 991.98px) {
  .availability-row > div {
    flex: 0 0 100%;
    max-width: 100%;
  }
}

@media (min-width: 992px) {
  .field-checkin   { flex: 0 0 20%; max-width: 20%; }
  .field-checkout  { flex: 0 0 20%; max-width: 20%; }
  .field-children  { flex: 0 0 24%; max-width: 24%; }
  .field-adult     { flex: 0 0 24%; max-width: 24%; }
  .field-submit    { flex: 0 0 12%; max-width: 12%; }
}

/* ---------- Section rhythm ---------- */
.section-pad{
  padding-top: 5rem;
}

.section-white{
  background-color: var(--paper);
}

/* ---------- Lodge cards ---------- */
.card{
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 10px 26px rgba(31,42,82,.08);
  background-color: var(--paper);
}

.lodge-hover{
  transition: transform .3s ease, box-shadow .3s ease;
  border-top: 3px solid transparent !important;
}

.lodge-hover:hover{
  transform: translateY(-8px);
  box-shadow: 0 20px 36px rgba(31,42,82,.16) !important;
  border-top: 3px solid var(--wine) !important;
}

.lodge-tier{
  display: inline-block;
  font-size: .7rem;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--wine);
  font-weight: 600;
  margin-bottom: .35rem;
}

.card-body h5{
  font-family: 'DM Serif Display', serif;
  color: var(--ink);
}

.card-body h6:not(.mb-1){
  color: var(--muted);
  font-weight: 500;
}

.rating i.bi-star-fill,
.rating i.bi-star-half{
  color: var(--wine) !important;
}

.pill{
  display: inline-block;
  font-size: .74rem;
  padding: .35rem .7rem;
  margin: .2rem;
  border-radius: 30px;
  border: 1px solid rgba(122,35,51,.22);
  background-color: var(--cream);
  color: var(--ink);
}

/* ---------- Convenience ---------- */
.convenience-row{
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 24px;
  padding: 0 1rem;
}

.convenience-card{
  flex: 0 0 calc(25% - 18px);
  max-width: calc(25% - 18px);
  background: var(--cream);
  border-radius: 12px;
  box-shadow: 0 6px 18px rgba(31,42,82,.06);
  padding: 2.2rem 1rem;
  text-align: center;
  transition: box-shadow .25s ease, transform .25s ease, background-color .25s ease;
}

.convenience-card:hover{
  box-shadow: 0 14px 28px rgba(31,42,82,.14);
  transform: translateY(-4px);
  background-color: var(--paper);
}

.convenience-icon{
  width: 62px;
  height: 62px;
  margin: 0 auto 14px;
  border-radius: 50%;
  border: 1.5px solid rgba(122,35,51,.3);
  display: flex;
  align-items: center;
  justify-content: center;
}

.convenience-card i{
  font-size: 22px;
  color: var(--ink);
  display: inline-block;
}

.convenience-card h5{
  font-size: 14px;
  font-weight: 500;
  color: var(--charcoal);
  margin-bottom: 0;
  letter-spacing: .2px;
}

@media (max-width: 991px){
  .convenience-card{
      flex: 0 0 calc(33.333% - 16px);
      max-width: calc(33.333% - 16px);
  }
}
@media (max-width: 767px){
  .convenience-card{
      flex: 0 0 calc(50% - 12px);
      max-width: calc(50% - 12px);
  }
}
@media (max-width: 480px){
  .convenience-card{
      flex: 0 0 100%;
      max-width: 100%;
  }
}

/* ---------- Testimonials ---------- */
.swiper-testimonials{
  padding: 1.5rem .5rem 3rem;
}

.testimonial-card{
  border-radius: 14px;
}

.testimonial-card p{
  font-style: italic;
  color: var(--charcoal);
}

.swiper-pagination-bullet-active{
  background-color: var(--wine) !important;
}

/* ---------- Locate us ---------- */
.locate-section{
  position: relative;
  overflow: hidden;
  padding: 5.5rem 0 5rem;
  margin-top: 4rem;
}

.locate-bg{
  position: absolute;
  inset: 0;
  background-image: url('<?= e(img('locate_bg')) ?>');
  background-size: cover;
  background-position: center;
  background-attachment: fixed;
  filter: brightness(.5) saturate(1.05);
  transform: scale(1.03);
}

.locate-overlay{
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, rgba(19,20,28,.75) 0%, rgba(19,20,28,.55) 45%, rgba(19,20,28,.85) 100%);
}

.locate-content{
  position: relative;
  z-index: 2;
}

.locate-card{
  border-radius: 14px;
  box-shadow: 0 14px 34px rgba(0,0,0,.28);
  background-color: rgba(255,255,255,.94);
  backdrop-filter: blur(6px);
  -webkit-backdrop-filter: blur(6px);
  border-top: 3px solid var(--wine);
}

.locate-card-map iframe{
  border-radius: 15px;
  display: block;
}

.locate-card h5{
  color: var(--ink);
  font-weight: 600;
  margin-bottom: 1rem;
}

.locate-card .hours-row{
  display: flex;
  justify-content: space-between;
  font-size: .88rem;
  padding: .3rem 0;
  border-bottom: 1px dashed rgba(31,42,82,.12);
}

.locate-card .hours-row:last-child{
  border-bottom: none;
}

.contact-row{
  display: flex;
  align-items: center;
  gap: .6rem;
}

.contact-icon{
  width: 34px;
  height: 34px;
  min-width: 34px;
  border-radius: 50%;
  background: var(--cream);
  border: 1px solid rgba(122,35,51,.25);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--wine);
}

.social-pill{
  border: 1px solid rgba(122,35,51,.3);
  color: var(--ink) !important;
  transition: background-color .2s ease, color .2s ease;
}

.social-pill:hover{
  background-color: var(--wine);
  color: var(--paper) !important;
  border-color: var(--wine);
}
</style>

<?php require('include/navbar.php')?>

<!-- HERO -->
<div class="hero-wrap">
  <div class="swiper swiper-container hero-swiper">
      <?php
        $slides = rows('SELECT image, caption FROM hero_slides WHERE is_active = 1 ORDER BY sort_order, id');
        if (!$slides) { $slides = [['image' => 'images/crousel/1.jpeg', 'caption' => '']]; }   // never show an empty banner
      ?>
      <div class="swiper-wrapper">
        <?php foreach ($slides as $s): ?>
        <div class="swiper-slide">
          <img src="<?= e(asset($s['image'])) ?>" alt="<?= e($s['caption']) ?>" class="w-100 d-block"/>
        </div>
        <?php endforeach; ?>
      </div>
  </div>
  <div class="hero-overlay">
    <span class="hero-script"><?= e(setting('hero_welcome')) ?></span>
    <img src="<?= e(img('logo_hero')) ?>" alt="<?= e(setting('hotel_name')) ?>" class="hero-logo-img">
    <p class="hero-tagline"><?= e(setting('hero_tagline')) ?></p>
  </div>
</div>

<div class="container availability-form">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="shadow p-4 availability-card">
        <span class="section-eyebrow d-block mb-1 text-center">Reserve your stay</span>
        <form action="lodges.php" method="get">
          <div class="row align-items-end availability-row">

            <div class="field-checkin mb-3">
              <label class="form-label">Check-In</label>
              <input type="date" name="checkin" class="form-control shadow-none" required min="<?= date('Y-m-d') ?>">
            </div>

            <div class="field-checkout mb-3">
              <label class="form-label">Check-Out</label>
              <input type="date" name="checkout" class="form-control shadow-none" required min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
            </div>

            <div class="field-children mb-3">
              <label class="form-label">Children</label>
              <select name="children" class="form-select shadow-none">
                <option value="0" selected>None</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
                <option value="4">Four</option>
              </select>
            </div>

            <div class="field-adult mb-3">
              <label class="form-label">Adult</label>
              <select name="adults" class="form-select shadow-none">
                <option value="1">One</option>
                <option value="2" selected>Two</option>
                <option value="3">Three</option>
                <option value="4">Four</option>
              </select>
            </div>

            <div class="field-submit mb-3">
              <button type="submit" class="btn text-white shadow-none custom-bg w-100">Search</button>
            </div>

          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- LODGES -->
<div id="lodges" class="section-pad text-center section-head reveal">
  
  <h2 class="mb-0 fw-bold section-font"><?= e(setting('home_lodges_title')) ?></h2>
</div>

<div class="container">
 <div class="row">
   <?php $home_lodges = rows('SELECT * FROM lodges WHERE is_active = 1 AND show_on_home = 1 ORDER BY sort_order, id LIMIT 6'); ?>
<?php foreach ($home_lodges as $l): ?>
   <div class="col-lg-4 col-md-6 my-3">
    <div class="card border-0 shadow lodge-hover" style="max-width: 350px; margin: auto;">
      <img src="<?= e(asset($l['image'])) ?>" class="card-img-top" alt="<?= e($l['name']) ?>">
      <div class="card-body text-center">
        <h5><?= e($l['name']) ?></h5>
        <h6 class="mb-4"><?= e(price_line($l['price_min'], $l['price_max'])) ?></h6>
        <?php if ($l['rating'] !== null): ?>
         <div class="rating mb-4">
          <h6 class="mb-1">Rating:</h6>
         <span class="badge rounded-pill bg-light text-dark text-wrap">
          <?= stars_html($l['rating']) ?>
         </span>
        </div>
        <?php endif; ?>
        <?php if (lines($l['features'])): ?>
        <div class="features mb-4">
          <h6 class="mb-1">Features:</h6>
          <?php foreach (lines($l['features']) as $p): ?><span class="pill"><?= e($p) ?></span>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <?php if (lines($l['facilities'])): ?>
        <div class="facilities mb-4">
           <h6 class="mb-1">Facilities:</h6>
          <?php foreach (lines($l['facilities']) as $p): ?><span class="pill"><?= e($p) ?></span>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <div class="guests-limit mb-4">
           <h6 class="mb-1">Guests Limit:</h6>
          <span class="pill"><?= e(adults_text($l['max_adults'])) ?></span>
          <?php if ((int)$l['max_children'] > 0): ?><span class="pill"><?= e(children_text($l['max_children'])) ?></span><?php endif; ?>
        </div>
        <div class="d-flex justify-content-center gap-3 mb-2">
          <a href="book.php?lodge=<?= (int)$l['id'] ?>" class="btn btn-sm text-white custom-bg shadow-none rounded-pill px-3">Book Now</a>
          <a href="lodges.php" class="btn btn-sm btn-outline-dark shadow-none rounded-pill px-3">More Details</a>
        </div>
      </div>
    </div>
   </div>
<?php endforeach; ?>
      <div class="col-lg-12 text-center mt-5">
    <a href="lodges.php" class="btn btn-md btn-outline-dark rounded-0 fw-bold shadow-none rounded-pill px-3">Explore More Lodges ></a>
   </div>
 </div>
</div>

<!-- CONVENIENCE -->
<div class="section-white mt-5">
  <div id="comforts" class="section-pad text-center section-head reveal">
    <span class="section-eyebrow"><?= e(setting('home_conv_eyebrow')) ?></span>
    <h2 class="mb-0 fw-bold section-font"><?= e(setting('home_conv_title')) ?></h2>
  </div>

  <div class="container pb-5">
    <div class="convenience-row">
      <?php foreach (rows("SELECT title, icon FROM comforts WHERE is_active = 1 AND show_on_home = 1 ORDER BY sort_order, id") as $c): ?>
      <div class="convenience-card">
        <div class="convenience-icon"><i class="<?= e($c['icon']) ?>"></i></div>
        <h5><?= e($c['title']) ?></h5>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<!-- TESTIMONIALS -->
<div class="section-pad text-center section-head reveal">
  <h2 class="mb-0 fw-bold section-font"><?= e(setting('home_reviews_title')) ?></h2>
</div>

<div class="container">
  <div class="d-flex justify-content-center mb-3">
    <div class="swiper-pagination position-static"></div>
  </div>

  <div class="swiper swiper-testimonials position-relative">
    <div class="swiper-wrapper">

  <?php $reviews = rows('SELECT name, review, rating FROM testimonials WHERE is_active = 1 ORDER BY sort_order, id'); ?>
<?php foreach ($reviews as $rv): ?>
  <div class="swiper-slide testimonial-card bg-white p-4 text-center">
    <div class="d-flex align-items-center justify-content-center mb-3">
      <img src="https://ui-avatars.com/api/?name=<?= urlencode($rv['name']) ?>&background=7A2333&color=fff&bold=true&size=128" width="40" class="rounded-circle" alt="">
      <h6 class="mb-0 ms-2"><?= e($rv['name']) ?></h6>
    </div>
    <p class="mb-3"><?= e($rv['review']) ?></p>
    <div class="rating">
      <?= str_repeat('<i class="bi bi-star-fill"></i>', max(0, min(5, (int)$rv['rating']))) ?>
    </div>
  </div>
<?php endforeach; ?>

</div>
  </div>
</div>
<div class="col-lg-12 text-center mt-3">
  <a href="about.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none rounded-pill px-3">Know About More ></a>
</div>

<!-- LOCATE US  -->
<div id="locate" class="locate-section">
  <div class="locate-bg"></div>
  <div class="locate-overlay"></div>

  <div class="container locate-content">
    <div class="text-center section-head reveal">
      <h2 class="mb-0 fw-bold section-font on-dark"><?= e(setting('home_locate_title')) ?></h2>
    </div>

    <div class="row g-4">
      <div class="col-lg-7">
        <div class="p-3 locate-card locate-card-map reveal">
          <iframe class="w-100" height="472" style="border:0;"
            src="<?= e(setting('map_embed_url')) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
      </div>

      <div class="col-lg-5 d-flex flex-column gap-3">
        <div class="p-4 locate-card reveal">
          <h5>Visit Us</h5>
          <div class="contact-row mb-3">
            <span class="contact-icon"><i class="bi bi-geo-alt-fill"></i></span>
            <span><?= e(setting('address')) ?></span>
          </div>
          <?php for ($h = 1; $h <= 3; $h++): if (trim(setting("hours{$h}_label")) === '') { continue; } ?>
          <div class="hours-row"><span><?= e(setting("hours{$h}_label")) ?></span><span><?= e(setting("hours{$h}_value")) ?></span></div>
          <?php endfor; ?>
          </div>

        <div class="p-4 locate-card reveal">
          <h5>Contact Us</h5>
          <div class="contact-row mb-2">
            <span class="contact-icon"><i class="bi bi-telephone-outbound-fill"></i></span>
            <a href="<?= e(tel_href(setting('phone'))) ?>" class="text-decoration-none text-dark"><?= e(setting('phone')) ?></a>
          </div>
          <div class="contact-row">
            <span class="contact-icon"><i class="bi bi-envelope-fill"></i></span>
            <a href="mailto:<?= e(setting('email')) ?>" class="text-decoration-none text-dark"><?= e(setting('email')) ?></a>
          </div>
        </div>

        <div class="p-4 locate-card reveal">
          <h5>Follow Us</h5>
          <div class="d-flex flex-wrap gap-2">
            <a <?= social_attrs('social_instagram') ?> class="badge rounded-pill social-pill fs-6 p-2 text-decoration-none">
              <i class="bi bi-instagram"></i> Instagram
            </a>
            <a <?= social_attrs('social_facebook') ?> class="badge rounded-pill social-pill fs-6 p-2 text-decoration-none">
              <i class="bi bi-facebook me-1"></i> Facebook
            </a>
            <a <?= social_attrs('social_youtube') ?> class="badge rounded-pill social-pill fs-6 p-2 text-decoration-none">
              <i class="bi bi-youtube"></i> Youtube
            </a>
            <a <?= social_attrs('social_x') ?> class="badge rounded-pill social-pill fs-6 p-2 text-decoration-none">
              <i class="bi bi-twitter-x"></i> X
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- FOOTER -->
<?php require('include/footer.php') ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>

<script>
var swiper = new Swiper('.swiper-container', {
  effect: 'fade',
  fadeEffect: {
    crossFade: true
  },
  slidesPerView: 1,
  loop: <?= count($slides) > 1 ? 'true' : 'false' ?>,
  autoplay: <?= count($slides) > 1 ? '{ delay: 2500, disableOnInteraction: false }' : 'false' ?>,
});

var swiperTestimonials = new Swiper('.swiper-testimonials', {
  effect: 'coverflow',
  grabCursor: true,
  centeredSlides: true,
  slidesPerView: 'auto',
  loop: <?= count($reviews) >= 6 ? 'true' : 'false' ?>,
  initialSlide: 0,
  coverflowEffect: {
    rotate: 30,
    stretch: -40,
    depth: 100,
    modifier: 1,
    slideShadows: false,
  },
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  breakpoints: {
    320: { slidesPerView: 1 },
    640: { slidesPerView: 1 },
    768: { slidesPerView: 2 },
    1024: { slidesPerView: 3 },
  }
});

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