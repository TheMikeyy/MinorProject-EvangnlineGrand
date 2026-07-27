<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comforts | Évangéline Grand</title>
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
    background-image: url('images/comforts/entry.jpeg');
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

  .page-hero-logo{
    display: block;
    width: 46%;
    max-width: 700px;
    min-width: 450px;
    height: auto;
    margin: 0 auto 1rem;
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
      width: 70%;
      min-width: 0;
      max-width: 240px;
      margin-bottom: .6rem;
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
    background-image: url('images/comforts/entrycloseup.jpeg');
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
    <img src="images/logo/logo-hero-body.png" alt="Évangéline Grand" class="page-hero-logo">
    <h1 class="page-hero-title">Your Comfort Zone Might Be Here</h1>
  </div>
</div>

<!-- INTRO -->
<div class="container comfort-intro text-center">
  <h2 class="mb-0 fw-bold section-font">OUR COMFORTS</h2>
  <div class="h-line bg-dark mx-auto mt-3"></div>
  <p>
    Every stay here is built around the little things that make it feel effortless and thoughtful
    comforts, quiet luxuries, and details attended to before you even ask. This is where rest comes
    easy and every need is already taken care of.
  </p>
</div>

<!-- COMFORT CARDS -->
<div class="container comfort-grid">
  <div class="row g-4">

    <div class="col-lg-4 col-md-6 reveal">
      <div class="comfort-card shadow lodge-hover">
        <img src="images/comforts/breakfast.jpeg" alt="Complimentary breakfast">
        <div class="comfort-icon-badge"><i class="fa-solid fa-mug-saucer"></i></div>
        <div class="text-center card-body-pad">
          <h5>Complimentary Breakfast</h5>
          <p>A curated morning spread served daily, from fresh local produce to warm pastries, included with every stay.</p>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 reveal">
      <div class="comfort-card shadow lodge-hover">
        <img src="images/comforts/charge.jpeg" alt="EV Charging Station">
        <div class="comfort-icon-badge"><i class="fa-solid fa-charging-station"></i></div>
        <div class="text-center card-body-pad">
          <h5>EV Charging Station</h5>
          <p>On-site charging points for electric vehicles, so your stay stays effortless whichever way you arrived.</p>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 reveal">
      <div class="comfort-card shadow lodge-hover">
        <img src="images/comforts/security.jpeg" alt="24/7 security & CCTV">
        <div class="comfort-icon-badge"><i class="fa-solid fa-video"></i></div>
        <div class="text-center card-body-pad">
          <h5>24/7 Security &amp; CCTV</h5>
          <p>Round-the-clock monitoring and on-property security, so you can rest easy at every hour.</p>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 reveal">
      <div class="comfort-card shadow lodge-hover">
        <img src="images/comforts/hall.jpeg" alt="Conference/banquet halls">
        <div class="comfort-icon-badge"><i class="fa-solid fa-people-group"></i></div>
        <div class="text-center card-body-pad">
          <h5>Conference &amp; Banquet Halls</h5>
          <p>Elegant event spaces suited for intimate gatherings or larger celebrations, fully serviced on request.</p>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 reveal">
      <div class="comfort-card shadow lodge-hover">
        <img src="images/comforts/laundry.jpeg" alt="Laundry service">
        <div class="comfort-icon-badge"><i class="fa-solid fa-shirt"></i></div>
        <div class="text-center card-body-pad">
          <h5>Laundry Service</h5>
          <p>Same-day laundry and pressing, handled with care so you always travel light.</p>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 reveal">
      <div class="comfort-card shadow lodge-hover">
        <img src="images/comforts/rooftop.jpeg" alt="Rooftop Bar">
        <div class="comfort-icon-badge"><i class="fa-solid fa-martini-glass-citrus"></i></div>
        <div class="text-center card-body-pad">
          <h5>Rooftop Bar</h5>
          <p>Handcrafted cocktails and valley views, open every evening for a slower kind of night.</p>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 reveal">
      <div class="comfort-card shadow lodge-hover">
        <img src="images/comforts/desk.jpeg" alt="Concierge desk">
        <div class="comfort-icon-badge"><i class="fa-solid fa-bell-concierge"></i></div>
        <div class="text-center card-body-pad">
          <h5>Concierge Desk</h5>
          <p>From dinner reservations to local excursions, our concierge is on hand daily to plan the details.</p>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 reveal">
      <div class="comfort-card shadow lodge-hover">
        <img src="images/comforts/parking.jpeg" alt="Valet parking">
        <div class="comfort-icon-badge"><i class="fa-solid fa-car"></i></div>
        <div class="text-center card-body-pad">
          <h5>Valet Parking</h5>
          <p>Complimentary valet on arrival, so your stay begins the moment you step out of the car.</p>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 reveal">
      <div class="comfort-card shadow lodge-hover">
        <img src="images/comforts/pet.jpeg" alt="Pet-friendly rooms">
        <div class="comfort-icon-badge"><i class="fa-solid fa-paw"></i></div>
        <div class="text-center card-body-pad">
          <h5>Pet-Friendly Stays</h5>
          <p>Select rooms welcome your companions, with bedding and bowls ready before you arrive.</p>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- SIGNATURE COMFORTS -->
<div class="section-white signature-section">
  <div class="text-center section-head reveal">
    <span class="section-eyebrow">A Little Further, A Little Deeper</span>
    <h2 class="mb-0 fw-bold section-font">OUE SIGNATURE COMFORTS</h2>
  </div>

  <div class="container">
    <div class="feature-row reveal">
      <div class="col-lg-6">
        <img src="images/comforts/swimpool.jpeg" alt="Swimming pool & spa">
      </div>
      <div class="col-lg-6 feature-text">
        <span class="lodge-tier">Wellness</span>
        <h3>Swimming Pool &amp; Spa</h3>
        <p>
          An open-air pool framed by the valley, paired with a spa menu built around slow, restorative
          treatments. Whether it's a sunrise swim or an evening massage, this is where the pace of the
          day finally softens.
        </p>
      </div>
    </div>

    <div class="feature-row reverse reveal">
      <div class="col-lg-6">
        <img src="images/comforts/butlerservice.jpeg" alt="Special butler service">
      </div>
      <div class="col-lg-6 feature-text">
        <span class="lodge-tier">Personal Service</span>
        <h3>Dedicated Butler Service</h3>
        <p>
          Available to our Grand Reserve guests, our butlers handle everything from unpacking to late-night
          requests, quietly and without ceremony, so your stay feels attended to rather than managed.
        </p>
      </div>
    </div>
  </div>
</div>

<!-- CTA -->
<div class="comfort-cta">
  <div class="comfort-cta-bg"></div>
  <div class="container comfort-cta-content">
    <h2>Ready to experience it yourself ?</h2>
    <p class="mb-4">Reserve your stay and let every detail take care of itself.</p>
    <a href="index.php#lodges" class="btn btn-wine rounded-pill px-4 py-2">Book Your Stay</a>
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