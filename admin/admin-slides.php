<?php
require_once 'admin-include/db_config.php';
require_admin();

$cfg = [
    'table'     => 'hero_slides',
    'page'      => 'admin-slides.php',
    'title'     => 'Home Slideshow',
    'singular'  => 'slide',
    'active'    => 'slides',
    'intro'     => 'The big photos that fade in and out at the top of the home page. Use wide, landscape photos (about 1920 x 800).',
    'fields'    => [
        ['name' => 'image',     'label' => 'Photo', 'type' => 'image', 'required' => true],
        ['name' => 'caption',   'label' => 'Description of the photo (for accessibility)', 'type' => 'text', 'max' => 150, 'help' => 'Optional, e.g. "Sunset over the valley".'],
        ['name' => 'is_active', 'label' => 'Visible on the website', 'type' => 'checkbox', 'default' => 1],
    ],
    'card' => function (array $r): array {
        $b = $r['is_active'] ? [] : [['Hidden', 'warn']];
        return ['title' => $r['caption'] !== '' ? $r['caption'] : 'Slide', 'sub' => '', 'image' => $r['image'], 'badges' => $b];
    },
];
require_once 'admin-include/crud.php';
