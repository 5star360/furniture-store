<?php
$adminTitle = 'Dashboard';
require_once __DIR__ . '/admin_header.php';

$totalProducts  = $conn->query("SELECT COUNT(*) as c FROM products")->fetch_assoc()['c'];
$totalUsers     = $conn->query("SELECT COUNT(*) as c FROM users")->fetch_assoc()['c'];
$totalCustomers = $conn->query("SELECT COUNT(*) as c FROM users WHERE role='customer'")->fetch_assoc()['c'];
$recentProducts = $conn->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);
$categoryStats  = $conn->query("SELECT category, COUNT(*) as cnt FROM products GROUP BY category ORDER BY cnt DESC")->fetch_all(MYSQLI_ASSOC);
?>

<!-- Stats -->
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon brown">🛋️</div>
    <div class="stat-info">
      <div class="stat-label">Total Products</div>
      <div class="stat-value"><?= $totalProducts ?></div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon rose">👥</div>
    <div class="stat-info">
      <div class="stat-label">Total Users</div>
      <div class="stat-value"><?= $totalUsers ?></div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon beige">🛍️</div>
    <div class="stat-info">
      <div class="stat-label">Customers</div>
      <div class="stat-value"><?= $totalCustomers ?></div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon brown">📦</div>
    <div class="stat-info">
      <div class="stat-label">Categories</div>
      <div class="stat-value"><?= count($categoryStats) ?></div>
    </div>
  </div>
</div>

<!-- Two columns -->
<div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;">

  <!-- Recent Products -->
  <div class="table-card">
    <div class="table-card-header">
      <h2>Recent Products</h2>
      <a href="/furniture-store/admin/add_product.php" class="btn btn-primary btn-sm">+ Add Product</a>
    </div>
    <table class="data-table">
      <thead>
        <tr>
          <th>Image</th>
          <th>Name</th>
          <th>Category</th>
          <th>Price</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($recentProducts as $p): ?>
        <tr>
          <td>
            <?php if ($p['image_url']): ?>
              <img class="td-img" src="<?= htmlspecialchars($p['image_url']) ?>" alt=""
                   onerror="this.style.display='none'">
            <?php else: ?>
              <span style="font-size:1.5rem;">🛋️</span>
            <?php endif; ?>
          </td>
          <td>
            <strong><?= htmlspecialchars($p['name']) ?></strong><br>
            <small style="color:var(--text-muted)"><?= date('d M Y', strtotime($p['created_at'])) ?></small>
          </td>
          <td><span style="background:var(--grey-light);padding:3px 10px;border-radius:20px;font-size:.78rem;font-weight:600;"><?= htmlspecialchars($p['category']) ?></span></td>
          <td><strong>KES <?= number_format($p['price']) ?></strong></td>
          <td>
            <div class="td-actions">
              <a href="/furniture-store/admin/edit_product.php?id=<?= $p['id'] ?>" class="btn btn-dark btn-sm">Edit</a>
              <a href="/furniture-store/admin/delete_product.php?id=<?= $p['id'] ?>" class="btn btn-danger btn-sm confirm-delete">Del</a>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div style="padding:16px 24px;border-top:1px solid var(--grey-light);">
      <a href="/furniture-store/admin/products.php" style="color:var(--rose);font-weight:600;font-size:.88rem;">View all products →</a>
    </div>
  </div>

  <!-- Category Breakdown -->
  <div class="table-card">
    <div class="table-card-header">
      <h2>By Category</h2>
    </div>
    <div style="padding:16px 0;">
      <?php foreach ($categoryStats as $cs): ?>
        <?php $pct = $totalProducts > 0 ? round($cs['cnt'] / $totalProducts * 100) : 0; ?>
        <div style="padding:10px 20px;">
          <div style="display:flex;justify-content:space-between;margin-bottom:5px;font-size:.85rem;">
            <span style="font-weight:600;color:var(--brown);"><?= htmlspecialchars($cs['category']) ?></span>
            <span style="color:var(--text-muted);"><?= $cs['cnt'] ?></span>
          </div>
          <div style="height:6px;background:var(--grey-light);border-radius:3px;">
            <div style="height:100%;width:<?= $pct ?>%;background:var(--rose);border-radius:3px;"></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

</div>

<?php require_once __DIR__ . '/admin_footer.php'; ?>
