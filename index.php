<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Évangéline Grand</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="common.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Cinzel+Decorative:wght@700&family=Cormorant+SC:wght@600&family=DM+Serif+Display:ital@0;1&family=Fraunces:ital,wght@0,600;1,600&family=Great+Vibes&family=Tenor+Sans&family=UnifrakturCook:wght@700&display=swap" rel="stylesheet">
   <style>

   .hero-swiper .swiper-slide img{
    height: 480px;
    object-fit: cover;
    }

   .availability-form{
        margin-top: -90px;
        z-index: 2;
        position: relative;
    }

    @media screen and (max-width: 575px){
        .hero-swiper .swiper-slide img{
            height: 260px;
        }
        .availability-form{
            margin-top: -40px;
        }
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

    .card{
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    }

    .lodge-hover{
      transition: transform .25s ease, box-shadow .25s ease;
    }

    .lodge-hover:hover{
      transform: translateY(-6px);
      box-shadow: 0 16px 32px rgba(0,0,0,0.15) !important;
    }

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
      background: #fff;
      border-radius: .375rem;
      box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);
      padding: 2rem 1rem;
      text-align: center;
      transition: box-shadow .25s ease;
    }

    .convenience-card:hover{
      box-shadow: 0 8px 20px rgba(0,0,0,.15);
    }

    .convenience-card i{
      font-size: 34px;
      color: #293462;
      margin-bottom: 10px;
      display: inline-block;
    }

    .convenience-card h5{
      font-size: 14px;
      font-weight: 500;
      color: #333;
      margin-bottom: 0;
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

    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-lg sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand me-3 fw-bold fs-3 nav-font" href="index.php">Évangéline Grand</a>
    <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active me-1" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-1" href="#">Lodges</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-1" href="#">Comforts</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-1" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>
      <div class="d-flex">
        <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-3" data-bs-toggle="modal" data-bs-target="#signupModal">
          Signup
        </button>
        <button type="button" class="btn btn-outline-dark shadow-none" data-bs-toggle="modal" data-bs-target="#loginModal">
          Login
        </button>
      </div>
    </div>
  </div>
</nav>

<div class="modal fade" id="signupModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form>
        <div class="modal-header">
          <h5 class="modal-title d-flex align-items-center">
            <i class="bi bi-person-plus-fill fs-3 me-2"></i>User Signup
          </h5>
          <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
            Note: Your details must match with your ID (Aadhar card, Passport, Driving license, Voter ID, etc.) that will be required during check-in.
          </span>

          <div class="container-fluid">
            <div class="row">

              <div class="col-md-6 mb-3">
                <label class="form-label">User Name</label>
                <input type="text" class="form-control shadow-none">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-control shadow-none">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Phone Number</label>
                <input type="tel" class="form-control shadow-none">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">User Picture</label>
                <input type="file" class="form-control shadow-none">
              </div>

              <div class="col-md-12 mb-3">
                <label class="form-label">Communication Address</label>
                <textarea class="form-control shadow-none" rows="1"></textarea>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Pin Code</label>
                <input type="number" class="form-control shadow-none">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Date Of Birth</label>
                <input type="date" class="form-control shadow-none">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Account Password</label>
                <input type="password" class="form-control shadow-none">
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" class="form-control shadow-none">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-center border-0 pt-0">
          <button type="submit" class="btn btn-dark shadow-none px-4">Register</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form>
         <div class="modal-header">
        <h5 class="modal-title d-flex align-items-center">
        <i class="bi bi-person-circle fs-3 me-2"></i>User Login</h5>
        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
         <label class="form-label">Email address</label>
         <input type="email" class="form-control shadow-none">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
      </div>
       <div class="mb-4">
         <label class="form-label">Password</label>
         <input type="password" class="form-control shadow-none">
      </div>
      <div class="d-flex align-items-center justify-content-between mb-2">
        <button type="submit" class="btn btn-dark shadow-none">Submit</button>
        <a href="javascript: void(0)" class="text-secondary text-decoration-none">Forgot Password?</a>
      </div>
      </div>
      </form>
    </div>
  </div>
</div>

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

<div class="container availability-form">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="bg-white shadow p-4 rounded">
        <h5 class="mb-4">Check Lodge Availability</h5>
        <form>
          <div class="row align-items-end availability-row">

            <div class="field-checkin mb-3">
              <label class="form-label" style="font-weight: 500;">Check-In</label>
              <input type="date" class="form-control shadow-none">
            </div>

            <div class="field-checkout mb-3">
              <label class="form-label" style="font-weight: 500;">Check-Out</label>
              <input type="date" class="form-control shadow-none">
            </div>

            <div class="field-children mb-3">
              <label class="form-label" style="font-weight: 500;">Children</label>
              <select class="form-select shadow-none">
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
                <option value="4">Four</option>
              </select>
            </div>

            <div class="field-adult mb-3">
              <label class="form-label" style="font-weight: 500;">Adult</label>
              <select class="form-select shadow-none">
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
                <option value="4">Four</option>
              </select>
            </div>

            <div class="field-submit mb-3">
              <button type="submit" class="btn text-white shadow-none custom-bg w-100">Submit</button>
            </div>

          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<h2 class="mt-5 pt-4 mb-4 text-center fw-bold section-font">OUR LODGES</h2>

<div class="container">
 <div class="row">
   <div class="col-lg-4 col-md-6 my-3">
    <div class="card border-0 shadow lodge-hover" style="max-width: 350px; margin: auto;">
      <img src="images/lodge/1.jpeg" class="card-img-top" alt="lodge1">
      <div class="card-body text-center">
        <h5>The Nirvana Pavilion</h5>
        <h6 class="mb-4"> ₹5,000 – ₹9,000 per night</h6>
         <div class="rating mb-4">
          <h6 class="mb-1">Rating:</h6>
         <span class="badge rounded-pill bg-light text-dark text-wrap">
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
         </span>
        </div>
        <div class="features mb-4">
          <h6 class="mb-1">Features:</h6>
          <span class="badge rounded-pill bg-light text-dark text-wrap">
           Spacious Deluxe Rooms
          </span>
          <span class="badge rounded-pill bg-light text-dark text-wrap">
            King size Bed
          </span>
           <span class="badge rounded-pill bg-light text-dark text-wrap">
            Private Bathroom
          </span>
           <span class="badge rounded-pill bg-light text-dark text-wrap">
            Wardrobe and closet
          </span>
        </div>
        <div class="facilities mb-4">
           <h6 class="mb-1">Facilities:</h6>
            <span class="badge rounded-pill bg-light text-dark text-wrap">
           High-speed Wi-Fi
          </span>
          <span class="badge rounded-pill bg-light text-dark text-wrap">
           Air Conditioning
          </span>
          <span class="badge rounded-pill bg-light text-dark text-wrap">
            Streaming Smart TV
          </span>
           <span class="badge rounded-pill bg-light text-dark text-wrap">
            Work Desk and Chair
          </span>
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
      <img src="images/lodge/2.jpeg" class="card-img-top" alt="lodge1">
      <div class="card-body text-center">
        <h5>The Panorama Suite</h5>
        <h6 class="mb-4"> ₹10,000 – ₹15,000 per night</h6>
         <div class="rating mb-4">
          <h6 class="mb-1">Rating:</h6>
         <span class="badge rounded-pill bg-light text-dark text-wrap">
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star half text-warning"></i>
         </span>
        </div>
        <div class="features mb-4">
          <h6 class="mb-1">Features:</h6>
          <span class="badge rounded-pill bg-light text-dark text-wrap">
            King size Bed
          </span>
          <span class="badge rounded-pill bg-light text-dark text-wrap">
            Cove lighting
          </span>
           <span class="badge rounded-pill bg-light text-dark text-wrap">
            Dual view windows
          </span>
           <span class="badge rounded-pill bg-light text-dark text-wrap">
            Cushioned bench seating
          </span>
        </div>
        <div class="facilities mb-4">
           <h6 class="mb-1">Facilities:</h6>
            <span class="badge rounded-pill bg-light text-dark text-wrap">
           Lounge area with seating
          </span>
          <span class="badge rounded-pill bg-light text-dark text-wrap">
            5-G Wi-Fi
          </span>
          <span class="badge rounded-pill bg-light text-dark text-wrap">
            Air Conditioning
          </span>
           <span class="badge rounded-pill bg-light text-dark text-wrap">
            Glass top coffee table
          </span>
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
      <img src="images/lodge/3.jpeg" class="card-img-top" alt="lodge1">
      <div class="card-body text-center">
        <h5>The Regal Canopy Lodge</h5>
        <h6 class="mb-4"> ₹18,000 – ₹23,000 per night</h6>
         <div class="rating mb-4">
          <h6 class="mb-1">Rating:</h6>
         <span class="badge rounded-pill bg-light text-dark text-wrap">
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-half text-warning"></i>
         </span>
        </div>
        <div class="features mb-4">
          <h6 class="mb-1">Features:</h6>
          <span class="badge rounded-pill bg-light text-dark text-wrap">
           Curved Floor Ceiling
          </span>
          <span class="badge rounded-pill bg-light text-dark text-wrap">
           Elevated private platform
          </span>
           <span class="badge rounded-pill bg-light text-dark text-wrap">
           Four poster canopy bed
          </span>
           <span class="badge rounded-pill bg-light text-dark text-wrap">
           Mirror paneled accent wall
          </span>
        </div>
        <div class="facilities mb-4">
           <h6 class="mb-1">Facilities:</h6>
            <span class="badge rounded-pill bg-light text-dark text-wrap">
          Special Butler Service
          </span>
          <span class="badge rounded-pill bg-light text-dark text-wrap">
           Round designer coffee table
          </span>
          <span class="badge rounded-pill bg-light text-dark text-wrap">
            In room mini-bar
          </span>
           <span class="badge rounded-pill bg-light text-dark text-wrap">
            High-speed Wi-Fi
          </span>
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

<h2 class="mt-5 pt-4 mb-4 text-center fw-bold section-font">OUR CONVENIENCE</h2>

<div class="container mt-5">
  <div class="convenience-row">
    <div class="convenience-card">
      <i class="fa-solid fa-mug-saucer"></i>
      <h5 class="mt-3">Complimentary breakfast</h5>
    </div>
    <div class="convenience-card">
      <i class="fa-solid fa-charging-station"></i>
      <h5 class="mt-3">EV Charging Station</h5>
    </div>
    <div class="convenience-card">
      <i class="fa-solid fa-video"></i>
      <h5 class="mt-3">24/7 security & CCTV</h5>
    </div>
    <div class="convenience-card">
      <i class="fa-solid fa-people-group"></i>
      <h5 class="mt-3">Conference/banquet halls</h5>
    </div>
    <div class="convenience-card">
      <i class="fa-solid fa-shirt"></i>
      <h5 class="mt-3">Laundry service</h5>
    </div>
    <div class="convenience-card">
      <i class="fa-solid fa-martini-glass-citrus"></i>
      <h5 class="mt-3">Rooftop Bar</h5>
    </div>
    <div class="convenience-card">
      <i class="fa-solid fa-water-ladder"></i>
      <h5 class="mt-3">Swimming pool & spa</h5>
    </div>
  </div>
</div>

<h2 class="mt-5 pt-4 mb-4 text-center fw-bold section-font">TESTIMONIALS</h2>

<div class="container">
  <div class="d-flex justify-content-center mb-3">
    <div class="swiper-pagination position-static"></div>
  </div>

  <div class="swiper swiper-testimonials position-relative">
    <div class="swiper-wrapper">

      <div class="swiper-slide bg-white p-4 text-center">
        <div class="d-flex align-items-center justify-content-center mb-3">
          <img src="images/testimonials/1.jpeg" width="40" class="rounded-circle">
          <h6 class="mb-0 ms-2">Random User1</h6>
        </div>
        <p class="mb-3">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum animi debitis nemo?
        </p>
        <div class="rating">
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-half text-warning"></i>
        </div>
      </div>

      <div class="swiper-slide bg-white p-4 text-center">
        <div class="d-flex align-items-center justify-content-center mb-3">
          <img src="images/testimonials/1.jpeg" width="40" class="rounded-circle">
          <h6 class="mb-0 ms-2">Random User2</h6>
        </div>
        <p class="mb-3">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum animi debitis nemo?
        </p>
        <div class="rating">
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-half text-warning"></i>
        </div>
      </div>

      <div class="swiper-slide bg-white p-4 text-center">
        <div class="d-flex align-items-center justify-content-center mb-3">
          <img src="images/testimonials/1.jpeg" width="40" class="rounded-circle">
          <h6 class="mb-0 ms-2">Random User3</h6>
        </div>
        <p class="mb-3">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum animi debitis nemo?
        </p>
        <div class="rating">
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-half text-warning"></i>
        </div>
      </div>

        <div class="swiper-slide bg-white p-4 text-center">
        <div class="d-flex align-items-center justify-content-center mb-3">
          <img src="images/testimonials/1.jpeg" width="40" class="rounded-circle">
          <h6 class="mb-0 ms-2">Random User4</h6>
        </div>
        <p class="mb-3">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum animi debitis nemo?
        </p>
        <div class="rating">
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-half text-warning"></i>
        </div>
      </div>

        <div class="swiper-slide bg-white p-4 text-center">
        <div class="d-flex align-items-center justify-content-center mb-3">
          <img src="images/testimonials/1.jpeg" width="40" class="rounded-circle">
          <h6 class="mb-0 ms-2">Random User5</h6>
        </div>
        <p class="mb-3">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum animi debitis nemo?
        </p>
        <div class="rating">
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-half text-warning"></i>
        </div>
      </div>

        <div class="swiper-slide bg-white p-4 text-center">
        <div class="d-flex align-items-center justify-content-center mb-3">
          <img src="images/testimonials/1.jpeg" width="40" class="rounded-circle">
          <h6 class="mb-0 ms-2">Random User6</h6>
        </div>
        <p class="mb-3">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum animi debitis nemo?
        </p>
        <div class="rating">
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-half text-warning"></i>
        </div>
      </div>

        <div class="swiper-slide bg-white p-4 text-center">
        <div class="d-flex align-items-center justify-content-center mb-3">
          <img src="images/testimonials/1.jpeg" width="40" class="rounded-circle">
          <h6 class="mb-0 ms-2">Random User7</h6>
        </div>
        <p class="mb-3">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum animi debitis nemo?
        </p>
        <div class="rating">
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-half text-warning"></i>
        </div>
      </div>

        <div class="swiper-slide bg-white p-4 text-center">
        <div class="d-flex align-items-center justify-content-center mb-3">
          <img src="images/testimonials/1.jpeg" width="40" class="rounded-circle">
          <h6 class="mb-0 ms-2">Random User8</h6>
        </div>
        <p class="mb-3">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum animi debitis nemo?
        </p>
        <div class="rating">
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-half text-warning"></i>
        </div>
      </div>

        <div class="swiper-slide bg-white p-4 text-center">
        <div class="d-flex align-items-center justify-content-center mb-3">
          <img src="images/testimonials/1.jpeg" width="40" class="rounded-circle">
          <h6 class="mb-0 ms-2">Random User9</h6>
        </div>
        <p class="mb-3">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum animi debitis nemo?
        </p>
        <div class="rating">
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-fill text-warning"></i>
          <i class="bi bi-star-half text-warning"></i>
        </div>
      </div>

    </div>
  </div>
</div>

  <div class="col-lg-12 text-center mt-5">
    <a href="#" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none rounded-pill px-3">Know About More ></a>
   </div>

<h2 class="mt-5 pt-4 mb-4 text-center fw-bold section-font">LOCATE US</h2>

<div class="container">
  <div class="row">
    <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded-100">
      <iframe class="w-100 rounded" height="400" 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2816.1670154276353!2d-64.30946076511229!3d45.10268230000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4b58559db9646275%3A0xcca6eaa98adc0353!2sThe%20Evangeline%20Hotel!5e0!3m2!1sen!2sin!4v1784649732488!5m2!1sen!2sin" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
    <div class="col-lg-4 col-md-4">
      <div class="bg-white p-4 rounded mb-4">
        <h5>Call Us</h5>
        <a href=tel: +19026972335 class="d-inline-block mb-2 text-decoration-none text-dark">
        <i class="bi bi-telephone-outbound-fill"></i> +919016588906
        </a>
        <br>
        <a href=tel: +19026972335 class="d-inline-block mb-2 text-decoration-none text-dark">
        <i class="bi bi-telephone-outbound-fill"></i> +919016588906
        </a>
      </div>
      <div class="bg-white p-4 rounded mb-4">
        <h5>Follow Us</h5>
        <a href=# class="d-inline-block mb-3">
        <span class="badge bg-light text-dark fs-6 p-2">
          <i class="bi bi-instagram"></i> Instagram
        </a>
        <br>
        <a href=# class="d-inline-block mb-3">
        <span class="badge bg-light text-dark fs-6 p-2">
          <i class="bi bi-facebook me-1"></i> Facebook
        </a>
        <br>
        <a href=# class="d-inline-block mb-3">
        <span class="badge bg-light text-dark fs-6 p-2">
          <i class="bi bi-youtube"></i> Youtube
        </a>
        <br>
        <a href=# class="d-inline-block">
        <span class="badge bg-light text-dark fs-6 p-2">
         <i class="bi bi-twitter-x"></i> X (Formally Twitter)
        </a>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid bg-white mt-5">
 <div class="row">
   <div class="col-lg-4 p4">
     <h3 class="h-font fw-bold fs-3 mb-2">Évangéline Grand</h3>
     <p>The perfect mix of reliable comfort and warm,
        genuine hospitality. Our peaceful lodges
        give you exactly what you need for a restful night's sleep.
   </div>
   <div class="col-lg-4 p4">
     <h5 class="mb-3">Quick Links</h5>
      <a href="#" class="d-inline-block mb-2 text-dark text-decoration-none">Home</a><br>
      <a href="#" class="d-inline-block mb-2 text-dark text-decoration-none">Lodges</a><br>
      <a href="#" class="d-inline-block mb-2 text-dark text-decoration-none">Comforts</a><br>
      <a href="#" class="d-inline-block mb-2 text-dark text-decoration-none">About</a><br>
      <a href="#" class="d-inline-block mb-2 text-dark text-decoration-none">Contact</a><br>
   </div>
   <div class="col-lg-4 p4">
      <h5 class="mb-3">Follow Us</h5>
        <a href="#" class="d-inline-block mb-2 text-dark text-decoration-none">
          <i class="bi bi-instagram"></i> Instagram
        </a><br>
        <a href="#" class="d-inline-block mb-2 text-dark text-decoration-none">
          <i class="bi bi-facebook me-1"></i> Facebook
        </a><br>
        <a href="#" class="d-inline-block mb-2 text-dark text-decoration-none">
          <i class="bi bi-youtube"></i> Youtube
        </a><br>
        <a href="#" class="d-inline-block text-dark text-decoration-none">
          <i class="bi bi-twitter-x"></i> X (Formally Twitter)
        </a><br>
   </div>
 </div>
</div>

<h6 class="text-center bg-dark text-white p-3 m-0">© 2026 Évangéline Grand. All rights reserved.</h6>

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

var swiper = new Swiper('.swiper-testimonials', {
  effect: 'coverflow',
  grabCursor: true,
  centeredSlides: true,
  slidesPerView: 'auto',
  loop: true,
  initialSlide: 0,
  coverflowEffect: {
    rotate: 50,
    stretch: 0,
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
</script>

</body>
</html>