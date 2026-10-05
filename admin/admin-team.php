<?php
require_once 'admin-include/db_config.php';
require_admin();

$cfg = [
    'table'     => 'team_members',
    'page'      => 'admin-team.php',
    'title'     => 'Team',
    'singular'  => 'team member',
    'active'    => 'team',
    'intro'     => 'The people shown in "Meet our team" on the About page (4 look best). Change a photo, name, role or description, or add / remove people.',
    'fields'    => [
        ['name' => 'name',  'label' => 'Name',        'type' => 'text', 'required' => true, 'col' => 6, 'max' => 100],
        ['name' => 'role',  'label' => 'Role / job title', 'type' => 'text', 'required' => true, 'col' => 6, 'max' => 100, 'help' => 'e.g. General Manager'],
        ['name' => 'note',  'label' => 'Short description', 'type' => 'textarea', 'rows' => 3, 'max' => 300, 'help' => 'One sentence shown on the card.'],
        ['name' => 'icon',  'label' => 'Small badge icon', 'type' => 'icon', 'max' => 80, 'default' => 'fa-solid fa-user', 'col' => 6, 'list' => ['fa-solid fa-key', 'fa-solid fa-utensils', 'fa-solid fa-concierge-bell', 'fa-solid fa-handshake', 'fa-solid fa-user', 'fa-solid fa-star'],
         'help' => 'Font Awesome class shown in the corner of the card.'],
        ['name' => 'image', 'label' => 'Photo', 'type' => 'image', 'required' => true],
    ],
    'card' => function (array $r): array {
        return ['title' => $r['name'], 'sub' => $r['role'], 'image' => $r['image'], 'badges' => []];
    },
];
require_once 'admin-include/crud.php';
