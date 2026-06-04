<?php
require_once __DIR__ . '/includes/auth.php';
if (isLoggedIn()) {
    if (isAdmin()) {
        header('Location: /furniture-store/admin/dashboard.php');
    } else {
        header('Location: /furniture-store/index.php');
    }
} else {
    header('Location: /furniture-store/login.php');
}
exit;
