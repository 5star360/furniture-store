<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' – Pivot Home' : 'Pivot Home – Premium Furniture Store' ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/furniture-store/assets/css/style.css">
</head>
<body>
<header class="site-header">
  <nav class="nav-inner">
    <a href="/furniture-store/index.php" class="nav-logo">🛋️ Pivot Home</a>
    <div class="nav-links">
      <a href="/furniture-store/index.php">Shop</a>
      <a href="/furniture-store/login.php">Login</a>
      <a href="/furniture-store/register.php" class="btn-nav">Register</a>
    </div>
  </nav>
</header>
