<?php
require_once 'admin-include/db_config.php';
require_admin();

$ratings = ['' => 'No rating shown'];
foreach ([5, 4.5, 4, 3.5, 3, 2.5, 2, 1.5, 1] as $r) { $ratings[(string)$r] = $r . ' star' . ($r == 1 ? '' : 's'); }

$cfg = [
    'table'     => 'lodges',
    'page'      => 'admin-lodge.php',
    'title'     => 'Lodges',
    'singular'  => 'lodge',
    'active'    => 'lodges',
    'intro'     => 'Every lodge / room shown on the "Our Lodges" page. Tick "Show on home page" to also put it in the "Preview our lodges" section. Use the arrows to change the order.',
    'form_intro'=> 'Everything guests see on the lodge card. Features and facilities: write one item per line.',
    'fields'    => [
        ['name' => 'name',         'label' => 'Lodge name',                       'type' => 'text',   'required' => true, 'col' => 8, 'max' => 120],
        ['name' => 'tier',         'label' => 'Category label',                   'type' => 'text',   'col' => 4, 'max' => 60, 'list' => ['Signature', 'Premier', 'Grand Reserve'], 'help' => 'e.g. Signature, Premier, Grand Reserve'],
        ['name' => 'blurb',        'label' => 'Short description',                'type' => 'textarea', 'rows' => 3, 'max' => 400, 'help' => 'One or two sentences, shown on the lodge card.'],
        ['name' => 'price_min',    'label' => 'Price from (₹ per night)',         'type' => 'number', 'required' => true, 'min' => 0, 'col' => 4],
        ['name' => 'price_max',    'label' => 'Price up to (₹ per night)',        'type' => 'number', 'nullable' => true, 'min' => 0, 'col' => 4, 'help' => 'Optional. Leave empty to show a single price.'],
        ['name' => 'rating',       'label' => 'Star rating',                      'type' => 'select', 'options' => $ratings, 'nullable' => true, 'col' => 4, 'help' => 'Shown on the home page card.'],
        ['name' => 'max_adults',   'label' => 'Maximum adults',                   'type' => 'number', 'required' => true, 'min' => 1, 'max_val' => 50, 'default' => 2, 'col' => 3],
        ['name' => 'max_children', 'label' => 'Maximum children',                 'type' => 'number', 'min' => 0, 'max_val' => 50, 'default' => 0, 'col' => 3],
        ['name' => 'features',     'label' => 'Features (one per line)',          'type' => 'textarea', 'rows' => 6, 'col' => 6, 'max' => 1500, 'help' => 'e.g. King size Bed'],
        ['name' => 'facilities',   'label' => 'Facilities (one per line)',        'type' => 'textarea', 'rows' => 6, 'col' => 6, 'max' => 1500, 'help' => 'e.g. High-speed Wi-Fi'],
        ['name' => 'image',        'label' => 'Lodge photo',                      'type' => 'image',  'required' => true],
        ['name' => 'show_on_home', 'label' => 'Show on home page ("Preview our lodges", maximum 6)', 'type' => 'checkbox'],
        ['name' => 'is_active',    'label' => 'Visible on the website',           'type' => 'checkbox', 'default' => 1, 'help' => 'Untick to hide this lodge without deleting it.'],
    ],
    'card' => function (array $r): array {
        $b = [];
        if ($r['show_on_home']) { $b[] = ['On home page', 'good']; }
        if (!$r['is_active'])   { $b[] = ['Hidden', 'warn']; }
        if ($r['rating'] !== null) { $b[] = [rtrim(rtrim((string)$r['rating'], '0'), '.') . ' ★', '']; }
        $b[] = [$r['max_adults'] . ' adults · ' . $r['max_children'] . ' children', ''];
        return ['title' => $r['name'], 'sub' => trim($r['tier'] . ' · ' . price_line($r['price_min'], $r['price_max']), ' ·'), 'image' => $r['image'], 'badges' => $b];
    },
];
require_once 'admin-include/crud.php';
