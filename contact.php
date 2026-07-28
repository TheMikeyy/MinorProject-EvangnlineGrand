<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Évangéline Grand</title>
    <?php require('include/links.php') ?>
</head>
<body class="bg-light">

<style>

  body{
    background-image: none !important;
  }

  /* ---------- Contact hero ---------- */
  .contact-hero{
    position: relative;
    min-height: 460px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }

  .contact-hero-bg{
    position: absolute;
    inset: 0;
    background-image: url('images/contact/front.jpeg');
    background-size: cover;
    background-position: center;
    transform: scale(1.03);
  }

  .contact-hero::after{
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(19,20,28,.66) 0%, rgba(19,20,28,.42) 45%, rgba(19,20,28,.8) 100%);
  }

  .contact-hero-content{
    position: relative;
    z-index: 2;
    text-align: center;
    color: var(--paper);
    padding: 2rem 1rem 0;
    max-width: 640px;
  }

  .contact-hero-eyebrow{
    display: block;
    font-family: "Great Vibes", cursive;
    font-size: 2.2rem;
    color: var(--rose);
    margin-bottom: -.1rem;
  }

  .contact-hero-logo{
    display: block;
    width: 46%;
    max-width: 700px;
    min-width: 380px;
    height: auto;
    margin: 0 auto 1rem;
    filter: drop-shadow(0 3px 14px rgba(0,0,0,.4));
  }

  .contact-hero-title{
    font-family: 'DM Serif Display', serif;
    letter-spacing: 1.5px;
    font-size: 2.2rem;
    margin-bottom: .9rem;
  }

  .contact-hero-sub{
    font-size: 1.1rem;
    line-height: 1.75;
    color: rgba(255,255,255,.8);
    margin: 0 auto 1.5rem;
  }

  @media screen and (max-width: 575px){
    .contact-hero{ min-height: 380px; }
    .contact-hero-logo{ width: 60%; min-width: 0; max-width: 380px; }
    .contact-hero-title{ font-size: 1.7rem; }
  }

  /* ---------- Intro ---------- */
  .contact-intro{
    padding-top: 5rem;
    padding-bottom: 1rem;
  }

  .contact-intro p{
    max-width: 720px;
    margin: 1.25rem auto 0;
    color: var(--ink-black);
    font-size: 1.05rem;
    line-height: 1.8;
  }

  /* ---------- Contact grid ---------- */
  .contact-grid{
    padding-top: 3rem;
    padding-bottom: 5.5rem;
  }

  .contact-grid .row{
    align-items: stretch;
  }

  .contact-card{
    position: relative;
    border-radius: 22px;
    box-shadow: 0 26px 54px -12px rgba(19,20,28,.28), 0 4px 14px rgba(31,42,82,.08);
    background-color: var(--paper);
    height: 100%;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: box-shadow .35s ease, transform .35s ease;
  }

  .contact-card:hover{
    box-shadow: 0 34px 64px -12px rgba(19,20,28,.34), 0 6px 18px rgba(31,42,82,.1);
    transform: translateY(-5px);
  }

  .card-cap{
    position: relative;
    padding: 2rem 1.6rem 2.9rem;
    text-align: center;
    color: var(--paper);
    background-image: linear-gradient(150deg, rgba(19,20,28,.82) 0%, rgba(19,20,28,.55) 60%, rgba(19,20,28,.85) 100%), var(--card-cap-img, none);
    background-size: cover;
    background-position: center;
    overflow: hidden;
  }

  .card-cap-visit{
    --card-cap-img: url('images/contact/cap1.jpeg');
  }

  .card-cap-message{
    --card-cap-img: url('images/contact/cap2.jpeg');
  }

  .card-cap-eyebrow{
    position: relative;
    z-index: 1;
    display: block;
    font-family: 'Cinzel Decorative', serif;
    font-size: .95rem;
    letter-spacing: .5px;
    color: var(--rose);
    margin-bottom: .35rem;
  }

  .card-cap h5{
    position: relative;
    z-index: 1;
    font-family: 'DM Serif Display', serif;
    font-size: 1.45rem;
    margin: 0;
  }

  .card-badge{
    width: 66px;
    height: 66px;
    min-width: 66px;
    border-radius: 50%;
    background-color: var(--paper);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--wine);
    font-size: 24px;
    margin: -33px auto 0;
    position: relative;
    z-index: 2;
    box-shadow: 0 10px 22px rgba(19,20,28,.2);
    border: 3px solid var(--cream);
  }

  .map-frame{
    width: 100%;
    height: 260px;
    border: 0;
    display: block;
    margin-top: 30px;
  }

  .contact-info-pad{
    padding: 1.4rem 1.8rem 2rem;
  }

  .contact-info-block{
    margin-bottom: 1.6rem;
  }

  .contact-info-block:last-child{
    margin-bottom: 0;
  }

  .contact-info-label{
    display: flex;
    align-items: center;
    gap: .6rem;
    font-family: "Jost", sans-serif;
    font-weight: 600;
    color: var(--ink);
    font-size: 1.05rem;
    margin-bottom: .5rem;
  }

  .contact-info-icon{
    width: 36px;
    height: 36px;
    min-width: 36px;
    border-radius: 50%;
    border: 1.5px solid rgba(31,42,82,.16);
    background-color: var(--cream);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--wine);
    font-size: 14px;
  }

  .contact-info-block p,
  .contact-info-block a{
    color: var(--ink-black);
    font-size: .95rem;
    line-height: 1.6;
    margin-bottom: .15rem;
    text-decoration: none;
  }

  .contact-info-block a:hover{
    color: var(--wine);
  }

  .contact-social{
    display: flex;
    gap: .7rem;
    margin-top: .9rem;
    padding-top: .3rem;
  }

  .contact-social a{
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background-color: var(--cream);
    border: 1.5px solid rgba(31,42,82,.16);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--ink);
    font-size: 15px;
    transition: background-color .2s ease, color .2s ease, transform .2s ease;
  }

  .contact-social a:hover{
    background-color: var(--wine);
    color: var(--paper);
    transform: translateY(-2px);
  }

  /* ---------- Form ---------- */
  .contact-form-body{
    padding: 1.4rem 2.2rem 2.4rem;
    flex: 1;
    display: flex;
    flex-direction: column;
  }

  .contact-form-body form{
    flex: 1;
    display: flex;
    flex-direction: column;
  }

  .contact-form-body label{
    font-size: .85rem;
    font-weight: 500;
    color: var(--ink);
    margin-bottom: .4rem;
  }

  .contact-form-body .form-control{
    border-radius: 10px;
    border: 1.5px solid rgba(31,42,82,.14);
    padding: .65rem .9rem;
    font-size: .95rem;
    background-color: #faf8f4;
    color: var(--ink-black);
  }

  .contact-form-body .form-control::placeholder{
    color: rgba(31,29,35,.45);
  }

  .contact-form-body .form-control:focus{
    background-color: var(--paper);
    border-color: var(--ink);
    box-shadow: 0 0 0 3px rgba(31,42,82,.14);
  }

  .contact-form-body .message-group{
    flex: 1;
    display: flex;
    flex-direction: column;
  }

  .contact-form-body textarea.form-control{
    flex: 1;
    min-height: 200px;
    resize: vertical;
  }

  .contact-form-body .mb-3{
    margin-bottom: 1.3rem !important;
  }

  .contact-form-submit{
    text-align: center;
    margin-top: .3rem;
  }

  .btn-ink{
    background-color: var(--ink);
    border: 1px solid var(--ink);
    color: var(--paper);
    transition: background-color .2s ease, transform .2s ease;
  }

  .btn-ink:hover{
    background-color: var(--ink-black);
    border-color: var(--ink-black);
    color: var(--paper);
    transform: translateY(-2px);
  }

  @media (max-width: 991.98px){
    .contact-card{ margin-top: 0; }
    .col-lg-6:last-child .contact-card{ margin-top: 1.5rem; }
  }
</style>

<?php require('include/navbar.php') ?>

<!-- CONTACT HERO -->
<div class="contact-hero">
  <div class="contact-hero-bg"></div>
  <div class="contact-hero-content">
    <img src="images/logo/logo-hero-body.png" alt="Évangéline Grand" class="contact-hero-logo">
    <h1 class="contact-hero-title">Contact Us</h1>
    <p class="contact-hero-sub">
      Questions about a stay, a booking already in place, or something you'd like arranged before you
      arrive, reach us directly and we'll get back to you shortly.
    </p>
  </div>
</div>

<!-- INTRO -->
<div class="container contact-intro text-center">
  <span class="section-eyebrow d-block">Reach Out</span>
  <h2 class="mb-0 fw-bold section-font">GET IN TOUCH</h2>
  <div class="h-line bg-dark mx-auto mt-3"></div>
  <p>
    Whether it's a question before you book, a request for your upcoming stay, or simply directions to
    the valley, our team is on hand to help. Find us on the map below, or send a message directly.
  </p>
</div>

<!-- CONTACT GRID -->
<div class="container contact-grid">
  <div class="row g-4">

    <!-- MAP -->
    <div class="col-lg-6 reveal">
      <div class="contact-card">
        <div class="card-cap card-cap-visit">
          <span class="card-cap-eyebrow">Find The Valley</span>
          <h5>Visit Us</h5>
        </div>
        <div class="card-badge"><i class="fa-solid fa-location-dot"></i></div>

        <iframe class="map-frame" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2816.1670154276353!2d-64.30946076511229!3d45.10268230000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4b58559db9646275%3A0xcca6eaa98adc0353!2sThe%20Evangeline%20Hotel!5e0!3m2!1sen!2sin!4v1784649732488!5m2!1sen!2sin" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>

        <div class="contact-info-pad">
          <div class="contact-info-block">
            <div class="contact-info-label">
              <span class="contact-info-icon"><i class="fa-solid fa-location-dot"></i></span>
              Address
            </div>
            <p>Grand Pré, Annapolis Valley, Nova Scotia, Canada</p>
          </div>

          <div class="contact-info-block">
            <div class="contact-info-label">
              <span class="contact-info-icon"><i class="fa-solid fa-phone"></i></span>
              Call Us
            </div>
            <p><a href="tel:+19025550142">+1 902 555 0198</a></p>
            <p><a href="tel:+19025550198">+1 902 555 0198</a></p>
          </div>

          <div class="contact-info-block">
            <div class="contact-info-label">
              <span class="contact-info-icon"><i class="fa-solid fa-envelope"></i></span>
              Email
            </div>
            <p><a href="mailto:stay@evangelinegrand.com">stay@evangelinegrand.com</a></p>
          </div>

          <div class="contact-info-block">
            <div class="contact-info-label">
              <span class="contact-info-icon"><i class="fa-solid fa-heart"></i></span>
              Follow Us
            </div>
            <div class="contact-social">
              <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
              <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
              <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
              <a href="#" aria-label="X"><i class="fa-brands fa-x-twitter"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- FORM -->
    <div class="col-lg-6 reveal">
      <div class="contact-card">
        <div class="card-cap card-cap-message">
          <span class="card-cap-eyebrow">Get In Touch</span>
          <h5>Send A Message</h5>
        </div>
        <div class="card-badge"><i class="fa-solid fa-envelope"></i></div>

        <div class="contact-form-body">
        <form action="" method="POST">
          <div class="mb-3">
            <label for="contactName" class="form-label">Name</label>
            <input type="text" class="form-control" id="contactName" name="name" placeholder="Your full name" required>
          </div>

          <div class="mb-3">
            <label for="contactEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="contactEmail" name="email" placeholder="you@example.com" required>
          </div>

          <div class="mb-3">
            <label for="contactSubject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="contactSubject" name="subject" placeholder="What's this about?" required>
          </div>

          <div class="mb-3 message-group">
            <label for="contactMessage" class="form-label">Message</label>
            <textarea class="form-control" id="contactMessage" name="message" placeholder="Tell us a little more..." required></textarea>
          </div>

          <div class="contact-form-submit">
            <button type="submit" class="btn btn-ink rounded-pill px-4 py-2">Send Message</button>
          </div>
        </form>
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