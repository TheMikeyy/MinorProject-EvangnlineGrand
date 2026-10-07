-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2026 at 08:35 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `evangelinewebsite`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_cred`
--

CREATE TABLE `admin_cred` (
  `sr_no` int(11) NOT NULL,
  `admin_mail` varchar(150) NOT NULL,
  `admin_pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_cred`
--

INSERT INTO `admin_cred` (`sr_no`, `admin_mail`, `admin_pass`) VALUES
(1, 'admin.evangelinegrand.com', '$2y$10$3OxzvtmTpNDi1bUZAeHXreP6.PeKZlNKH7rO51mNqs65qKo4TpTtO');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `ref` varchar(20) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `lodge_id` int(11) DEFAULT NULL,
  `lodge_name` varchar(120) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `nights` int(11) NOT NULL,
  `adults` int(11) NOT NULL DEFAULT 1,
  `children` int(11) NOT NULL DEFAULT 0,
  `std_nights` int(11) NOT NULL DEFAULT 0,
  `peak_nights` int(11) NOT NULL DEFAULT 0,
  `std_rate` int(11) NOT NULL DEFAULT 0,
  `peak_rate` int(11) NOT NULL DEFAULT 0,
  `subtotal` int(11) NOT NULL DEFAULT 0,
  `tax_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `tax_amount` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `special_requests` text DEFAULT NULL,
  `status` varchar(12) NOT NULL DEFAULT 'pending',
  `source` varchar(10) NOT NULL DEFAULT 'online',
  `guest_name` varchar(100) NOT NULL DEFAULT '',
  `guest_email` varchar(150) NOT NULL DEFAULT '',
  `guest_phone` varchar(25) NOT NULL DEFAULT '',
  `admin_note` text DEFAULT NULL,
  `cancelled_by` varchar(10) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comforts`
--

CREATE TABLE `comforts` (
  `id` int(11) NOT NULL,
  `section` varchar(20) NOT NULL DEFAULT 'card',
  `title` varchar(120) NOT NULL,
  `description` text DEFAULT NULL,
  `tag` varchar(60) NOT NULL DEFAULT '',
  `icon` varchar(80) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL,
  `show_on_home` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comforts`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_log`
--

CREATE TABLE `email_log` (
  `id` int(11) NOT NULL,
  `to_email` varchar(150) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `body` text NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'queued',
  `error` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hero_slides`
--

CREATE TABLE `hero_slides` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `caption` varchar(150) NOT NULL DEFAULT '',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hero_slides`
--

INSERT INTO `hero_slides` (`id`, `image`, `caption`, `is_active`, `sort_order`) VALUES
(1, 'images/crousel/1.jpeg', 'Slide 1', 1, 1),
(2, 'images/crousel/2.jpeg', 'Slide 2', 1, 2),
(3, 'images/crousel/3.jpeg', 'Slide 3', 1, 3),
(4, 'images/crousel/4.jpeg', 'Slide 4', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `lodges`
--

CREATE TABLE `lodges` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `tier` varchar(60) NOT NULL DEFAULT '',
  `blurb` text DEFAULT NULL,
  `price_min` int(11) NOT NULL DEFAULT 0,
  `price_max` int(11) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `features` text DEFAULT NULL,
  `facilities` text DEFAULT NULL,
  `max_adults` int(11) NOT NULL DEFAULT 2,
  `max_children` int(11) NOT NULL DEFAULT 0,
  `units` int(11) NOT NULL DEFAULT 1,
  `image` varchar(255) NOT NULL,
  `show_on_home` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lodges`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `email` varchar(150) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token_hash` char(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `used_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `setting_key` varchar(60) NOT NULL,
  `setting_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES
('schema_version', '3');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `note` varchar(300) NOT NULL DEFAULT '',
  `icon` varchar(80) NOT NULL DEFAULT 'fa-solid fa-user',
  `image` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `name`, `role`, `note`, `icon`, `image`, `sort_order`) VALUES
(1, 'Meet Ranpura', 'General Manager', 'Oversees every stay from arrival to departure, making sure nothing here ever feels routine.', 'fa-solid fa-key', 'images/about/person1.jpeg', 1),
(2, 'Jaydeep Chawla', 'Head Chef', 'Builds every breakfast and evening menu around what\'s fresh in the valley that week.', 'fa-solid fa-utensils', 'images/about/person2.jpeg', 2),
(3, 'Bhavesh Yadav', 'Head Desk Manager', 'The first call for reservations, local tips, and anything a guest needs arranged.', 'fa-solid fa-concierge-bell', 'images/about/person3.jpeg', 3),
(4, 'Dhruv Vyas', 'Guest Relations Handler', 'The familiar face at check-in, and the one who remembers how you take your coffee.', 'fa-solid fa-handshake', 'images/about/person4.jpeg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `review` text NOT NULL,
  `rating` tinyint(4) NOT NULL DEFAULT 5,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `review`, `rating`, `is_active`, `sort_order`) VALUES
(2, 'Mackenzie Fraser', 'Beautiful property, quiet and peaceful just like the name promises. Rooftop bar at sunset is unmissable.', 4, 1, 2),
(3, 'Rohan Malhotra', 'Booked the Panorama Suite for our anniversary and the staff went out of their way to make it special. Will be back.', 5, 1, 3),
(4, 'Charlotte Bélanger', 'Loved the location in the Annapolis Valley, peaceful mornings with coffee on the balcony. Wifi could be a touch faster.', 4, 1, 4),
(5, 'Ishaan Verma', 'The Regal Canopy Lodge is worth every penny. Butler service felt genuinely personal, not scripted.', 5, 1, 5),
(6, 'Emily Thompson', 'Clean, comfortable, and the pool area is gorgeous at golden hour. Would\'ve liked more late-night dining options.', 4, 1, 6),
(7, 'Priya Nair', 'Check-in was seamless and the room upgrade they gave us was a wonderful surprise. Highly recommend the spa.', 5, 1, 7),
(8, 'Liam O\'Connell', 'Nice stay overall, though our room\'s AC was a little noisy at night. Staff fixed it quickly when we mentioned it.', 3, 1, 8),
(9, 'Sanya Kapoor', 'Honestly one of the best hotel experiences we\'ve had, the EV charging station was a nice bonus for our road trip too.', 5, 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(25) NOT NULL DEFAULT '',
  `address` varchar(300) NOT NULL DEFAULT '',
  `pincode` varchar(12) NOT NULL DEFAULT '',
  `dob` date DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `last_login_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_tokens`
--

CREATE TABLE `user_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `selector` char(18) NOT NULL,
  `token_hash` char(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_cred`
--
ALTER TABLE `admin_cred`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_ref` (`ref`),
  ADD KEY `idx_lodge_dates` (`lodge_id`,`status`,`check_in`,`check_out`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `comforts`
--
ALTER TABLE `comforts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_log`
--
ALTER TABLE `email_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hero_slides`
--
ALTER TABLE `hero_slides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lodges`
--
ALTER TABLE `lodges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ip` (`ip`,`created_at`),
  ADD KEY `idx_email` (`email`,`created_at`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_token` (`token_hash`),
  ADD KEY `idx_user` (`user_id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_email` (`email`);

--
-- Indexes for table `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_selector` (`selector`),
  ADD KEY `idx_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_cred`
--
ALTER TABLE `admin_cred`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comforts`
--
ALTER TABLE `comforts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_log`
--
ALTER TABLE `email_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hero_slides`
--
ALTER TABLE `hero_slides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lodges`
--
ALTER TABLE `lodges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_tokens`
--
ALTER TABLE `user_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
