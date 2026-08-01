<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Lodges | Évangéline Grand</title>
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
    background-image: url('images/lodge/hallway.jpg');
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

<?php require('include/navbar.php') ?>

<!-- PAGE HERO -->
<div class="page-hero">
  <div class="page-hero-bg"></div>
  <div class="page-hero-content">
    <h1 class="page-hero-title">Our Lodges</h1>
    <img src="images/logo/logo-hero-body.png" alt="Évangéline Grand" class="page-hero-logo">
  </div>
</div>

<!-- INTRO -->
<div class="container lodges-intro text-center">
  <span class="section-eyebrow d-block">Find Your Retreat</span>
  <h2 class="mb-0 fw-bold section-font">ALL LODGES</h2>
  <div class="h-line bg-dark mx-auto mt-3"></div>
  <p>
    From cozy signature rooms to the fully attended Grand Reserve, every lodge here is shaped around
    a slower kind of stay. Filter by dates, party size, and budget to find the one that fits.
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
            <input type="date" class="form-control shadow-none" id="filterCheckin">
          </div>

          <div class="col-lg-2 col-md-6 col-12">
            <label for="filterCheckout" class="form-label">Check-Out</label>
            <input type="date" class="form-control shadow-none" id="filterCheckout">
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
          <span class="filters-results-note" id="filterResultsNote">Showing <strong>10</strong> of <strong>10</strong> lodges</span>
          <button type="button" class="btn btn-sm btn-outline-dark px-3 shadow-none" id="filterResetBtn">Reset Filters</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- LODGE GRID -->
<div class="container lodges-grid-wrap reveal">
  <div id="lodgeGrid" class="view-grid">

    <!-- 1: The Nirvana Pavilion -->
    <div class="lodge-item" data-price="5000" data-adults="6" data-children="4">
      <div class="list-card-wrap reveal">
        <div class="list-card-flip" data-flip="left">
          <div class="list-card-details">
            <button type="button" class="list-card-close" aria-label="Back to photo"><i class="fa-solid fa-image"></i></button>
            <span class="lodge-tier">Signature</span>
            <h5>The Nirvana Pavilion</h5>
            <div class="price-line">₹5,000 – ₹9,000 per night</div>
            <p class="blurb">Spacious signature comfort with a king bed and private bath, built for an easy, relaxed stay.</p>
            <div class="pill-group">
              <div class="mini-label">Features</div>
              <span class="pill">Spacious Deluxe Rooms</span>
              <span class="pill">King size Bed</span>
            </div>
            <div class="pill-group">
              <div class="mini-label">Facilities</div>
              <span class="pill">High-speed Wi-Fi</span>
              <span class="pill">Air Conditioning</span>
            </div>
            <div class="guests-limit">
              <div class="mini-label">Guests Limit</div>
              <span class="pill">6 Adults</span>
              <span class="pill">4 Childrens</span>
            </div>
            <a href="#" class="btn btn-sm text-white custom-bg shadow-none rounded-pill px-3">Book Now</a>
          </div>
          <div class="list-card-image">
            <img src="images/lodge/1.jpeg" alt="The Nirvana Pavilion">
            <div class="list-card-image-caption">
              <span class="lodge-tier">Signature</span>
              <h6>The Nirvana Pavilion</h6>
              <span class="tap-hint"><i class="fa-solid fa-hand-pointer"></i> Tap to view details</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- 2: The Panorama Suite -->
    <div class="lodge-item" data-price="10000" data-adults="7" data-children="3">
      <div class="list-card-wrap reveal">
        <div class="list-card-flip" data-flip="right">
          <div class="list-card-details">
            <button type="button" class="list-card-close" aria-label="Back to photo"><i class="fa-solid fa-image"></i></button>
            <span class="lodge-tier">Premier</span>
            <h5>The Panorama Suite</h5>
            <div class="price-line">₹10,000 – ₹15,000 per night</div>
            <p class="blurb">Wide dual-view windows and a lounge seating area for a bright, elevated stay in the valley.</p>
            <div class="pill-group">
              <div class="mini-label">Features</div>
              <span class="pill">King size Bed</span>
              <span class="pill">Cove lighting</span>
            </div>
            <div class="pill-group">
              <div class="mini-label">Facilities</div>
              <span class="pill">Lounge seating</span>
              <span class="pill">5-G Wi-Fi</span>
            </div>
            <div class="guests-limit">
              <div class="mini-label">Guests Limit</div>
              <span class="pill">7 Adults</span>
              <span class="pill">3 Childrens</span>
            </div>
            <a href="#" class="btn btn-sm text-white custom-bg shadow-none rounded-pill px-3">Book Now</a>
          </div>
          <div class="list-card-image">
            <img src="images/lodge/2.jpeg" alt="The Panorama Suite">
            <div class="list-card-image-caption">
              <span class="lodge-tier">Premier</span>
              <h6>The Panorama Suite</h6>
              <span class="tap-hint"><i class="fa-solid fa-hand-pointer"></i> Tap to view details</span>
            </div>
            </div>
            </div>
      </div>
    </div>

    <!-- 3: The Regal Canopy Lodge -->
    <div class="lodge-item" data-price="18000" data-adults="8" data-children="6">
      <div class="list-card-wrap reveal">
        <div class="list-card-flip" data-flip="left">
          <div class="list-card-details">
            <button type="button" class="list-card-close" aria-label="Back to photo"><i class="fa-solid fa-image"></i></button>
            <span class="lodge-tier">Grand Reserve</span>
            <h5>The Regal Canopy Lodge</h5>
            <div class="price-line">₹18,000 – ₹23,000 per night</div>
            <p class="blurb">Grand Reserve indulgence with a private platform, canopy bed, and dedicated butler service.</p>
            <div class="pill-group">
              <div class="mini-label">Features</div>
              <span class="pill">Curved Floor Ceiling</span>
              <span class="pill">Canopy Poster bed</span>
            </div>
            <div class="pill-group">
              <div class="mini-label">Facilities</div>
              <span class="pill">Butler Service</span>
              <span class="pill">In room mini-bar</span>
            </div>
            <div class="guests-limit">
              <div class="mini-label">Guests Limit</div>
              <span class="pill">8 Adults</span>
              <span class="pill">6 Childrens</span>
            </div>
            <a href="#" class="btn btn-sm text-white custom-bg shadow-none rounded-pill px-3">Book Now</a>
          </div>
          <div class="list-card-image">
            <img src="images/lodge/3.jpeg" alt="The Regal Canopy Lodge">
            <div class="list-card-image-caption">
              <span class="lodge-tier">Grand Reserve</span>
              <h6>The Regal Canopy Lodge</h6>
              <span class="tap-hint"><i class="fa-solid fa-hand-pointer"></i> Tap to view details</span>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- 4: The Willow Brook Cabin -->
    <div class="lodge-item" data-price="4500" data-adults="4" data-children="2">
      <div class="list-card-wrap reveal">
        <div class="list-card-flip" data-flip="right">
          <div class="list-card-details">
            <button type="button" class="list-card-close" aria-label="Back to photo"><i class="fa-solid fa-image"></i></button>
            <span class="lodge-tier">Signature</span>
            <h5>The Willow Brook Cabin</h5>
            <div class="price-line">₹4,500 – ₹7,500 per night</div>
            <p class="blurb">A rustic wood-lined cabin with a quiet reading nook, perfect for a simple getaway.</p>
            <div class="pill-group">
              <div class="mini-label">Features</div>
              <span class="pill">Queen size Bed</span>
              <span class="pill">Rustic wood interiors</span>
            </div>
            <div class="pill-group">
              <div class="mini-label">Facilities</div>
              <span class="pill">High-speed Wi-Fi</span>
              <span class="pill">Air Conditioning</span>
            </div>
            <div class="guests-limit">
              <div class="mini-label">Guests Limit</div>
              <span class="pill">4 Adults</span>
              <span class="pill">2 Childrens</span>
            </div>
            <a href="#" class="btn btn-sm text-white custom-bg shadow-none rounded-pill px-3">Book Now</a>
          </div>
          <div class="list-card-image">
            <img src="images/lodge/4.jpg" alt="The Willow Brook Cabin">
            <div class="list-card-image-caption">
              <span class="lodge-tier">Signature</span>
              <h6>The Willow Brook Cabin</h6>
              <span class="tap-hint"><i class="fa-solid fa-hand-pointer"></i> Tap to view details</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- 5: The Meadow Vista Room -->
    <div class="lodge-item" data-price="6000" data-adults="5" data-children="3">
      <div class="list-card-wrap reveal">
        <div class="list-card-flip" data-flip="left">
          <div class="list-card-details">
            <button type="button" class="list-card-close" aria-label="Back to photo"><i class="fa-solid fa-image"></i></button>
            <span class="lodge-tier">Signature</span>
            <h5>The Meadow Vista Room</h5>
            <div class="price-line">₹6,000 – ₹8,500 per night</div>
            <p class="blurb">Garden-facing balcony room with a private sitting area overlooking open meadow.</p>
            <div class="pill-group">
              <div class="mini-label">Features</div>
              <span class="pill">King size Bed</span>
              <span class="pill">Garden facing balcony</span>
            </div>
            <div class="pill-group">
              <div class="mini-label">Facilities</div>
              <span class="pill">High-speed Wi-Fi</span>
              <span class="pill">Smart TV</span>
            </div>
            <div class="guests-limit">
              <div class="mini-label">Guests Limit</div>
              <span class="pill">5 Adults</span>
              <span class="pill">3 Childrens</span>
            </div>
            <a href="#" class="btn btn-sm text-white custom-bg shadow-none rounded-pill px-3">Book Now</a>
          </div>
          <div class="list-card-image">
            <img src="images/lodge/5.png" alt="The Meadow Vista Room">
            <div class="list-card-image-caption">
              <span class="lodge-tier">Signature</span>
              <h6>The Meadow Vista Room</h6>
              <span class="tap-hint"><i class="fa-solid fa-hand-pointer"></i> Tap to view details</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- 6: The Orchard View Suite -->
    <div class="lodge-item" data-price="9500" data-adults="6" data-children="4">
      <div class="list-card-wrap reveal">
        <div class="list-card-flip" data-flip="right">
          <div class="list-card-details">
            <button type="button" class="list-card-close" aria-label="Back to photo"><i class="fa-solid fa-image"></i></button>
            <span class="lodge-tier">Premier</span>
            <h5>The Orchard View Suite</h5>
            <div class="price-line">₹9,500 – ₹13,000 per night</div>
            <p class="blurb">Orchard-facing windows and a walk-in closet, with an in-room espresso setup.</p>
            <div class="pill-group">
              <div class="mini-label">Features</div>
              <span class="pill">King size Bed</span>
              <span class="pill">Orchard facing windows</span>
            </div>
            <div class="pill-group">
              <div class="mini-label">Facilities</div>
              <span class="pill">Lounge seating</span>
              <span class="pill">Espresso machine</span>
            </div>
            <div class="guests-limit">
              <div class="mini-label">Guests Limit</div>
              <span class="pill">6 Adults</span>
              <span class="pill">4 Childrens</span>
            </div>
            <a href="#" class="btn btn-sm text-white custom-bg shadow-none rounded-pill px-3">Book Now</a>
          </div>
          <div class="list-card-image">
            <img src="images/lodge/6.png" alt="The Orchard View Suite">
            <div class="list-card-image-caption">
              <span class="lodge-tier">Premier</span>
              <h6>The Orchard View Suite</h6>
              <span class="tap-hint"><i class="fa-solid fa-hand-pointer"></i> Tap to view details</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- 7: The Cellar Loft -->
    <div class="lodge-item" data-price="11000" data-adults="5" data-children="2">
      <div class="list-card-wrap reveal">
        <div class="list-card-flip" data-flip="left">
          <div class="list-card-details">
            <button type="button" class="list-card-close" aria-label="Back to photo"><i class="fa-solid fa-image"></i></button>
            <span class="lodge-tier">Premier</span>
            <h5>The Cellar Loft</h5>
            <div class="price-line">₹11,000 – ₹14,500 per night</div>
            <p class="blurb">A split-level loft with an exposed stone wall and a private balcony retreat.</p>
            <div class="pill-group">
              <div class="mini-label">Features</div>
              <span class="pill">Split level layout</span>
              <span class="pill">Private balcony</span>
            </div>
            <div class="pill-group">
              <div class="mini-label">Facilities</div>
              <span class="pill">In room mini-bar</span>
              <span class="pill">High-speed Wi-Fi</span>
            </div>
            <div class="guests-limit">
              <div class="mini-label">Guests Limit</div>
              <span class="pill">5 Adults</span>
              <span class="pill">2 Childrens</span>
            </div>
            <a href="#" class="btn btn-sm text-white custom-bg shadow-none rounded-pill px-3">Book Now</a>
          </div>
          <div class="list-card-image">
            <img src="images/lodge/7.png" alt="The Cellar Loft">
            <div class="list-card-image-caption">
              <span class="lodge-tier">Premier</span>
              <h6>The Cellar Loft</h6>
              <span class="tap-hint"><i class="fa-solid fa-hand-pointer"></i> Tap to view details</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- 8: The Vineyard Terrace Lodge -->
    <div class="lodge-item" data-price="16000" data-adults="6" data-children="4">
      <div class="list-card-wrap reveal">
        <div class="list-card-flip" data-flip="right">
          <div class="list-card-details">
            <button type="button" class="list-card-close" aria-label="Back to photo"><i class="fa-solid fa-image"></i></button>
            <span class="lodge-tier">Grand Reserve</span>
            <h5>The Vineyard Terrace Lodge</h5>
            <div class="price-line">₹16,000 – ₹20,000 per night</div>
            <p class="blurb">Private vineyard terrace living with a soaking tub and full butler service.</p>
            <div class="pill-group">
              <div class="mini-label">Features</div>
              <span class="pill">Private vineyard terrace</span>
              <span class="pill">Soaking tub</span>
            </div>
            <div class="pill-group">
              <div class="mini-label">Facilities</div>
              <span class="pill">Butler Service</span>
              <span class="pill">In room mini-bar</span>
            </div>
            <div class="guests-limit">
              <div class="mini-label">Guests Limit</div>
              <span class="pill">6 Adults</span>
              <span class="pill">4 Childrens</span>
            </div>
            <a href="#" class="btn btn-sm text-white custom-bg shadow-none rounded-pill px-3">Book Now</a>
          </div>
          <div class="list-card-image">
            <img src="images/lodge/8.png" alt="The Vineyard Terrace Lodge">
            <div class="list-card-image-caption">
              <span class="lodge-tier">Grand Reserve</span>
              <h6>The Vineyard Terrace Lodge</h6>
              <span class="tap-hint"><i class="fa-solid fa-hand-pointer"></i> Tap to view details</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- 9: The Harvest Moon Retreat -->
    <div class="lodge-item" data-price="20000" data-adults="10" data-children="6">
      <div class="list-card-wrap reveal">
        <div class="list-card-flip" data-flip="left">
          <div class="list-card-details">
            <button type="button" class="list-card-close" aria-label="Back to photo"><i class="fa-solid fa-image"></i></button>
            <span class="lodge-tier">Grand Reserve</span>
            <h5>The Harvest Moon Retreat</h5>
            <div class="price-line">₹20,000 – ₹26,000 per night</div>
            <p class="blurb">Our largest retreat, a multi-room stay built for bigger families and gatherings.</p>
            <div class="pill-group">
              <div class="mini-label">Features</div>
              <span class="pill">Multi-room retreat</span>
              <span class="pill">Canopy Poster bed</span>
            </div>
            <div class="pill-group">
              <div class="mini-label">Facilities</div>
              <span class="pill">Butler Service</span>
              <span class="pill">Private dining setup</span>
            </div>
            <div class="guests-limit">
              <div class="mini-label">Guests Limit</div>
              <span class="pill">10 Adults</span>
              <span class="pill">6 Childrens</span>
            </div>
            <a href="#" class="btn btn-sm text-white custom-bg shadow-none rounded-pill px-3">Book Now</a>
          </div>
          <div class="list-card-image">
            <img src="images/lodge/9.png" alt="The Harvest Moon Retreat">
            <div class="list-card-image-caption">
              <span class="lodge-tier">Grand Reserve</span>
              <h6>The Harvest Moon Retreat</h6>
              <span class="tap-hint"><i class="fa-solid fa-hand-pointer"></i> Tap to view details</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- 10: The Garden Folly Cottage -->
    <div class="lodge-item" data-price="5500" data-adults="4" data-children="3">
      <div class="list-card-wrap reveal">
        <div class="list-card-flip" data-flip="right">
          <div class="list-card-details">
            <button type="button" class="list-card-close" aria-label="Back to photo"><i class="fa-solid fa-image"></i></button>
            <span class="lodge-tier">Signature</span>
            <h5>The Garden Folly Cottage</h5>
            <div class="price-line">₹5,500 – ₹8,000 per night</div>
            <p class="blurb">A cottage-style stay with a garden patio, ideal for a slower kind of weekend.</p>
            <div class="pill-group">
              <div class="mini-label">Features</div>
              <span class="pill">Cottage style interiors</span>
              <span class="pill">Garden facing patio</span>
            </div>
            <div class="pill-group">
              <div class="mini-label">Facilities</div>
              <span class="pill">High-speed Wi-Fi</span>
              <span class="pill">Tea station</span>
            </div>
            <div class="guests-limit">
              <div class="mini-label">Guests Limit</div>
              <span class="pill">4 Adults</span>
              <span class="pill">3 Childrens</span>
            </div>
            <a href="#" class="btn btn-sm text-white custom-bg shadow-none rounded-pill px-3">Book Now</a>
          </div>
          <div class="list-card-image">
            <img src="images/lodge/10.png" alt="The Garden Folly Cottage">
            <div class="list-card-image-caption">
              <span class="lodge-tier">Signature</span>
              <h6>The Garden Folly Cottage</h6>
              <span class="tap-hint"><i class="fa-solid fa-hand-pointer"></i> Tap to view details</span>
            </div>
          </div>
        </div>
      </div>
    </div>

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

/* ---------- Lodge filters  ---------- */
(function(){
  var form = document.getElementById('lodgeFilterForm');
  var lodgeItems = Array.prototype.slice.call(document.querySelectorAll('.lodge-item'));
  var totalCount = lodgeItems.length;
  var noResultsMsg = document.getElementById('noResultsMsg');
  var resultsNote = document.getElementById('filterResultsNote');
  var checkinInput = document.getElementById('filterCheckin');
  var checkoutInput = document.getElementById('filterCheckout');
  var resetBtn = document.getElementById('filterResetBtn');

  function applyFilters(e){
    if (e) e.preventDefault();

    if (checkinInput.value && checkoutInput.value && checkoutInput.value <= checkinInput.value) {
      checkoutInput.setCustomValidity('Check-out must be after check-in');
      checkoutInput.reportValidity();
      return;
    }
    checkoutInput.setCustomValidity('');

    var adults = parseInt(document.getElementById('filterAdults').value, 10) || 0;
    var children = parseInt(document.getElementById('filterChildren').value, 10) || 0;
    var minPrice = parseFloat(document.getElementById('filterMinPrice').value);
    var maxPrice = parseFloat(document.getElementById('filterMaxPrice').value);
    var visibleCount = 0;

    lodgeItems.forEach(function(item){
      var price = parseFloat(item.getAttribute('data-price'));
      var itemAdults = parseInt(item.getAttribute('data-adults'), 10);
      var itemChildren = parseInt(item.getAttribute('data-children'), 10);

      var matches = true;
      if (adults > 0 && itemAdults < adults) matches = false;
      if (children > 0 && itemChildren < children) matches = false;
      if (!isNaN(minPrice) && price < minPrice) matches = false;
      if (!isNaN(maxPrice) && price > maxPrice) matches = false;

      item.classList.toggle('d-none', !matches);
      if (matches) visibleCount++;
    });

    noResultsMsg.classList.toggle('d-none', visibleCount !== 0);
    resultsNote.innerHTML = 'Showing <strong>' + visibleCount + '</strong> of <strong>' + totalCount + '</strong> lodges';
  }

  function resetFilters(){
    form.reset();
    checkoutInput.setCustomValidity('');
    lodgeItems.forEach(function(item){ item.classList.remove('d-none'); });
    noResultsMsg.classList.add('d-none');
    resultsNote.innerHTML = 'Showing <strong>' + totalCount + '</strong> of <strong>' + totalCount + '</strong> lodges';
  }

  form.addEventListener('submit', applyFilters);
  resetBtn.addEventListener('click', resetFilters);
})();
</script>

</body>
</html>