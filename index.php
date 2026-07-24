<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Évangéline Grand</title>
    <?php require('include/links.php') ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css"/>
  </head>
<body class="bg-light">

<?php require('include/navbar.php')?>

<!-- HERO -->
<div class="hero-wrap">
  <div class="swiper swiper-container hero-swiper">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <img src="images/crousel/1.jpeg" class="w-100 d-block"/>
        </div>
        <div class="swiper-slide">
          <img src="images/crousel/2.jpeg" class="w-100 d-block"/>
        </div>
        <div class="swiper-slide">
          <img src="images/crousel/3.jpeg" class="w-100 d-block"/>
        </div>
        <div class="swiper-slide">
          <img src="images/crousel/4.jpeg" class="w-100 d-block"/>
        </div>
      </div>
  </div>
  <div class="hero-overlay">
    <span class="hero-script">Welcome To The</span>
    <img src="images/logo/logo-hero-body.png" alt="Évangéline Grand" class="hero-logo-img">
    <p class="hero-tagline">The perfect mix of reliable comfort and warm, genuine hospitality & a restful night's sleep, exactly as it should be.</p>
  </div>
</div>

<div class="container availability-form">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="bg-white shadow p-4 availability-card">
        <span class="section-eyebrow d-block mb-1 text-center">Reserve your stay</span>
        <form>
          <div class="row align-items-end availability-row">

            <div class="field-checkin mb-3">
              <label class="form-label">Check-In</label>
              <input type="date" class="form-control shadow-none">
            </div>

            <div class="field-checkout mb-3">
              <label class="form-label">Check-Out</label>
              <input type="date" class="form-control shadow-none">
            </div>

            <div class="field-children mb-3">
              <label class="form-label">Children</label>
              <select class="form-select shadow-none">
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
                <option value="4">Four</option>
              </select>
            </div>

            <div class="field-adult mb-3">
              <label class="form-label">Adult</label>
              <select class="form-select shadow-none">
                <option value="1">One</option>
                <option value="2">Two</option>
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
  
  <h2 class="mb-0 fw-bold section-font">PREVIEW OUR LODGES</h2>
</div>

<div class="container">
 <div class="row">
   <div class="col-lg-4 col-md-6 my-3">
    <div class="card border-0 shadow lodge-hover" style="max-width: 350px; margin: auto;">
      <img src="images/lodge/1.jpeg" class="card-img-top" alt="The Nirvana Pavilion">
      <div class="card-body text-center">
        <span class="lodge-tier">Signature</span>
        <h5>The Nirvana Pavilion</h5>
        <h6 class="mb-4">₹5,000 – ₹9,000 per night</h6>
         <div class="rating mb-4">
          <h6 class="mb-1">Rating:</h6>
         <span class="badge rounded-pill bg-light text-dark text-wrap">
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
         </span>
        </div>
        <div class="features mb-4">
          <h6 class="mb-1">Features:</h6>
          <span class="pill">Spacious Deluxe Rooms</span>
          <span class="pill">King size Bed</span>
          <span class="pill">Private Bathroom</span>
          <span class="pill">Wardrobe and closet</span>
        </div>
        <div class="facilities mb-4">
           <h6 class="mb-1">Facilities:</h6>
          <span class="pill">High-speed Wi-Fi</span>
          <span class="pill">Air Conditioning</span>
          <span class="pill">Streaming Smart TV</span>
          <span class="pill">Work Desk and Chair</span>
        </div>
        <div class="d-flex justify-content-center gap-3 mb-2">
          <a href="#" class="btn btn-sm text-white custom-bg shadow-none rounded-pill px-3">Book Now</a>
          <a href="#" class="btn btn-sm btn-outline-dark shadow-none rounded-pill px-3">More Details</a>
        </div>
      </div>
    </div>
   </div>

 <div class="col-lg-4 col-md-6 my-3">
    <div class="card border-0 shadow lodge-hover" style="max-width: 350px; margin: auto;">
      <img src="images/lodge/2.jpeg" class="card-img-top" alt="The Panorama Suite">
      <div class="card-body text-center">
        <span class="lodge-tier">Premier</span>
        <h5>The Panorama Suite</h5>
        <h6 class="mb-4">₹10,000 – ₹15,000 per night</h6>
         <div class="rating mb-4">
          <h6 class="mb-1">Rating:</h6>
         <span class="badge rounded-pill bg-light text-dark text-wrap">
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-half"></i>
         </span>
        </div>
        <div class="features mb-4">
          <h6 class="mb-1">Features:</h6>
          <span class="pill">King size Bed</span>
          <span class="pill">Cove lighting</span>
          <span class="pill">Dual view windows</span>
          <span class="pill">Cushioned bench seating</span>
        </div>
        <div class="facilities mb-4">
           <h6 class="mb-1">Facilities:</h6>
          <span class="pill">Lounge area with seating</span>
          <span class="pill">5-G Wi-Fi</span>
          <span class="pill">Air Conditioning</span>
          <span class="pill">Glass top coffee table</span>
        </div>
        <div class="d-flex justify-content-center gap-3 mb-2">
          <a href="#" class="btn btn-sm text-white custom-bg shadow-none rounded-pill px-3">Book Now</a>
          <a href="#" class="btn btn-sm btn-outline-dark shadow-none rounded-pill px-3">More Details</a>
        </div>
      </div>
    </div>
   </div>

    <div class="col-lg-4 col-md-6 my-3">
    <div class="card border-0 shadow lodge-hover" style="max-width: 350px; margin: auto;">
      <img src="images/lodge/3.jpeg" class="card-img-top" alt="The Regal Canopy Lodge">
      <div class="card-body text-center">
        <span class="lodge-tier">Grand Reserve</span>
        <h5>The Regal Canopy Lodge</h5>
        <h6 class="mb-4">₹18,000 – ₹23,000 per night</h6>
         <div class="rating mb-4">
          <h6 class="mb-1">Rating:</h6>
         <span class="badge rounded-pill bg-light text-dark text-wrap">
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-half"></i>
         </span>
        </div>
        <div class="features mb-4">
          <h6 class="mb-1">Features:</h6>
          <span class="pill">Curved Floor Ceiling</span>
          <span class="pill">Elevated private platform</span>
          <span class="pill">Four poster canopy bed</span>
          <span class="pill">Mirror paneled accent wall</span>
        </div>
        <div class="facilities mb-4">
           <h6 class="mb-1">Facilities:</h6>
          <span class="pill">Special Butler Service</span>
          <span class="pill">Round designer coffee table</span>
          <span class="pill">In room mini-bar</span>
          <span class="pill">High-speed Wi-Fi</span>
        </div>
        <div class="d-flex justify-content-center gap-3 mb-2">
          <a href="#" class="btn btn-sm text-white custom-bg shadow-none rounded-pill px-3">Book Now</a>
          <a href="#" class="btn btn-sm btn-outline-dark shadow-none rounded-pill px-3">More Details</a>
         </div>
         </div>
        </div>
       </div>
      <div class="col-lg-12 text-center mt-5">
    <a href="#" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none rounded-pill px-3">Explore More Lodges ></a>
   </div>
 </div>
</div>

<!-- CONVENIENCE -->
<div class="section-white mt-5">
  <div id="comforts" class="section-pad text-center section-head reveal">
    <span class="section-eyebrow">Where Every Comfort Is Considered</span>
    <h2 class="mb-0 fw-bold section-font">OUR CONVENIENCE</h2>
  </div>

  <div class="container pb-5">
    <div class="convenience-row">
      <div class="convenience-card">
        <div class="convenience-icon"><i class="fa-solid fa-mug-saucer"></i></div>
        <h5>Complimentary breakfast</h5>
      </div>
      <div class="convenience-card">
        <div class="convenience-icon"><i class="fa-solid fa-charging-station"></i></div>
        <h5>EV Charging Station</h5>
      </div>
      <div class="convenience-card">
        <div class="convenience-icon"><i class="fa-solid fa-video"></i></div>
        <h5>24/7 security &amp; CCTV</h5>
      </div>
      <div class="convenience-card">
        <div class="convenience-icon"><i class="fa-solid fa-people-group"></i></div>
        <h5>Conference/banquet halls</h5>
      </div>
      <div class="convenience-card">
        <div class="convenience-icon"><i class="fa-solid fa-shirt"></i></div>
        <h5>Laundry service</h5>
      </div>
      <div class="convenience-card">
        <div class="convenience-icon"><i class="fa-solid fa-martini-glass-citrus"></i></div>
        <h5>Rooftop Bar</h5>
      </div>
      <div class="convenience-card">
        <div class="convenience-icon"><i class="fa-solid fa-water-ladder"></i></div>
        <h5>Swimming pool &amp; spa</h5>
      </div>
    </div>
  </div>
</div>

<!-- TESTIMONIALS -->
<div class="section-pad text-center section-head reveal">
  <h2 class="mb-0 fw-bold section-font">TESTIMONIALS</h2>
</div>

<div class="container">
  <div class="d-flex justify-content-center mb-3">
    <div class="swiper-pagination position-static"></div>
  </div>

  <div class="swiper swiper-testimonials position-relative">
    <div class="swiper-wrapper">

  <div class="swiper-slide testimonial-card bg-white p-4 text-center">
    <div class="d-flex align-items-center justify-content-center mb-3">
      <img src="https://ui-avatars.com/api/?name=Ananya+Rao&background=7A2333&color=fff&bold=true&size=128" width="40" class="rounded-circle">
      <h6 class="mb-0 ms-2">Ananya Rao</h6>
    </div>
    <p class="mb-3">The Nirvana Pavilion exceeded every expectation, the bed alone made the whole trip worth it. Breakfast was a lovely surprise too.</p>
    <div class="rating">
      <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
    </div>
  </div>

  <div class="swiper-slide testimonial-card bg-white p-4 text-center">
    <div class="d-flex align-items-center justify-content-center mb-3">
      <img src="https://ui-avatars.com/api/?name=Mackenzie+Fraser&background=7A2333&color=fff&bold=true&size=128" width="40" class="rounded-circle">
      <h6 class="mb-0 ms-2">Mackenzie Fraser</h6>
    </div>
    <p class="mb-3">Beautiful property, quiet and peaceful just like the name promises. Rooftop bar at sunset is unmissable.</p>
    <div class="rating">
      <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
    </div>
  </div>

  <div class="swiper-slide testimonial-card bg-white p-4 text-center">
    <div class="d-flex align-items-center justify-content-center mb-3">
      <img src="https://ui-avatars.com/api/?name=Rohan+Malhotra&background=7A2333&color=fff&bold=true&size=128" width="40" class="rounded-circle">
      <h6 class="mb-0 ms-2">Rohan Malhotra</h6>
    </div>
    <p class="mb-3">Booked the Panorama Suite for our anniversary and the staff went out of their way to make it special. Will be back.</p>
    <div class="rating">
      <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
    </div>
  </div>

  <div class="swiper-slide testimonial-card bg-white p-4 text-center">
    <div class="d-flex align-items-center justify-content-center mb-3">
      <img src="https://ui-avatars.com/api/?name=Charlotte+Belanger&background=7A2333&color=fff&bold=true&size=128" width="40" class="rounded-circle">
      <h6 class="mb-0 ms-2">Charlotte Bélanger</h6>
    </div>
    <p class="mb-3">Loved the location in the Annapolis Valley, peaceful mornings with coffee on the balcony. Wifi could be a touch faster.</p>
    <div class="rating">
      <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
    </div>
  </div>

  <div class="swiper-slide testimonial-card bg-white p-4 text-center">
    <div class="d-flex align-items-center justify-content-center mb-3">
      <img src="https://ui-avatars.com/api/?name=Ishaan+Verma&background=7A2333&color=fff&bold=true&size=128" width="40" class="rounded-circle">
      <h6 class="mb-0 ms-2">Ishaan Verma</h6>
    </div>
    <p class="mb-3">The Regal Canopy Lodge is worth every penny. Butler service felt genuinely personal, not scripted.</p>
    <div class="rating">
      <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
    </div>
  </div>

  <div class="swiper-slide testimonial-card bg-white p-4 text-center">
    <div class="d-flex align-items-center justify-content-center mb-3">
      <img src="https://ui-avatars.com/api/?name=Emily+Thompson&background=7A2333&color=fff&bold=true&size=128" width="40" class="rounded-circle">
      <h6 class="mb-0 ms-2">Emily Thompson</h6>
    </div>
    <p class="mb-3">Clean, comfortable, and the pool area is gorgeous at golden hour. Would've liked more late-night dining options.</p>
    <div class="rating">
      <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
    </div>
  </div>

  <div class="swiper-slide testimonial-card bg-white p-4 text-center">
    <div class="d-flex align-items-center justify-content-center mb-3">
      <img src="https://ui-avatars.com/api/?name=Priya+Nair&background=7A2333&color=fff&bold=true&size=128" width="40" class="rounded-circle">
      <h6 class="mb-0 ms-2">Priya Nair</h6>
    </div>
    <p class="mb-3">Check-in was seamless and the room upgrade they gave us was a wonderful surprise. Highly recommend the spa.</p>
    <div class="rating">
      <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
    </div>
  </div>

  <div class="swiper-slide testimonial-card bg-white p-4 text-center">
    <div class="d-flex align-items-center justify-content-center mb-3">
      <img src="https://ui-avatars.com/api/?name=Liam+OConnell&background=7A2333&color=fff&bold=true&size=128" width="40" class="rounded-circle">
      <h6 class="mb-0 ms-2">Liam O'Connell</h6>
    </div>
    <p class="mb-3">Nice stay overall, though our room's AC was a little noisy at night. Staff fixed it quickly when we mentioned it.</p>
    <div class="rating">
      <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
    </div>
  </div>

  <div class="swiper-slide testimonial-card bg-white p-4 text-center">
    <div class="d-flex align-items-center justify-content-center mb-3">
      <img src="https://ui-avatars.com/api/?name=Sanya+Kapoor&background=7A2333&color=fff&bold=true&size=128" width="40" class="rounded-circle">
      <h6 class="mb-0 ms-2">Sanya Kapoor</h6>
    </div>
    <p class="mb-3">Honestly one of the best hotel experiences we've had, the EV charging station was a nice bonus for our road trip too.</p>
    <div class="rating">
      <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
    </div>
  </div>

</div>
  </div>
</div>
<div class="col-lg-12 text-center mt-3">
  <a href="#" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none rounded-pill px-3">Know About More ></a>
</div>

<!-- LOCATE US  -->
<div id="locate" class="locate-section">
  <div class="locate-bg"></div>
  <div class="locate-overlay"></div>

  <div class="container locate-content">
    <div class="text-center section-head reveal">
      <h2 class="mb-0 fw-bold section-font on-dark">LOCATE US</h2>
    </div>

    <div class="row g-4">
      <div class="col-lg-7">
        <div class="p-3 locate-card locate-card-map reveal">
          <iframe class="w-100" height="472" style="border:0;"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2816.1670154276353!2d-64.30946076511229!3d45.10268230000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4b58559db9646275%3A0xcca6eaa98adc0353!2sThe%20Evangeline%20Hotel!5e0!3m2!1sen!2sin!4v1784649732488!5m2!1sen!2sin" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
      </div>

      <div class="col-lg-5 d-flex flex-column gap-3">
        <div class="p-4 locate-card reveal">
          <h5>Visit Us</h5>
          <div class="contact-row mb-3">
            <span class="contact-icon"><i class="bi bi-geo-alt-fill"></i></span>
            <span>Grand Pré, Annapolis Valley, Nova Scotia, Canada</span>
          </div>
          <div class="hours-row"><span>Reception</span><span>24 / 7</span></div>
          <div class="hours-row"><span>Concierge desk</span><span>7:00 am To 11:00 pm</span></div>
          <div class="hours-row"><span>Rooftop Bar</span><span>5:00 pm To 1:00 am</span></div>
        </div>

        <div class="p-4 locate-card reveal">
          <h5>Contact Us</h5>
          <div class="contact-row mb-2">
            <span class="contact-icon"><i class="bi bi-telephone-outbound-fill"></i></span>
            <a href="tel:+919016588906" class="text-decoration-none text-dark">+91 90165 88906</a>
          </div>
          <div class="contact-row">
            <span class="contact-icon"><i class="bi bi-envelope-fill"></i></span>
            <a href="mailto:stay@evangelinegrand.com" class="text-decoration-none text-dark">stay@evangelinegrand.com</a>
          </div>
        </div>

        <div class="p-4 locate-card reveal">
          <h5>Follow Us</h5>
          <div class="d-flex flex-wrap gap-2">
            <a href="#" class="badge rounded-pill social-pill fs-6 p-2 text-decoration-none">
              <i class="bi bi-instagram"></i> Instagram
            </a>
            <a href="#" class="badge rounded-pill social-pill fs-6 p-2 text-decoration-none">
              <i class="bi bi-facebook me-1"></i> Facebook
            </a>
            <a href="#" class="badge rounded-pill social-pill fs-6 p-2 text-decoration-none">
              <i class="bi bi-youtube"></i> Youtube
            </a>
            <a href="#" class="badge rounded-pill social-pill fs-6 p-2 text-decoration-none">
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
  loop: true,
  autoplay: {
    delay: 2500,
    disableOnInteraction: false,
  },
});

var swiperTestimonials = new Swiper('.swiper-testimonials', {
  effect: 'coverflow',
  grabCursor: true,
  centeredSlides: true,
  slidesPerView: 'auto',
  loop: true,
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