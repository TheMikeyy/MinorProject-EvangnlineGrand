<?php
/*
 * Every piece of text / image on the public website that the admin can change from
 * Admin > Site Content is declared here, together with its ORIGINAL value (the default).
 *
 * - The website shows the value saved in the database, or this default if nothing was saved yet.
 * - To make ANOTHER piece of text editable: add a line here, then use setting('your_key') in the page.
 * - Field types: text, textarea, image, url, icon, map
 */
$f = function (string $key, string $label, string $type, string $default, string $help = ''): array {
    return ['key' => $key, 'label' => $label, 'type' => $type, 'default' => $default, 'help' => $help];
};

return [
  'general' => [
    'label' => 'Hotel & Contact', 'icon' => 'fa-solid fa-hotel', 'desc' => 'Name, phone numbers, address, map, opening hours and social media. These appear on every page (header, footer, contact page, home page).',
    'groups' => [
    ['title' => 'Hotel identity', 'note' => '', 'fields' => [
      $f('hotel_name', 'Hotel name', 'text', 'Évangéline Grand', 'Used in the browser tab title, footer and image descriptions.'),
      $f('footer_about', 'Footer description', 'textarea', 'The perfect mix of reliable comfort and warm, genuine hospitality. Our peaceful lodges give you exactly what you need for a restful night\'s sleep.', 'The short paragraph under the hotel name in the footer.'),
    ]],
    ['title' => 'Contact details', 'note' => '', 'fields' => [
      $f('phone', 'Phone number (main)', 'text', '+91 90165 88906'),
      $f('phone2', 'Phone number (second, optional)', 'text', '+1 902 555 0198', 'Leave empty to hide it on the Contact page.'),
      $f('email', 'Email address', 'text', 'stay@evangelinegrand.com'),
      $f('address', 'Address', 'textarea', 'Grand Pré, Annapolis Valley, Nova Scotia, Canada'),
      $f('map_embed_url', 'Google Map', 'map', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2816.1670154276353!2d-64.30946076511229!3d45.10268230000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4b58559db9646275%3A0xcca6eaa98adc0353!2sThe%20Evangeline%20Hotel!5e0!3m2!1sen!2sin!4v1784649732488!5m2!1sen!2sin', 'On Google Maps: Share > Embed a map > Copy HTML. Paste the whole code here (or just the link inside src="...").'),
    ]],
    ['title' => 'Opening hours (home page "Locate us")', 'note' => 'Leave a name empty to hide that row.', 'fields' => [
      $f('hours1_label', 'Row 1 - name', 'text', 'Reception'),
      $f('hours1_value', 'Row 1 - time', 'text', '24 / 7'),
      $f('hours2_label', 'Row 2 - name', 'text', 'Concierge desk'),
      $f('hours2_value', 'Row 2 - time', 'text', '7:00 am To 11:00 pm'),
      $f('hours3_label', 'Row 3 - name', 'text', 'Rooftop Bar'),
      $f('hours3_value', 'Row 3 - time', 'text', '5:00 pm To 1:00 am'),
    ]],
    ['title' => 'Social media links', 'note' => '', 'fields' => [
      $f('social_instagram', 'Instagram', 'url', '', 'Full link, e.g. https://instagram.com/yourhotel. Empty = link does nothing.'),
      $f('social_facebook', 'Facebook', 'url', ''),
      $f('social_youtube', 'YouTube', 'url', ''),
      $f('social_x', 'X (Twitter)', 'url', ''),
    ]],
    ],
  ],
  'logos' => [
    'label' => 'Logos', 'icon' => 'fa-solid fa-image', 'desc' => 'The logo images used on the website. Upload a new file to replace one; tick "Restore original" to go back to the design default.',
    'groups' => [
    ['title' => 'Website logos', 'note' => '', 'fields' => [
      $f('logo_dark', 'Navbar logo (transparent bar, over photos)', 'image', 'images/logo/logo-dark.png'),
      $f('logo_light', 'Navbar logo (after scrolling)', 'image', 'images/logo/logo-light.png'),
      $f('logo_hero', 'Big logo on page banners', 'image', 'images/logo/logo-hero-body.png'),
    ]],
    ],
  ],
  'home' => [
    'label' => 'Home page', 'icon' => 'fa-solid fa-house', 'desc' => 'Headings and background image of the home page. The slideshow photos, lodge cards, comforts and reviews are managed from their own menu items.',
    'groups' => [
    ['title' => 'Top banner', 'note' => '', 'fields' => [
      $f('hero_welcome', 'Small script text above the logo', 'text', 'Welcome To The'),
      $f('hero_tagline', 'Tagline under the logo', 'textarea', 'The perfect mix of reliable comfort and warm, genuine hospitality & a restful night\'s sleep, exactly as it should be.', 'The slideshow photos are changed in "Home Slideshow".'),
    ]],
    ['title' => 'Section headings', 'note' => '', 'fields' => [
      $f('home_lodges_title', 'Lodges section title', 'text', 'PREVIEW OUR LODGES', 'Which lodges appear here is chosen in the Lodges menu ("Show on home page").'),
      $f('home_conv_eyebrow', 'Convenience section - small text', 'text', 'Where Every Comfort Is Considered'),
      $f('home_conv_title', 'Convenience section - title', 'text', 'OUR CONVENIENCE'),
      $f('home_reviews_title', 'Reviews section title', 'text', 'TESTIMONIALS'),
      $f('home_locate_title', 'Locate-us section title', 'text', 'LOCATE US'),
      $f('locate_bg', 'Locate-us background photo', 'image', 'images/crousel/5.jpeg'),
    ]],
    ],
  ],
  'lodgespage' => [
    'label' => 'Lodges page', 'icon' => 'fa-solid fa-bed', 'desc' => 'Banner and introduction of the "Our Lodges" page. The lodges themselves are added/edited in the Lodges menu.',
    'groups' => [
    ['title' => 'Lodges page', 'note' => '', 'fields' => [
      $f('lodges_banner', 'Banner photo', 'image', 'images/lodge/hallway.jpg'),
      $f('lodges_eyebrow', 'Small text above title', 'text', 'Find Your Retreat'),
      $f('lodges_title', 'Title', 'text', 'ALL LODGES'),
      $f('lodges_intro', 'Introduction paragraph', 'textarea', 'From cozy signature rooms to the fully attended Grand Reserve, every lodge here is shaped around a slower kind of stay. Filter by dates, party size, and budget to find the one that fits.'),
    ]],
    ],
  ],
  'comfortspage' => [
    'label' => 'Comforts page', 'icon' => 'fa-solid fa-mug-saucer', 'desc' => 'Banner, introduction and the call-to-action of the Comforts page. The comfort cards are edited in the Comforts menu.',
    'groups' => [
    ['title' => 'Banner & introduction', 'note' => '', 'fields' => [
      $f('comforts_banner', 'Banner photo', 'image', 'images/comforts/entry.jpeg'),
      $f('comforts_title', 'Title', 'text', 'Your Comfort Zone Might Be Here'),
      $f('comforts_intro', 'Introduction paragraph', 'textarea', 'Every stay here is built around the little things that make it feel effortless and thoughtful comforts, quiet luxuries, and details attended to before you even ask. This is where rest comes easy and every need is already taken care of.'),
    ]],
    ['title' => 'Signature comforts heading', 'note' => '', 'fields' => [
      $f('signature_eyebrow', 'Small text', 'text', 'A Little Further, A Little Deeper'),
      $f('signature_title', 'Title', 'text', 'OUR SIGNATURE COMFORTS'),
    ]],
    ['title' => 'Bottom call-to-action', 'note' => '', 'fields' => [
      $f('cta_title', 'Title', 'text', 'Ready to experience it yourself?'),
      $f('cta_text', 'Text', 'text', 'Reserve your stay and let every detail take care of itself.'),
      $f('cta_button', 'Button text', 'text', 'Book Your Stay'),
      $f('cta_bg', 'Background photo', 'image', 'images/comforts/entrycloseup.jpeg'),
    ]],
    ],
  ],
  'aboutpage' => [
    'label' => 'About page', 'icon' => 'fa-solid fa-circle-info', 'desc' => 'Everything on the About page except the team members (those have their own menu item).',
    'groups' => [
    ['title' => 'Banner & introduction', 'note' => '', 'fields' => [
      $f('about_banner', 'Banner photo', 'image', 'images/about/aboutbanner.jpeg'),
      $f('about_title', 'Title', 'text', 'Story Behind ÉVANGÉLINE GRAND'),
      $f('about_text', 'Introduction paragraph', 'textarea', 'Tucked into the quiet folds of the Annapolis Valley, Évangéline Grand was built on a simple idea, that hospitality should feel personal, not performed. Every room, every meal, and every small gesture here is shaped around that belief.'),
    ]],
    ['title' => 'Story block 1', 'note' => '', 'fields' => [
      $f('story1_image', 'Photo', 'image', 'images/about/story1.jpeg'),
      $f('story1_tag', 'Small label', 'text', 'How It Began'),
      $f('story1_title', 'Heading', 'text', 'A Home Before It Was A Hotel'),
      $f('story1_text', 'Text', 'textarea', 'Évangéline Grand started as a family estate, passed down through generations who loved this stretch of the valley enough to keep it standing. What began as a private retreat slowly opened its doors, first to friends, then to guests, until it became the property it is today. Still run with the same care as when it was simply home.'),
    ]],
    ['title' => 'Story block 2', 'note' => '', 'fields' => [
      $f('story2_image', 'Photo', 'image', 'images/about/story2.jpeg'),
      $f('story2_tag', 'Small label', 'text', 'Where We Are Now'),
      $f('story2_title', 'Heading', 'text', 'Hospitality, Done Quietly'),
      $f('story2_text', 'Text', 'textarea', 'Today, we welcome travelers from across the world into a handful of signature lodges, each designed to feel more like a considered retreat than a hotel room. We keep things intentionally small, so every stay can still be shaped around the person having it.'),
    ]],
    ['title' => 'Numbers (4 counters)', 'note' => '', 'fields' => [
      $f('stat1_number', 'Counter 1 - number', 'text', '15+'),
      $f('stat1_label', 'Counter 1 - label', 'text', 'Years Hosting'),
      $f('stat2_number', 'Counter 2 - number', 'text', '5+'),
      $f('stat2_label', 'Counter 2 - label', 'text', 'Signature Lodges'),
      $f('stat3_number', 'Counter 3 - number', 'text', '4.8'),
      $f('stat3_label', 'Counter 3 - label', 'text', 'Average Rating'),
      $f('stat4_number', 'Counter 4 - number', 'text', '13k+'),
      $f('stat4_label', 'Counter 4 - label', 'text', 'Guests Welcomed'),
    ]],
    ['title' => 'Our values', 'note' => '', 'fields' => [
      $f('values_eyebrow', 'Small text', 'text', 'What Inspires Us'),
      $f('values_title', 'Title', 'text', 'OUR VALUES'),
    ]],
    ['title' => 'Value card 1', 'note' => '', 'fields' => [
      $f('value1_icon', 'Icon', 'icon', 'fa-solid fa-heart', 'Font Awesome class, e.g. "fa-solid fa-heart". Find icons at fontawesome.com/icons (free ones).'),
      $f('value1_title', 'Title', 'text', 'Genuine Hospitality'),
      $f('value1_text', 'Text', 'textarea', 'Warmth that isn\'t scripted & every member of our team is here because they care about the guests in front of them.'),
    ]],
    ['title' => 'Value card 2', 'note' => '', 'fields' => [
      $f('value2_icon', 'Icon', 'icon', 'fa-solid fa-leaf', 'Font Awesome class, e.g. "fa-solid fa-heart". Find icons at fontawesome.com/icons (free ones).'),
      $f('value2_title', 'Title', 'text', 'Rooted In Place'),
      $f('value2_text', 'Text', 'textarea', 'We work closely with local growers, makers, and craftsmen, so a stay here also feels like a stay in the valley itself.'),
    ]],
    ['title' => 'Value card 3', 'note' => '', 'fields' => [
      $f('value3_icon', 'Icon', 'icon', 'fa-solid fa-gem', 'Font Awesome class, e.g. "fa-solid fa-heart". Find icons at fontawesome.com/icons (free ones).'),
      $f('value3_title', 'Title', 'text', 'Considered Detail'),
      $f('value3_text', 'Text', 'textarea', 'From linens to lighting, nothing here is an afterthought. Every detail is chosen, not defaulted to.'),
    ]],
    ['title' => 'Team section heading', 'note' => 'The 4 team members are edited in the Team menu.', 'fields' => [
      $f('team_eyebrow', 'Small text', 'text', 'The People Behind The Grand'),
      $f('team_title', 'Title', 'text', 'MEET OUR TEAM'),
    ]],
    ],
  ],
  'contactpage' => [
    'label' => 'Contact page', 'icon' => 'fa-solid fa-envelope', 'desc' => 'Banner, text and card photos of the Contact page. Address, phone, email and map come from "Hotel & Contact".',
    'groups' => [
    ['title' => 'Contact page', 'note' => '', 'fields' => [
      $f('contact_banner', 'Banner photo', 'image', 'images/contact/front.jpeg'),
      $f('contact_eyebrow', 'Small text above title', 'text', 'Reach Out'),
      $f('contact_title', 'Title', 'text', 'GET IN TOUCH'),
      $f('contact_intro', 'Introduction paragraph', 'textarea', 'Whether it\'s a question before you book, a request for your upcoming stay, or simply directions to the valley, our team is on hand to help. Find us on the map below, or send a message directly.'),
      $f('contact_cap1', 'Photo on the "Visit Us" card', 'image', 'images/contact/cap1.jpeg'),
      $f('contact_cap2', 'Photo on the "Send A Message" card', 'image', 'images/contact/cap2.jpeg'),
    ]],
    ],
  ],
  'booking' => [
    'label' => 'Bookings & Email', 'icon' => 'fa-solid fa-calendar-check', 'desc' => 'Rules for online bookings and where booking / message alerts are sent.',
    'groups' => [
    ['title' => 'Booking rules', 'note' => 'These appear on the booking page and in booking e-mails.', 'fields' => [
      $f('check_in_time', 'Check-in time', 'text', '2:00 PM'),
      $f('check_out_time', 'Check-out time', 'text', '11:00 AM'),
      $f('max_nights', 'Maximum nights per booking', 'number', '14', 'A whole number from 1 to 90.'),
      $f('tax_percent', 'Tax added to every booking (%)', 'number', '0', 'Enter 0 for no tax, or e.g. 12 for 12%. Shown separately on the booking.'),
      $f('booking_policy', 'Booking & payment notes', 'textarea', 'Payment is collected at the hotel during check-in. Please carry a valid photo ID. You can cancel from My Bookings any time before your check-in date.', 'Shown to guests before they confirm a booking.'),
    ]],
    ['title' => 'Alerts', 'note' => 'E-mail sending is connected later: until then every e-mail is saved in Email Log.', 'fields' => [
      $f('notify_email', 'Alert e-mail (new bookings and contact messages)', 'text', '', 'Leave empty to use the hotel e-mail from "Hotel & Contact".'),
    ]],
    ],
  ],
];
