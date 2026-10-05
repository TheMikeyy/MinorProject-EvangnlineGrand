<?php
require_once 'admin-include/db_config.php';
require_admin();

$cfg = [
    'table'        => 'comforts',
    'page'         => 'admin-comforts.php',
    'title'        => 'Comforts',
    'singular'     => 'comfort',
    'active'       => 'comforts',
    'intro'        => 'Amenities shown on the Comforts page, and in the "Our convenience" strip on the home page. Use the arrows to change the order.',
    'form_intro'   => 'Choose where it appears: as a card, or as a large "signature" row with a big photo.',
    'group'        => 'section',
    'group_labels' => ['card' => 'Comfort cards', 'signature' => 'Signature comforts (large rows)'],
    'fields'       => [
        ['name' => 'title',        'label' => 'Title',        'type' => 'text', 'required' => true, 'col' => 8, 'max' => 120],
        ['name' => 'section',      'label' => 'Show as',      'type' => 'select', 'col' => 4, 'options' => ['card' => 'Card (small)', 'signature' => 'Signature row (large)']],
        ['name' => 'description',  'label' => 'Description',  'type' => 'textarea', 'rows' => 4, 'required' => true, 'max' => 600],
        ['name' => 'icon',         'label' => 'Icon',         'type' => 'icon', 'col' => 6, 'max' => 80, 'default' => 'fa-solid fa-star',
         'help' => 'Font Awesome class, e.g. "fa-solid fa-wifi". Browse free icons at fontawesome.com/icons. Used on cards and in the home-page strip.'],
        ['name' => 'tag',          'label' => 'Small label (signature rows only)', 'type' => 'text', 'col' => 6, 'max' => 60, 'help' => 'e.g. Wellness, Personal Service'],
        ['name' => 'image',        'label' => 'Photo',        'type' => 'image', 'required' => true],
        ['name' => 'show_on_home', 'label' => 'Also show in the home page "Our convenience" strip', 'type' => 'checkbox'],
        ['name' => 'is_active',    'label' => 'Visible on the website', 'type' => 'checkbox', 'default' => 1],
    ],
    'card' => function (array $r): array {
        $b = [];
        if ($r['show_on_home']) { $b[] = ['On home page', 'good']; }
        if (!$r['is_active'])   { $b[] = ['Hidden', 'warn']; }
        return ['title' => $r['title'], 'sub' => mb_strimwidth($r['description'], 0, 70, '…'), 'image' => $r['image'], 'badges' => $b];
    },
];
require_once 'admin-include/crud.php';
