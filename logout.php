<?php
require_once __DIR__ . '/admin/admin-include/db_config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    logout_user();
    toast_set('success', 'You have been logged out.');
}
redirect('index.php');
