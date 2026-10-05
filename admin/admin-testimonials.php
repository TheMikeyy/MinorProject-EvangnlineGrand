<?php
require_once 'admin-include/db_config.php';
require_admin();

$cfg = [
    'table'     => 'testimonials',
    'page'      => 'admin-testimonials.php',
    'title'     => 'Guest Reviews',
    'singular'  => 'review',
    'active'    => 'testimonials',
    'intro'     => 'The guest reviews that slide across the home page. At least 6 reviews give the best animation.',
    'fields'    => [
        ['name' => 'name',      'label' => 'Guest name', 'type' => 'text', 'required' => true, 'col' => 8, 'max' => 100],
        ['name' => 'rating',    'label' => 'Stars',      'type' => 'select', 'col' => 4, 'options' => ['5' => '5 stars', '4' => '4 stars', '3' => '3 stars', '2' => '2 stars', '1' => '1 star']],
        ['name' => 'review',    'label' => 'Review text', 'type' => 'textarea', 'rows' => 4, 'required' => true, 'max' => 600],
        ['name' => 'is_active', 'label' => 'Visible on the website', 'type' => 'checkbox', 'default' => 1],
    ],
    'card' => function (array $r): array {
        $b = [[$r['rating'] . ' ★', '']];
        if (!$r['is_active']) { $b[] = ['Hidden', 'warn']; }
        return ['title' => $r['name'], 'sub' => mb_strimwidth($r['review'], 0, 90, '…'), 'icon' => 'fa-solid fa-quote-left', 'badges' => $b];
    },
];
require_once 'admin-include/crud.php';
