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
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/furniture-store/assets/css/style.css">
<link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🛋️</text></svg>">
</head>
<body>

<header class="site-header">
  <nav class="nav-inner">
    <a href="/furniture-store/index.php" class="nav-logo">
      🛋️ Pivot Home
    </a>
    <div class="nav-links">
      <a href="/furniture-store/index.php" class="<?= $currentPage === 'index' ? 'active' : '' ?>">Shop</a>
      <?php if (isset($_SESSION['user_id'])): ?>
        <?php if ($_SESSION['role'] === 'admin'): ?>
          <a href="/furniture-store/admin/dashboard.php" class="<?= str_contains($_SERVER['PHP_SELF'], 'admin') ? 'active' : '' ?>">Dashboard</a>
        <?php endif; ?>
        <div class="nav-user">
          <span>👤 <strong><?= htmlspecialchars($_SESSION['name']) ?></strong></span>
          <span class="nav-badge"><?= ucfirst($_SESSION['role']) ?></span>
          <a href="/furniture-store/logout.php" class="btn-nav">Logout</a>
        </div>
      <?php else: ?>
        <a href="/furniture-store/login.php">Login</a>
        <a href="/furniture-store/register.php" class="btn-nav">Register</a>
      <?php endif; ?>
    </div>
  </nav>
</header>
