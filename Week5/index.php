<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';
requireLogin();

$pageTitle = 'Shop All Furniture';
$categories = ['Sofas','Chairs','Beds','Tables','Wardrobes','Shelves','Other'];

// Build query
$where = '1';
$params = [];
$types  = '';

$selectedCat = $_GET['cat'] ?? '';
if ($selectedCat && in_array($selectedCat, $categories)) {
    $where .= ' AND category = ?';
    $params[] = $selectedCat;
    $types   .= 's';
}

$sql = "SELECT * FROM products WHERE $where ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Count for stats
$totalProducts = $conn->query("SELECT COUNT(*) as c FROM products")->fetch_assoc()['c'];
include __DIR__ . '/includes/header.php';
?>

<!-- Hero -->
<section class="hero">
  <div class="hero-inner">
    <h1>Beautiful Furniture<br>for <em>Every Room</em></h1>
    <p>Discover our hand-curated collection of premium sofas, chairs, beds and more — crafted for modern Kenyan homes.</p>
    <div class="hero-actions">
      <a href="#catalog" class="btn btn-primary">Browse Collection</a>
      <?php if ($_SESSION['role'] === 'admin'): ?>
        <a href="/furniture-store/admin/dashboard.php" class="btn btn-ghost">Admin Dashboard</a>
      <?php endif; ?>
    </div>
  </div>
</section>

<main class="main-content" id="catalog">
  <div style="margin-bottom:32px;">
    <h2 class="section-title">
      <?= $selectedCat ? htmlspecialchars($selectedCat) : 'All Furniture' ?>
      <span style="font-size:.9rem;font-weight:400;color:var(--text-muted);margin-left:12px;">(<?= count($products) ?> items)</span>
    </h2>
    <p class="section-subtitle">Thoughtfully designed pieces for every corner of your home.</p>
  </div>

  <!-- Filter Bar -->
  <div class="filter-bar">
    <div class="search-wrap">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" id="productSearch" class="search-input" placeholder="Search furniture by name or description…">
    </div>
    <div class="category-filters">
      <button class="filter-btn <?= !$selectedCat ? 'active' : '' ?>" data-category="all">All</button>
      <?php foreach ($categories as $cat): ?>
        <button class="filter-btn <?= $selectedCat === $cat ? 'active' : '' ?>" data-category="<?= strtolower($cat) ?>"><?= $cat ?></button>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Products Grid -->
  <div class="products-grid" id="productsGrid">
    <?php if (empty($products)): ?>
      <div class="no-products" id="noProductsMsg">
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 7H4C2.895 7 2 7.895 2 9v11c0 1.105.895 2 2 2h16c1.105 0 2-.895 2-2V9c0-1.105-.895-2-2-2z"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
        <p style="font-size:1.1rem;font-weight:600;color:var(--brown);">No products found</p>
        <p>Try a different category or search term.</p>
      </div>
    <?php else: ?>
      <div id="noProductsMsg" class="no-products" style="display:none;grid-column:1/-1">
        <p style="font-size:1.1rem;font-weight:600;">No products match your search.</p>
        <p>Try a different keyword.</p>
      </div>
      <?php foreach ($products as $p): ?>
        <article class="product-card"
          data-name="<?= htmlspecialchars(strtolower($p['name'])) ?>"
          data-category="<?= htmlspecialchars(strtolower($p['category'])) ?>"
          data-desc="<?= htmlspecialchars(strtolower($p['description'])) ?>">
          <div class="card-img-wrap">
            <?php if ($p['image_url']): ?>
              <img src="<?= htmlspecialchars($p['image_url']) ?>"
                   alt="<?= htmlspecialchars($p['name']) ?>"
                   loading="lazy"
                   onerror="this.src='https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600'">
            <?php else: ?>
              <div style="height:100%;background:var(--grey-light);display:flex;align-items:center;justify-content:center;font-size:3rem;">🛋️</div>
            <?php endif; ?>
            <span class="card-category"><?= htmlspecialchars($p['category']) ?></span>
          </div>
          <div class="card-body">
            <h3 class="card-name"><?= htmlspecialchars($p['name']) ?></h3>
            <p class="card-desc"><?= htmlspecialchars($p['description']) ?></p>
          </div>
          <div class="card-footer">
            <div class="card-price">
              KES <?= number_format($p['price']) ?>
              <span>/item</span>
            </div>
            <a href="/furniture-store/product.php?id=<?= $p['id'] ?>" class="btn btn-dark btn-sm">View Details</a>
          </div>
        </article>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
