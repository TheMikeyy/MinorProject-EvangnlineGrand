<?php
require_once __DIR__ . '/admin/admin-include/db_config.php';

/* ---- contact form: validate, save into the database, then redirect (so a refresh never re-sends) ---- */
$contact_errors = [];
$contact_old = ['name' => '', 'email' => '', 'subject' => '', 'message' => ''];
$cu = current_user();
if ($cu && $_SERVER['REQUEST_METHOD'] !== 'POST') { $contact_old['name'] = $cu['name']; $contact_old['email'] = $cu['email']; }   // logged-in guests: pre-filled
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_form'])) {
    csrf_check();
    foreach ($contact_old as $k => $unused) { $contact_old[$k] = trim((string)($_POST[$k] ?? '')); }

    if (trim((string)($_POST['website'] ?? '')) !== '') {                  // hidden "honeypot" field: only bots fill it
        flash_set('success', 'Thank you! Your message has been sent. We will get back to you soon.');
        redirect('contact.php#send');
    }
    if (time() - (int)($_SESSION['last_contact_at'] ?? 0) < 20) { $contact_errors[] = 'Please wait a few seconds before sending another message.'; }
    if (mb_strlen($contact_old['name']) < 2 || mb_strlen($contact_old['name']) > 100)             { $contact_errors[] = 'Please enter your name.'; }
    if (!filter_var($contact_old['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($contact_old['email']) > 150) { $contact_errors[] = 'Please enter a valid email address.'; }
    if ($contact_old['subject'] === '' || mb_strlen($contact_old['subject']) > 200)               { $contact_errors[] = 'Please enter a subject (up to 200 characters).'; }
    if (mb_strlen($contact_old['message']) < 5 || mb_strlen($contact_old['message']) > 3000)      { $contact_errors[] = 'Please write a message (5 to 3000 characters).'; }

    if (!$contact_errors) {
        run('INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)',
            [$contact_old['name'], $contact_old['email'], $contact_old['subject'], $contact_old['message']]);
        $_SESSION['last_contact_at'] = time();
        notify_admin('New message: ' . $contact_old['subject'], "From: {$contact_old['name']} <{$contact_old['email']}>\nSubject: {$contact_old['subject']}\n\n{$contact_old['message']}\n\nOpen the inbox: " . site_url('admin/admin-messages.php'));
        flash_set('success', 'Thank you! Your message has been sent. We will get back to you soon.');
        redirect('contact.php#send');
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | <?= e(setting('hotel_name')) ?></title>
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
    background-image: url('<?= e(img('contact_banner')) ?>');
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

  /* ---------- STANDARDIZED HERO LOGO (unified with index page sizing) ---------- */
  .contact-hero-logo{
    display: block;
    width: 46%;
    max-width: 460px;
    min-width: 260px;
    height: auto;
    margin: 1rem auto 0;
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
    .contact-hero-logo{
      width: 60%;
      min-width: 0;
      max-width: 400px;
      margin-top: .4rem;
    }
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
    font-size: 1.24rem;
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
    --card-cap-img: url('<?= e(img('contact_cap1')) ?>');
  }

  .card-cap-message{
    --card-cap-img: url('<?= e(img('contact_cap2')) ?>');
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
    <h1 class="contact-hero-title">Contact Us</h1>
    <img src="<?= e(img('logo_hero')) ?>" alt="<?= e(setting('hotel_name')) ?>" class="contact-hero-logo">
  </div>
</div>

<!-- INTRO -->
<div class="container contact-intro text-center">
  <span class="section-eyebrow d-block"><?= e(setting('contact_eyebrow')) ?></span>
  <h2 class="mb-0 fw-bold section-font"><?= e(setting('contact_title')) ?></h2>
  <div class="h-line bg-dark mx-auto mt-3"></div>
  <p>
    <?= e(setting('contact_intro')) ?>
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

        <iframe class="map-frame" src="<?= e(setting('map_embed_url')) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>

        <div class="contact-info-pad">
          <div class="contact-info-block">
            <div class="contact-info-label">
              <span class="contact-info-icon"><i class="fa-solid fa-location-dot"></i></span>
              Address
            </div>
            <p><?= e(setting('address')) ?></p>
          </div>

          <div class="contact-info-block">
            <div class="contact-info-label">
              <span class="contact-info-icon"><i class="fa-solid fa-phone"></i></span>
              Call Us
            </div>
            <p><a href="<?= e(tel_href(setting('phone'))) ?>"><?= e(setting('phone')) ?></a></p>
            <?php if (trim(setting('phone2')) !== ''): ?><p><a href="<?= e(tel_href(setting('phone2'))) ?>"><?= e(setting('phone2')) ?></a></p><?php endif; ?>
          </div>

          <div class="contact-info-block">
            <div class="contact-info-label">
              <span class="contact-info-icon"><i class="fa-solid fa-envelope"></i></span>
              Email
            </div>
            <p><a href="mailto:<?= e(setting('email')) ?>"><?= e(setting('email')) ?></a></p>
          </div>

          <div class="contact-info-block">
            <div class="contact-info-label">
              <span class="contact-info-icon"><i class="fa-solid fa-heart"></i></span>
              Follow Us
            </div>
            <div class="contact-social">
              <a <?= social_attrs('social_instagram') ?> aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
              <a <?= social_attrs('social_facebook') ?> aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
              <a <?= social_attrs('social_youtube') ?> aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
              <a <?= social_attrs('social_x') ?> aria-label="X"><i class="fa-brands fa-x-twitter"></i></a>
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

        <div class="contact-form-body" id="send">
        <?php foreach (flash_take() as $fl): ?>
          <div class="alert alert-<?= $fl['type'] === 'success' ? 'success' : 'danger' ?> py-2" role="alert"><?= e($fl['msg']) ?></div>
        <?php endforeach; ?>
        <?php foreach ($contact_errors as $er): ?>
          <div class="alert alert-danger py-2" role="alert"><?= e($er) ?></div>
        <?php endforeach; ?>
        <form action="contact.php#send" method="POST">
          <?= csrf_field() ?>
          <input type="hidden" name="contact_form" value="1">
          <div style="position:absolute;left:-9999px;" aria-hidden="true"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>
          <div class="mb-3">
            <label for="contactName" class="form-label">Name</label>
            <input type="text" class="form-control" id="contactName" name="name" placeholder="Your full name" value="<?= e($contact_old['name']) ?>" required>
          </div>

          <div class="mb-3">
            <label for="contactEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="contactEmail" name="email" placeholder="you@example.com" value="<?= e($contact_old['email']) ?>" required>
          </div>

          <div class="mb-3">
            <label for="contactSubject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="contactSubject" name="subject" placeholder="What's this about?" value="<?= e($contact_old['subject']) ?>" required>
          </div>

          <div class="mb-3 message-group">
            <label for="contactMessage" class="form-label">Message</label>
            <textarea class="form-control" id="contactMessage" name="message" placeholder="Tell us a little more..." required><?= e($contact_old['message']) ?></textarea>
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