<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Évangéline Grand</title>
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
    background-image: url('images/about/aboutbanner.jpeg');
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
    max-width: 700px;
    min-width: 450px;
    height: auto;
    margin: 0 auto 1rem;
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
    .page-hero-logo{ width: 55%; }
    .page-hero-title{ font-size: 1.7rem; }
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
    display: flex !important;
    align-items: flex-start !important;
    gap: 3rem;
    margin-bottom: 4.5rem;
  }

  .feature-row:last-child{ margin-bottom: 0; }

  .feature-row.reverse{
    flex-direction: row-reverse;
  }

  .feature-row > .col-lg-6{
    align-self: flex-start !important;
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
    <img src="images/logo/logo-hero-body.png" alt="Évangéline Grand" class="page-hero-logo">
    <h1 class="page-hero-title">Our Story | About Us</h1>
  </div>
</div>

<!-- INTRO -->
<div class="container about-intro text-center">
  <h2 class="mb-0 fw-bold section-font">ABOUT ÉVANGÉLINE GRAND</h2>
  <div class="h-line bg-dark mx-auto mt-3"></div>
  <p>
    Tucked into the quiet folds of the Annapolis Valley, Évangéline Grand was built on a simple idea,
    that hospitality should feel personal, not performed. Every room, every meal, and every small
    gesture here is shaped around that belief.
  </p>
</div>

<!-- STORY -->
<div class="container story-section">
  <div class="feature-row reveal">
    <div class="col-lg-6">
      <img src="images/about/story1.jpeg" alt="How it began">
    </div>
    <div class="col-lg-6 feature-text">
      <span class="lodge-tier">How It Began</span>
      <h3>A Home Before It Was A Hotel</h3>
      <p>
        Évangéline Grand started as a family estate, passed down through generations who loved this
        stretch of the valley enough to keep it standing. What began as a private retreat slowly opened
        its doors, first to friends, then to guests, until it became the property it is today. Still
        run with the same care as when it was simply home.
      </p>
    </div>
  </div>

  <div class="feature-row reverse reveal">
    <div class="col-lg-6">
      <img src="images/about/story2.jpeg" alt="What we do today">
    </div>
    <div class="col-lg-6 feature-text">
      <span class="lodge-tier">Where We Are Now</span>
      <h3>Hospitality, Done Quietly</h3>
      <p>
        Today, we welcome travelers from across the world into a handful of signature lodges, each
        designed to feel more like a considered retreat than a hotel room. We keep things intentionally
        small, so every stay can still be shaped around the person having it.
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
          <div class="stat-number">15+</div>
          <div class="stat-label">Years Hosting</div>
        </div>
      </div>
      <div class="col-6 col-lg-3 reveal">
        <div class="stat-item">
          <div class="stat-number">5+</div>
          <div class="stat-label">Signature Lodges</div>
        </div>
      </div>
      <div class="col-6 col-lg-3 reveal">
        <div class="stat-item">
          <div class="stat-number">4.8</div>
          <div class="stat-label">Average Rating</div>
        </div>
      </div>
      <div class="col-6 col-lg-3 reveal">
        <div class="stat-item">
          <div class="stat-number">13k+</div>
          <div class="stat-label">Guests Welcomed</div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- VALUES -->
<div class="values-section">
  <div class="container">
    <div class="text-center section-head reveal">
      <span class="section-eyebrow">What Inspires Us</span>
      <h2 class="mb-0 fw-bold section-font">OUR VALUES</h2>
    </div>

    <div class="row g-4">
      <div class="col-lg-4 col-md-6 reveal">
        <div class="value-card">
          <div class="value-icon"><i class="fa-solid fa-heart"></i></div>
          <h5>Genuine Hospitality</h5>
          <p>Warmth that isn't scripted & every member of our team is here because they care about the guests in front of them.</p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 reveal">
        <div class="value-card">
          <div class="value-icon"><i class="fa-solid fa-leaf"></i></div>
          <h5>Rooted In Place</h5>
          <p>We work closely with local growers, makers, and craftsmen, so a stay here also feels like a stay in the valley itself.</p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 reveal">
        <div class="value-card">
          <div class="value-icon"><i class="fa-solid fa-gem"></i></div>
          <h5>Considered Detail</h5>
          <p>From linens to lighting, nothing here is an afterthought. Every detail is chosen, not defaulted to.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- TEAM -->
<div class="section-white team-section">
  <div class="container">
    <div class="text-center section-head reveal">
      <span class="section-eyebrow">The People Behind The Grand</span>
      <h2 class="mb-0 fw-bold section-font">MEET OUR TEAM</h2>
    </div>

    <div class="row g-4">

      <div class="col-lg-3 col-md-6 reveal">
        <div class="team-card">
          <div class="team-card-tier"><i class="fa-solid fa-key"></i></div>
          <img src="images/about/person1.jpeg" alt="Elise Martin">
          <div class="team-card-info">
            <span class="team-card-role">General Manager</span>
            <h6>Meet Ranpura</h6>
            <p class="team-card-note">Oversees every stay from arrival to departure, making sure nothing here ever feels routine.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 reveal">
        <div class="team-card">
          <div class="team-card-tier"><i class="fa-solid fa-utensils"></i></div>
          <img src="images/about/person2.jpeg" alt="Daniel Roy">
          <div class="team-card-info">
            <span class="team-card-role">Head Chef</span>
            <h6>Jaydeep Chawla</h6>
            <p class="team-card-note">Builds every breakfast and evening menu around what's fresh in the valley that week.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 reveal">
        <div class="team-card">
          <div class="team-card-tier"><i class="fa-solid fa-concierge-bell"></i></div>
          <img src="images/about/person3.jpeg" alt="Naomi Blake">
          <div class="team-card-info">
            <span class="team-card-role">Head Desk Manager</span>
            <h6>Bhavesh Yadav</h6>
            <p class="team-card-note">The first call for reservations, local tips, and anything a guest needs arranged.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 reveal">
        <div class="team-card">
          <div class="team-card-tier"><i class="fa-solid fa-handshake"></i></div>
          <img src="images/about/person4.jpeg" alt="Marcus Hill">
          <div class="team-card-info">
            <span class="team-card-role">Guest Relations</span>
            <h6></h6>
            <p class="team-card-note">The familiar face at check-in, and the one who remembers how you take your coffee.</p>
          </div>
        </div>
      </div>

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