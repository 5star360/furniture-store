<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
requireAdmin();
$adminPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($adminTitle) ? htmlspecialchars($adminTitle) . ' – Admin' : 'Admin Panel' ?> | Pivot Home</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/furniture-store/assets/css/style.css">
</head>
<body>
<div class="admin-layout">
  <!-- Sidebar -->
  <aside class="admin-sidebar">
    <div class="sidebar-brand">🛋️ Pivot Home</div>
    <div class="sidebar-user">
      <strong><?= htmlspecialchars($_SESSION['name']) ?></strong>
      Administrator
    </div>
    <nav class="sidebar-nav">
      <span class="nav-section">Overview</span>
      <a href="/furniture-store/admin/dashboard.php" class="<?= $adminPage === 'dashboard' ? 'active' : '' ?>">
        📊 Dashboard
      </a>
      <span class="nav-section">Products</span>
      <a href="/furniture-store/admin/products.php" class="<?= $adminPage === 'products' ? 'active' : '' ?>">
        🛋️ All Products
      </a>
      <a href="/furniture-store/admin/add_product.php" class="<?= $adminPage === 'add_product' ? 'active' : '' ?>">
        ➕ Add Product
      </a>
      <span class="nav-section">Users</span>
      <a href="/furniture-store/admin/users.php" class="<?= $adminPage === 'users' ? 'active' : '' ?>">
        👥 All Users
      </a>
      <span class="nav-section">Site</span>
      <a href="/furniture-store/index.php">🏠 View Store</a>
    </nav>
    <div class="sidebar-footer">
      <a href="/furniture-store/logout.php" class="btn btn-outline btn-sm" style="width:100%;justify-content:center;">
        Logout
      </a>
    </div>
  </aside>
  <!-- Main -->
  <div class="admin-main">
    <div class="admin-topbar">
      <h1><?= isset($adminTitle) ? htmlspecialchars($adminTitle) : 'Dashboard' ?></h1>
      <div style="display:flex;align-items:center;gap:10px;font-size:.85rem;color:var(--text-muted);">
        <span>👤 <?= htmlspecialchars($_SESSION['name']) ?></span>
        <span class="nav-badge">Admin</span>
      </div>
    </div>
    <div class="admin-content">
