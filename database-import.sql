-- Évangéline Grand: database for HOSTED MySQL (every table has its primary key inside CREATE TABLE,
-- which Aiven requires). Structure = schema v3; data = your own export of 7 Oct 2026.
SET NAMES utf8mb4;

CREATE TABLE `admin_cred` (
  `sr_no`      INT(11) NOT NULL AUTO_INCREMENT,
  `admin_mail` VARCHAR(150) NOT NULL,
  `admin_pass` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`sr_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `site_settings` (
  `setting_key`   VARCHAR(60) NOT NULL,
  `setting_value` TEXT NOT NULL,
  PRIMARY KEY (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `hero_slides` (
  `id`         INT(11) NOT NULL AUTO_INCREMENT,
  `image`      VARCHAR(255) NOT NULL,
  `caption`    VARCHAR(150) NOT NULL DEFAULT '',
  `is_active`  TINYINT(1) NOT NULL DEFAULT 1,
  `sort_order` INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `lodges` (
  `id`           INT(11) NOT NULL AUTO_INCREMENT,
  `name`         VARCHAR(120) NOT NULL,
  `tier`         VARCHAR(60) NOT NULL DEFAULT '',
  `blurb`        TEXT,
  `price_min`    INT(11) NOT NULL DEFAULT 0,
  `price_max`    INT(11) DEFAULT NULL,
  `rating`       DECIMAL(2,1) DEFAULT NULL,
  `features`     TEXT,
  `facilities`   TEXT,
  `max_adults`   INT(11) NOT NULL DEFAULT 2,
  `max_children` INT(11) NOT NULL DEFAULT 0,
  `units`        INT(11) NOT NULL DEFAULT 1,
  `image`        VARCHAR(255) NOT NULL,
  `show_on_home` TINYINT(1) NOT NULL DEFAULT 0,
  `is_active`    TINYINT(1) NOT NULL DEFAULT 1,
  `sort_order`   INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `comforts` (
  `id`           INT(11) NOT NULL AUTO_INCREMENT,
  `section`      VARCHAR(20) NOT NULL DEFAULT 'card',
  `title`        VARCHAR(120) NOT NULL,
  `description`  TEXT,
  `tag`          VARCHAR(60) NOT NULL DEFAULT '',
  `icon`         VARCHAR(80) NOT NULL DEFAULT '',
  `image`        VARCHAR(255) NOT NULL,
  `show_on_home` TINYINT(1) NOT NULL DEFAULT 0,
  `is_active`    TINYINT(1) NOT NULL DEFAULT 1,
  `sort_order`   INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `team_members` (
  `id`         INT(11) NOT NULL AUTO_INCREMENT,
  `name`       VARCHAR(100) NOT NULL,
  `role`       VARCHAR(100) NOT NULL,
  `note`       VARCHAR(300) NOT NULL DEFAULT '',
  `icon`       VARCHAR(80) NOT NULL DEFAULT 'fa-solid fa-user',
  `image`      VARCHAR(255) NOT NULL,
  `sort_order` INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `testimonials` (
  `id`         INT(11) NOT NULL AUTO_INCREMENT,
  `name`       VARCHAR(100) NOT NULL,
  `review`     TEXT NOT NULL,
  `rating`     TINYINT(4) NOT NULL DEFAULT 5,
  `is_active`  TINYINT(1) NOT NULL DEFAULT 1,
  `sort_order` INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `contact_messages` (
  `id`         INT(11) NOT NULL AUTO_INCREMENT,
  `name`       VARCHAR(100) NOT NULL,
  `email`      VARCHAR(150) NOT NULL,
  `subject`    VARCHAR(200) NOT NULL,
  `message`    TEXT NOT NULL,
  `is_read`    TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `users` (
  `id`            INT(11) NOT NULL AUTO_INCREMENT,
  `name`          VARCHAR(100) NOT NULL,
  `email`         VARCHAR(150) NOT NULL,
  `phone`         VARCHAR(25)  NOT NULL DEFAULT '',
  `address`       VARCHAR(300) NOT NULL DEFAULT '',
  `pincode`       VARCHAR(12)  NOT NULL DEFAULT '',
  `dob`           DATE DEFAULT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `picture`       VARCHAR(255) DEFAULT NULL,
  `is_active`     TINYINT(1)   NOT NULL DEFAULT 1,
  `created_at`    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login_at` DATETIME     DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `password_resets` (
  `id`         INT(11) NOT NULL AUTO_INCREMENT,
  `user_id`    INT(11) NOT NULL,
  `token_hash` CHAR(64) NOT NULL,
  `expires_at` DATETIME NOT NULL,
  `used_at`    DATETIME DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_token` (`token_hash`),
  KEY `idx_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id`         INT(11) NOT NULL AUTO_INCREMENT,
  `ip`         VARCHAR(45)  NOT NULL,
  `email`      VARCHAR(150) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_ip` (`ip`, `created_at`),
  KEY `idx_email` (`email`, `created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `bookings` (
  `id`               INT(11) NOT NULL AUTO_INCREMENT,
  `ref`              VARCHAR(20) NOT NULL,
  `user_id`          INT(11) DEFAULT NULL,
  `lodge_id`         INT(11) DEFAULT NULL,
  `lodge_name`       VARCHAR(120) NOT NULL,
  `check_in`         DATE NOT NULL,
  `check_out`        DATE NOT NULL,
  `nights`           INT(11) NOT NULL,
  `adults`           INT(11) NOT NULL DEFAULT 1,
  `children`         INT(11) NOT NULL DEFAULT 0,
  `std_nights`       INT(11) NOT NULL DEFAULT 0,
  `peak_nights`      INT(11) NOT NULL DEFAULT 0,
  `std_rate`         INT(11) NOT NULL DEFAULT 0,
  `peak_rate`        INT(11) NOT NULL DEFAULT 0,
  `subtotal`         INT(11) NOT NULL DEFAULT 0,
  `tax_percent`      DECIMAL(5,2) NOT NULL DEFAULT 0,
  `tax_amount`       INT(11) NOT NULL DEFAULT 0,
  `total`            INT(11) NOT NULL DEFAULT 0,
  `special_requests` TEXT,
  `status`           VARCHAR(12) NOT NULL DEFAULT 'pending',
  `source`           VARCHAR(10) NOT NULL DEFAULT 'online',
  `guest_name`       VARCHAR(100) NOT NULL DEFAULT '',
  `guest_email`      VARCHAR(150) NOT NULL DEFAULT '',
  `guest_phone`      VARCHAR(25)  NOT NULL DEFAULT '',
  `admin_note`       TEXT,
  `cancelled_by`     VARCHAR(10) DEFAULT NULL,
  `created_at`       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_ref` (`ref`),
  KEY `idx_lodge_dates` (`lodge_id`, `status`, `check_in`, `check_out`),
  KEY `idx_user` (`user_id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `email_log` (
  `id`         INT(11) NOT NULL AUTO_INCREMENT,
  `to_email`   VARCHAR(150) NOT NULL,
  `subject`    VARCHAR(200) NOT NULL,
  `body`       TEXT NOT NULL,
  `status`     VARCHAR(10) NOT NULL DEFAULT 'queued',
  `error`      VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `user_tokens` (
  `id`         INT(11) NOT NULL AUTO_INCREMENT,
  `user_id`    INT(11) NOT NULL,
  `selector`   CHAR(18) NOT NULL,
  `token_hash` CHAR(64) NOT NULL,
  `expires_at` DATETIME NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_selector` (`selector`),
  KEY `idx_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `admin_cred` (`sr_no`, `admin_mail`, `admin_pass`) VALUES
(1, 'admin.evangelinegrand.com', '$2y$10$3OxzvtmTpNDi1bUZAeHXreP6.PeKZlNKH7rO51mNqs65qKo4TpTtO');

INSERT INTO `comforts` (`id`, `section`, `title`, `description`, `tag`, `icon`, `image`, `show_on_home`, `is_active`, `sort_order`) VALUES
(1, 'card', 'Complimentary Breakfast', 'A curated morning spread served daily, from fresh local produce to warm pastries, included with every stay.', '', 'fa-solid fa-mug-saucer', 'images/comforts/breakfast.jpeg', 1, 1, 1),
(2, 'card', 'EV Charging Station', 'On-site charging points for electric vehicles, so your stay stays effortless whichever way you arrived.', '', 'fa-solid fa-charging-station', 'images/comforts/charge.jpeg', 1, 1, 2),
(3, 'card', '24/7 Security & CCTV', 'Round-the-clock monitoring and on-property security, so you can rest easy at every hour.', '', 'fa-solid fa-video', 'images/comforts/security.jpeg', 1, 1, 3),
(4, 'card', 'Conference & Banquet Halls', 'Elegant event spaces suited for intimate gatherings or larger celebrations, fully serviced on request.', '', 'fa-solid fa-people-group', 'images/comforts/hall.jpeg', 1, 1, 4),
(5, 'card', 'Laundry Service', 'Same-day laundry and pressing, handled with care so you always travel light.', '', 'fa-solid fa-shirt', 'images/comforts/laundry.jpeg', 1, 1, 5),
(6, 'card', 'Rooftop Bar', 'Handcrafted cocktails and valley views, open every evening for a slower kind of night.', '', 'fa-solid fa-martini-glass-citrus', 'images/comforts/rooftop.jpeg', 1, 1, 6),
(7, 'card', 'Concierge Desk', 'From dinner reservations to local excursions, our concierge is on hand daily to plan the details.', '', 'fa-solid fa-bell-concierge', 'images/comforts/desk.jpeg', 0, 1, 7),
(8, 'card', 'Valet Parking', 'Complimentary valet on arrival, so your stay begins the moment you step out of the car.', '', 'fa-solid fa-car', 'images/comforts/parking.jpeg', 0, 1, 8),
(9, 'card', 'Pet-Friendly Stays', 'Select rooms welcome your companions, with bedding and bowls ready before you arrive.', '', 'fa-solid fa-paw', 'images/comforts/pet.jpeg', 0, 1, 9),
(10, 'signature', 'Swimming Pool & Spa', 'An open-air pool framed by the valley, paired with a spa menu built around slow, restorative treatments. Whether it\'s a sunrise swim or an evening massage, this is where the pace of the day finally softens.', 'Wellness', 'fa-solid fa-water-ladder', 'images/comforts/swimpool.jpeg', 1, 1, 10),
(11, 'signature', 'Dedicated Butler Service', 'Available to our Grand Reserve guests, our butlers handle everything from unpacking to late-night requests, quietly and without ceremony, so your stay feels attended to rather than managed.', 'Personal Service', 'fa-solid fa-user-tie', 'images/comforts/butlerservice.jpeg', 0, 1, 11);

INSERT INTO `hero_slides` (`id`, `image`, `caption`, `is_active`, `sort_order`) VALUES
(1, 'images/crousel/1.jpeg', 'Slide 1', 1, 1),
(2, 'images/crousel/2.jpeg', 'Slide 2', 1, 2),
(3, 'images/crousel/3.jpeg', 'Slide 3', 1, 3),
(4, 'images/crousel/4.jpeg', 'Slide 4', 1, 4);

INSERT INTO `lodges` (`id`, `name`, `tier`, `blurb`, `price_min`, `price_max`, `rating`, `features`, `facilities`, `max_adults`, `max_children`, `units`, `image`, `show_on_home`, `is_active`, `sort_order`) VALUES
(1, 'The Nirvana Pavilion', 'Signature', 'Spacious signature comfort with a king bed and private bath, built for an easy, relaxed stay.', 5000, 9000, 4.0, 'Spacious Deluxe Rooms\nKing size Bed\nPrivate Bathroom\nWardrobe and closet', 'High-speed Wi-Fi\nAir Conditioning\nStreaming Smart TV\nWork Desk and Chair', 6, 4, 1, 'images/lodge/1.jpeg', 1, 1, 1),
(2, 'The Panorama Suite', 'Premier', 'Wide dual-view windows and a lounge seating area for a bright, elevated stay in the valley.', 10000, 15000, 3.5, 'King size Bed\nCove lighting\nDual view windows\nCushioned bench seating', 'Lounge area with seating\n5-G Wi-Fi\nAir Conditioning\nGlass top coffee table', 7, 3, 1, 'images/lodge/2.jpeg', 1, 1, 2),
(3, 'The Regal Canopy Lodge', 'Grand Reserve', 'Grand Reserve indulgence with a private platform, canopy bed, and dedicated butler service.', 18000, 23000, 4.5, 'Curved Floor Ceiling\nElevated private platform\nFour Poster bed\nMirror paneled accent wall', 'Special Butler Service\nRound coffee table\nIn room mini-bar\nHigh-speed Wi-Fi', 8, 6, 1, 'images/lodge/3.jpeg', 1, 1, 3),
(4, 'The Willow Brook Cabin', 'Signature', 'A rustic wood-lined cabin with a quiet reading nook, perfect for a simple getaway.', 4500, 7500, NULL, 'Queen size Bed\nRustic wood interiors', 'High-speed Wi-Fi\nAir Conditioning', 4, 2, 1, 'images/lodge/4.jpg', 0, 1, 4),
(5, 'The Meadow Vista Room', 'Signature', 'Garden-facing balcony room with a private sitting area overlooking open meadow.', 6000, 8500, NULL, 'King size Bed\nGarden facing balcony', 'High-speed Wi-Fi\nSmart TV', 5, 3, 1, 'images/lodge/5.png', 0, 1, 5),
(6, 'The Orchard View Suite', 'Premier', 'Orchard-facing windows and a walk-in closet, with an in-room espresso setup.', 9500, 13000, NULL, 'King size Bed\nOrchard facing windows', 'Lounge seating\nEspresso machine', 6, 4, 1, 'images/lodge/6.png', 0, 1, 6),
(7, 'The Cellar Loft', 'Premier', 'A split-level loft with an exposed stone wall and a private balcony retreat.', 11000, 14500, NULL, 'Split level layout\nPrivate balcony', 'In room mini-bar\nHigh-speed Wi-Fi', 5, 2, 1, 'images/lodge/7.png', 0, 1, 7),
(8, 'The Vineyard Terrace Lodge', 'Grand Reserve', 'Private vineyard terrace living with a soaking tub and full butler service.', 16000, 20000, NULL, 'Private vineyard terrace\nSoaking tub', 'Butler Service\nIn room mini-bar', 6, 4, 1, 'images/lodge/8.png', 0, 1, 8),
(9, 'The Harvest Moon Retreat', 'Grand Reserve', 'Our largest retreat, a multi-room stay built for bigger families and gatherings.', 20000, 26000, NULL, 'Multi-room retreat\nCanopy Poster bed', 'Butler Service\nPrivate dining setup', 10, 6, 1, 'images/lodge/9.png', 0, 1, 9),
(10, 'The Garden Folly Cottage', 'Signature', 'A cottage-style stay with a garden patio, ideal for a slower kind of weekend.', 5500, 8000, NULL, 'Cottage style interiors\nGarden facing patio', 'High-speed Wi-Fi\nTea station', 4, 3, 1, 'images/lodge/10.png', 0, 1, 10);

INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES
('schema_version', '3');

INSERT INTO `team_members` (`id`, `name`, `role`, `note`, `icon`, `image`, `sort_order`) VALUES
(1, 'Meet Ranpura', 'General Manager', 'Oversees every stay from arrival to departure, making sure nothing here ever feels routine.', 'fa-solid fa-key', 'images/about/person1.jpeg', 1),
(2, 'Jaydeep Chawla', 'Head Chef', 'Builds every breakfast and evening menu around what\'s fresh in the valley that week.', 'fa-solid fa-utensils', 'images/about/person2.jpeg', 2),
(3, 'Bhavesh Yadav', 'Head Desk Manager', 'The first call for reservations, local tips, and anything a guest needs arranged.', 'fa-solid fa-concierge-bell', 'images/about/person3.jpeg', 3),
(4, 'Dhruv Vyas', 'Guest Relations Handler', 'The familiar face at check-in, and the one who remembers how you take your coffee.', 'fa-solid fa-handshake', 'images/about/person4.jpeg', 4);

INSERT INTO `testimonials` (`id`, `name`, `review`, `rating`, `is_active`, `sort_order`) VALUES
(2, 'Mackenzie Fraser', 'Beautiful property, quiet and peaceful just like the name promises. Rooftop bar at sunset is unmissable.', 4, 1, 2),
(3, 'Rohan Malhotra', 'Booked the Panorama Suite for our anniversary and the staff went out of their way to make it special. Will be back.', 5, 1, 3),
(4, 'Charlotte Bélanger', 'Loved the location in the Annapolis Valley, peaceful mornings with coffee on the balcony. Wifi could be a touch faster.', 4, 1, 4),
(5, 'Ishaan Verma', 'The Regal Canopy Lodge is worth every penny. Butler service felt genuinely personal, not scripted.', 5, 1, 5),
(6, 'Emily Thompson', 'Clean, comfortable, and the pool area is gorgeous at golden hour. Would\'ve liked more late-night dining options.', 4, 1, 6),
(7, 'Priya Nair', 'Check-in was seamless and the room upgrade they gave us was a wonderful surprise. Highly recommend the spa.', 5, 1, 7),
(8, 'Liam O\'Connell', 'Nice stay overall, though our room\'s AC was a little noisy at night. Staff fixed it quickly when we mentioned it.', 3, 1, 8),
(9, 'Sanya Kapoor', 'Honestly one of the best hotel experiences we\'ve had, the EV charging station was a nice bonus for our road trip too.', 5, 1, 9);
